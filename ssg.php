<?php

namespace ctac\ssg;

require_once 'vendor/autoload.php';
require_once 'lib/autoload.php';

$executionStartTime = microtime(true);

$site = new StaticSiteGenerator('USA.gov');

$syncToDestination = false;
$fractalExamples   = false;

foreach ( $argv as $arg )
{
    if ( isset($arg) && $arg=='--fresh-data' )
    {
        $site->getDatafromSource = true;
    }
    if ( isset($arg) && $arg=='--fresh-templates' )
    {
        $site->templates->freshTemplates = true;
    }
    if ( isset($arg) && $arg=='--no-debug-pages' )
    {
        $site->renderer->renderPageOnFailure = false;
    }
    if ( isset($arg) && $arg=='--push-s3' )
    {
        $syncToDestination = true;
    }
    if ( isset($arg) && $arg=='--local-redirects' )
    {
        $site->source->useLocalRedirects = true;
    }
    if ( isset($arg) && $arg=='--fractal-examples' )
    {
        $fractalExamples = true;
    }
}


$site->loadData();
$site->buildSiteTreeFromEntities();
$site->syncTemplates();
$site->renderSite();
if ( $site->validateSite() && $syncToDestination )
{
    $site->destination->sync();
}

if ( $fractalExamples ) 
{
    generateFractalData($site);
}

//print_r(json_encode($site->directoryRecordGroups['USA.gov']['PR']['State Government Agencies']['State'][0]['uuid'],JSON_PRETTY_PRINT));

// print_r(json_encode($site->directoryRecordGroups['USA.gov']['pr']['State Government Agencies']['all'][0],JSON_PRETTY_PRINT));

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
echo "\n\n";


function generateFractalData($site)
{
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
}