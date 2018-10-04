<?php

namespace ctac\ssg;

require_once 'vendor/autoload.php';
require_once 'lib/autoload.php';

$_timers = [
    'default'   => [ [
        'time'=>microtime(true),
        'diff'       => 0,
        'diff-start' => 0,
        'diff-abs'   => 0,
        'caller'     => ['line'=>__LINE__]
    ] ]
];
timer();

$ssgStartTime      = 0;

$site = new StaticSiteGenerator('USA.gov');

$syncToDestination = false;
$fractalExamples   = false;

foreach ($argv as $arg) {
    if (isset($arg) && $arg=='--fresh-data') {
        $site->source->freshData = true;
    }
    if (isset($arg) && $arg=='--fresh-templates') {
        $site->templates->freshTemplates = true;
    }
    if (isset($arg) && $arg=='--no-debug-pages') {
        $site->renderer->renderPageOnFailure = false;
    }
    if (isset($arg) && $arg=='--deploy') {
        $syncToDestination = true;
    }
}

timer('Load Data');
$site->loadData();
timer('Load Data');

timer('Build');
$site->buildSiteTreeFromEntities();
timer('Build');

timer('Load Templates');
$site->loadTemplates();
timer('Load Templates');

timer('Render');
$site->renderSite();
timer('Render');

// timer('Validate');
// if ($site->validateSite() && $syncToDestination) {
    // timer('Validate');
if ( $syncToDestination )
{
    timer('Deploy');
    $site->destination->sync();
    timer('Deploy');
}

// timer();

// print_r(json_encode($site->pagesByUrl['/'],JSON_PRETTY_PRINT));

$size=memory_get_peak_usage(true);
$unit=['b','kb','mb','gb','tb','pb'];
$tunit=['sec','min','hour'];

timer();
$time = getTimer();

$output = [
    "Site"          => $site->config['siteName'],
    "FoundEntities" => count($site->source->entities),
    "FoundPages"    => count($site->pages),
    "MaxMemory"     => ( ( $size > 1 ) ? @round($size/pow(1024, ($i=floor(log($size, 1024)))), 2).' '.@$unit[$i]  : $size.' '.$unit[0]  ),
    "ExecutionTime" => ( ( $time > 1 ) ? @round($time/pow(60, ($i=floor(log($time, 60)))), 2).' '.@$tunit[$i] : $time.' '.$tunit[0] )
];

$site->log("\n===============");
$site->log("\nSite           : ". $output["Site"]);
$site->log("\nFound Entities : ". $output["FoundEntities"]);
$site->log("\nFound Pages    : ". $output["FoundPages"]);
$site->log("\nMax Memory     : ". $output["MaxMemory"]);
$site->log("\nExecution Time : ". $output["ExecutionTime"]);
$site->log("\n");
foreach (array_keys($_timers) as $name) {
    if ($name=='default') {
        continue;
    }
    $time = getTimer($name);
    $site->log("\n". str_pad($name, 14, ' ', STR_PAD_RIGHT) ." : ".
        ( ( $time > 1 ) ?
            str_pad(@round($time/pow(60, ($i=floor(log($time, 60)))), 2), 6, ' ', STR_PAD_RIGHT)
                .' '.@$tunit[$i]
            : str_pad(number_format($time, 2), 6, ' ', STR_PAD_RIGHT).' '.$tunit[0]
        ));
}
$site->log("\n\n");


// echo $site->logMessage;

// echo tprint();

function timer($name = 'default')
{
    global $_timers;
    $time     = microtime(true);
    $bt       = debug_backtrace();
    $caller   = array_shift($bt);
    $diff_abs = $time - $_timers['default'][0]['time'];
    if (!isset($_timers[$name])) {
        $_timers[$name] = [ [
            'time'       => $time,
            'diff'       => 0,
            'diff-start' => 0,
            'diff-abs'   => $diff_abs,
            'caller'     => $caller
        ] ];
    } else {
        $_timers[$name][] = [
            'time'       => $time,
            'diff'       => $time - $_timers[$name][count($_timers[$name])-1]['time'],
            'diff-start' => $time - $_timers[$name][0]['time'],
            'diff-abs'   => $diff_abs,
            'caller'     => $caller
        ];
    }
    return $diff_abs;
}
function tprint()
{
    global $_timers;
    $out = '';
    foreach ($_timers as $name => $times) {
        $out .= "==$name\n  last       start      global     line\n";
        foreach ($times as $time) {
            $out .= '  '.str_pad(number_format($time['diff'], 5, '.', ''), 10, ' ', STR_PAD_LEFT)
                    .' '.str_pad(number_format($time['diff-start'], 5, '.', ''), 10, ' ', STR_PAD_LEFT)
                    .' '.str_pad(number_format($time['diff-abs'], 5, '.', ''), 10, ' ', STR_PAD_LEFT)
                    .' '.$time['caller']['line']."\n";
        }
        $out .= "\n";
    }
    return $out;
}
function getTimer($name = 'default')
{
    global $_timers;
    return $_timers[$name][count($_timers[$name])-1]['diff-start'];
}
