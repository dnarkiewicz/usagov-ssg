<?php

require_once __DIR__ . '/ConfigLoader.class.php';
require_once __DIR__ . '/DataSource.class.php';
require_once __DIR__ . '/sources/ElasticsearchDataSource.class.php';
require_once __DIR__ . '/sources/DrupalAPIDataSource.class.php';
require_once __DIR__ . '/StaticSiteGenerator.class.php';
require_once __DIR__ . '/PageRenderer.class.php';
require_once __DIR__ . '/TemplateSync.class.php';
// require_once __DIR__ . '/Twig_Loader_Fractal.class.php';

require_once __DIR__ . '/processors/USA.gov/ProcessorMain.class.php';
require_once __DIR__ . '/processors/USA.gov/Processor50StatePage.class.php';

// require_once __DIR__ . '/processors/Blog.USA.gov/ProcessorBlogMain.class.php';
// require_once __DIR__ . '/processors/Blog.USA.gov/ProcessorBlogEntry.class.php';
// require_once __DIR__ . '/processors/Blog.USA.gov/ProcessorBlogHome.class.php';
// require_once __DIR__ . '/processors/Blog.USA.gov/ProcessorBlogListing.class.php';
