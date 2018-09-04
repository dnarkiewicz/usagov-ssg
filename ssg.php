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

// print_r(json_encode($site->source->entities['2579eb59-9d7a-4c30-8ccf-1e2c6992e03d'],JSON_PRETTY_PRINT));

/*
foreach ( $site->source->entities as $uuid=>$e )
{
    $tid = !empty($e['tid']) ? $e['tid'] : '';
    $nid = !empty($e['nid']) ? $e['nid'] : '';
    checkExists($e," tid:$tid nid:$nid uuid:$uuid");
}

function checkExists( $o, $bc )
{
    global $site;
    if ( is_array($o) )
    {
        if ( !empty($o['uuid']) )
        {
//            echo "\n\n$bc >> ";
            if ( array_key_exists( $o['uuid'], $site->source->entities ) ) {
                //echo "found";
            } else if ( !preg_match('/(file_media|file_text|agency|content_tags|asset_topic_taxonomy)/',$bc) ) {
                echo "\n\n$bc >> ";
                echo " ({$o['uuid']}) NOT FOUND!!";
                print_r(json_encode($o,JSON_PRETTY_PRINT));
            }
        }
        foreach ( $o as $k=>$v )
        {
            checkExists($v,"$bc > $k");
        }
    }
}
/**/
// print_r(json_encode($site->source->entities['35e35591-9e3e-4d62-80fe-e7256331531d'],JSON_PRETTY_PRINT));

//   print_r(json_encode($site->source->entitiesById['tid']['2771'],JSON_PRETTY_PRINT));

// print_r(json_encode($site->source->entities['386c1c0c-94c3-409a-bd28-cc93a4f79c74'],JSON_PRETTY_PRINT));

// echo "NID\tUUID\tTYPE\t \tRAW+OLD+NEW\n";
// foreach ( $site->source->entities as $entity )
// {
//     if ( empty($entity['nid']) ) { $entity['nid']=''; }
    
//     if ( !empty($entity['title']) )
//     {
//         $new = $site->sanitizeForUrl($entity['title']);
//         $old = $site->sanitizeForUrlOld($entity['title']);
//         if ( $new !== $old )
//         {
//             echo "{$entity['nid']}\t{$entity['uuid']}\t{$entity['type']}\t \t \n";
//             echo " \t \t \traw\t{$entity['title']}\n";
//             echo " \t \t \told\t{$old}\n";
//             echo " \t \t \tnew\t{$new}\n";
//         }
//     }
// }

// if ( $fractalExamples ) 
// {
//     generateFractalData($site);
// }

// print_r(json_encode($site->directoryRecordGroups['USA.gov']['PR']['State Government Agencies']['State'][0]['uuid'],JSON_PRETTY_PRINT));
// print_r(json_encode($site->source->entities['21c2d005-7730-41c0-9798-ee5f132168ee'],JSON_PRETTY_PRINT));
// print_r(json_encode($site->directoryRecordGroups['USA.gov']['all']['Federal Agencies']['Executive'],JSON_PRETTY_PRINT));

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


// function generateFractalData($site)
// {
//     if ( !is_dir('./exampledata') ) { mkdir('./exampledata'); }

//     $ex = json_encode(["entities"=>$site->source->entities], JSON_PRETTY_PRINT);
//     file_put_contents('./exampledata/entities.js', $ex);

//     $ex = json_encode(["pagesByUrl"=>$site->pagesByUrl], JSON_PRETTY_PRINT);
//     file_put_contents('./exampledata/data_pagesByUrl.json', $ex);

//     $ex = json_encode(["siteIndexAZ"=>$site->siteIndexAZ], JSON_PRETTY_PRINT);
//     file_put_contents('./exampledata/siteIndexAZ.js', $ex);

//     $ex = json_encode(["mainNav"=>$site->sitePage['menu']], JSON_PRETTY_PRINT);
//     file_put_contents('./exampledata/data_mainNav.json', $ex);

//     $ex = json_encode(["directoryRecordGroups"=>$site->directoryRecordGroups], JSON_PRETTY_PRINT);
//     file_put_contents('./exampledata/data_directoryRecordGroups.json', $ex);

//     $ex = json_encode(["stateDetails"=>$site->stateDetails], JSON_PRETTY_PRINT);
//     file_put_contents('./exampledata/data_stateDetails.json', $ex);
// }