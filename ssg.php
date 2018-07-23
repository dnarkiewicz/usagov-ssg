<?php

namespace ctac\ssg;

require_once 'vendor/autoload.php';
require_once 'lib/autoload.php';


$executionStartTime = microtime(true);

$siteName = 'USA.gov';
$site = new StaticSiteGenerator($siteName);

$fromSource     = false;
$freshTemplates = false;
$renderPageOnFailure = true;
$syncToDestination   = false;

foreach ( $argv as $arg )
{
    if ( isset($arg) && $arg=='--freshdata' )
    {
        $fromSource = true;
    }
    if ( isset($arg) && $arg=='--freshtemplates' )
    {
        $freshTemplates = true;
    }
    if ( isset($arg) && $arg=='--nodebugpages' )
    {
        $renderPageOnFailure = false;
    }
    if ( isset($arg) && $arg=='--sync' )
    {
        $syncToDestination = true;
    }
}

$site->loadData($fromSource);
$site->buildSiteTreeFromEntities();
$site->syncTemplates($freshTemplates);
$site->renderSite($renderPageOnFailure);
if ( $site->validateSite() && $syncToDestination )
{
    echo "Syncing to destination bucket\n";
    $site->destination->sync();
}

/*** /

if ( !is_dir('./exampledata') ) { mkdir('./exampledata'); }

$ex = json_encode(["entities"=>$site->source->entities], JSON_PRETTY_PRINT);
file_put_contents('./exampledata/entities.js', $ex);

$ex = json_encode(["pagesByUrl"=>$site->pagesByUrl], JSON_PRETTY_PRINT);
file_put_contents('./exampledata/data_pagesByUrl.json', $ex);

$ex = json_encode(["siteIndexAZ"=>$site->siteIndexAZ], JSON_PRETTY_PRINT);
file_put_contents('./exampledata/siteIndexAZ.js', $ex);

$ex = json_encode(["mainNav"=>$site->sitePage['menu']], JSON_PRETTY_PRINT);
file_put_contents('./exampledata/data_mainNav.json', $ex);

$ex = json_encode(["directoryRecordGroups"=>$site->directoryRecordGroups], JSON_PRETTY_PRINT);
file_put_contents('./exampledata/data_directoryRecordGroups.json', $ex);

$ex = json_encode(["stateDetails"=>$site->stateDetails], JSON_PRETTY_PRINT);
file_put_contents('./exampledata/data_stateDetails.json', $ex);


/***/

//$site->renderer->renderPage($site->homePage);

//$x = array_pop($site->features);
/*
$types = array_keys($site->directoryRecordGroups['USA.gov']['all']);
$groups = [];
foreach ($types as $type)
{
    $type_groups = array_keys($site->directoryRecordGroups['USA.gov']['all'][$type]);
    foreach ( $type_groups as $type_group )
    {
        if ( !isset($groups[$type_group]) )
        {
            $groups[$type_group] = 0;
        }
        $groups[$type_group]++;
    }
}
ksort($groups);
print_r(json_encode($groups,JSON_PRETTY_PRINT));
*/

// print_r(json_encode($site->pageTypes,JSON_PRETTY_PRINT));

echo "\n";

$executionEndTime = microtime(true);
$time=round($executionEndTime - $executionStartTime, 4);
$size=memory_get_peak_usage(true);
$unit=['b','kb','mb','gb','tb','pb'];
$tunit=['sec','min','hour'];
echo "\n===============";
echo "\nSite           : ". $site->siteName;
echo "\nFound Entities : ". count($site->source->entities);
echo "\nFound Pages    : ". count($site->pages);
echo "\nFound Root     : ". $site->sitePage['name'];
echo "\nMax Memory     : ". ( ( $size > 1 ) ? @round($size/pow(1024, ($i=floor(log($size, 1024)))), 2).' '.@$unit[$i]  : $size.' '.$unit[0]  );
echo "\nExecution Time : ". ( ( $time > 1 ) ? @round($time/pow(60, ($i=floor(log($time, 60)))), 2).' '.@$tunit[$i] : $time.' '.$tunit[0] );
// echo "\nExecution Time : ". ( ( $time > 1 ) ? "$time >1" : $time.' <1 '.$tunit[0] );
echo "\n\n";
