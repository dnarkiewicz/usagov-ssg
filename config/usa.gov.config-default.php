<?php

$config = [
  'siteName'    => 'USA.gov',
  'subSiteName' => 'USAGov en Español',
  'siteUrl'     => 'www.usa.gov',
  'permDir' => realpath(dirname(__FILE__).'/..').'/perm',
  'tempDir' => realpath(dirname(__FILE__).'/..').'/temp',
  'featuresPageBatchSize' => 5,
  'drupalAPI' => [
    'server'       => 'https://usa-cmp-stg.gsa.ctacdev.com',
    'redirectsUrl' => '/usaapi/redirects',
    'entitiesUrl'  => '/usaapi/entities',
    'batchSize'    => 100
  ],
  'templateSync' => [
    'repo_url'    => '',
    'repo_user'   => '',
    'repo_pass'   => '',
    'repo_branch' => '',
    'repo_template_dir' => ''
  ],
  'aws' => [
    'aws_access_key_id' => '',
    'aws_secret_access_key' => '',
    'region'  => 'us-east-1',
    'version' => 'latest',
    'bucket' => ''
  ],
];