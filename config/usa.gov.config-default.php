<?php

$config = [
  'siteName'        =>  'USA.gov',
  'allowedForUseBy' => ['USA.gov','GobiernoUSA.gov'],
  'siteUrl'     => 'www.usa.gov',
  'permDir' => realpath(dirname(__FILE__).'/..').'/perm',
  'tempDir' => realpath(dirname(__FILE__).'/..').'/temp',
  'featuresPageBatchSize' => 5,
  'drupalAPI' => [
    'server'       => 'https://usa-cmp-test.gsa.ctacdev.com',
    'redirectsUrl' => '/usaapi/redirects',
    'entitiesUrl'  => '/usaapi/entities',
    'batchSize'    => 50
  ],
  'templateSync' => [
    'repo_url'    => '',
    'repo_user'   => '',
    'repo_pass'   => '',
    'repo_branch' => '',
    'repo_template_dir' => '',
    'repo_asset_base'   => 'assets',
    'repo_asset_dirs'   => [ 'js', 'css', 'fonts', 'images' ],
    'repo_static_base'  => 'staticroot',
    'repo_asset_dirs'   => [ '*' ],
  ],
  'aws' => [
    'aws_access_key_id'     => '',
    'aws_secret_access_key' => '',
    'region'  => 'us-east-1',
    'version' => 'latest',
    'bucket'  => ''
  ]
];