<?php

namespace ctac\ssg;

use \Twig\Loader;

class PageRenderer
{
    public $ssg;

    public $templates;
    public $templateDir;
    public $templateDirCache;

    public $templateLoader;
    public $templateRenderer;

    public function __construct( &$ssg )
    {
        $this->ssg = &$ssg;

        $repo_template_dir = $this->ssg->config['templateSync']['repo_template_dir'];
        $repo_template_dir = preg_replace('(^[\.\/]|[\.\/]$)','',$repo_template_dir);

        $this->templateDir      = realpath($this->ssg->config['baseDir']).'/templates/twig/'.$repo_template_dir;
        $this->templateDirCache = realpath($this->ssg->config['baseDir']).'/templates/compiled/twig';

        if ( !is_dir($this->templateDir) )
        { 
            mkdir($this->templateDir,0744,true);
        }
        if ( !is_writable($this->templateDir) )
        {
            $this->ssg->chmod_recurse($this->templateDir,0744);
        }

        if ( !is_dir($this->templateDirCache) )
        { 
            mkdir($this->templateDirCache,0744,true);
        }
        if ( !is_writable($this->templateDirCache) )
        {
            $this->ssg->chmod_recurse($this->templateDirCache,0744);
        }

        $this->templateLoader   = new \Twig_Loader_Filesystem($this->templateDir);
        $this->templateRenderer = new \Twig_Environment($this->templateLoader, array(
            'cache' => $this->templateDirCache,
            'auto_reload' => 1
        ));
        $this->addFilters();
    }

    public function addFilters()
    {
        $ssg =& $this->ssg;
        $this->templateRenderer->addFilter(new \Twig_Filter('friendly_url', function ($string) use ($ssg)
        {
            return $ssg->sanitizeForUrl($string);
        }));
        $this->templateRenderer->addFilter(new \Twig_Filter('sanitizeForUrl', function ($string) use ($ssg)
        {
            return $ssg->sanitizeForUrl($string);
        }));
        $this->templateRenderer->addFilter(new \Twig_Filter('onlyFeatures', function ($entities) use ($ssg)
        {
            $features = [];
            foreach ( $entities as $entity ) {
                if ( $ssg->isFeature($entity) ) {
                    $features[$entity['uuid']] = $entity; 
                }
            }
            return $features;
        }));
        $this->templateRenderer->addFilter(new \Twig_Filter('sharesTopicWith', function ($entities,$uuid) use ($ssg)
        {
            return $ssg->sharesTopicWith($entities,$uuid);
        }));
        $this->templateRenderer->addFilter(new \Twig_Filter('sortBy', function ($entities,$key)
        {
            usort($entities,function($a,$b) use ($key) 
            {
                if ( !array_key_exists($key,$a) 
                  || !array_key_exists($key,$b) 
                  || trim($a[$key]) == trim($b[$key]) )
                {
                    return 0;
                }
                return ( trim($a[$key]) < trim($b[$key]) ) ? -1 : 1;
             });
            return $entities;
        }));
    }

  	public function renderPage( &$page, $renderPageOnFailure=false )
  	{
          /// PATH
          $url = $this->getPageUrl($page);
          if ( empty($url) )
          {
              /// not renderable
              echo "UnRenderable: no url for {$page['name']}\n";
              return null;
          }
          if ( empty($page['pageType']) )
          {
              echo "UnRenderable: no type for $url ({$page['pageType']}) \"{$page['name']}\"\n";
              return null;
          }
          echo "Render Page: $url ({$page['pageType']}) \"{$page['name']}\"\n";
          $path = ltrim($url,'/');
          if ( !empty($path) && substr($path,-1)!=='/' ) { $path .= '/'; }
          $base = basename($path);
          if ( empty($base) ) { $base = 'index'; }

          $siteDir = $this->ssg->config['baseDir'].'/sites/'.trim(strtolower($this->ssg->siteName));
          $fileDir = $siteDir.'/'.$path;
          $file = $fileDir.'index.html';

          /// TEMPLATE
          $twig = $this->getTwigPageRenderer($page);
          if ( empty($twig) )
          {
            /// directory for path
            if ( !file_exists($fileDir) )
            {
                mkdir( $fileDir, 0755, true );
            }
            chmod( $fileDir, 0755 );
            $msg = "No renderer found<br />\nPath:".$path."<br />\nType: ".$page['pageType']."<br />\nName: ".$page['name'];
            if ( $renderPageOnFailure )
            {
                file_put_contents( $file, $msg );
            }
            echo preg_replace('/(\<br \/\>|\n)/','',$msg)."\n";
            return null;
          }

          /// METADATA FOR RENDERING
          $pageData = $this->preProcessPage($page);

          /// HTML
          $html = $twig->render($pageData);
          $html = trim($html);
          if ( !empty($html) )
          {
              /// directory for path
              if ( !file_exists($fileDir) )
              {
                  mkdir( $fileDir, 0755, true );
              }
              chmod( $fileDir, 0755 );
              file_put_contents( $file, $html );
          } else {
            if ( !file_exists($fileDir) )
            {
                mkdir( $fileDir, 0755, true );
            }
            chmod( $fileDir, 0755 );
            $msg = "Render Failed<br />\nPath:".$path."<br />\nType: ".$page['pageType']."<br />\nName: ".$page['name'];
            if ( $renderPageOnFailure )
            {
                file_put_contents( $file, $msg );
            }
            echo preg_replace('/(\<br \/\>|\n)/','',$msg)."\n";
          }

          /// some special pages generate further sub-pages
          if ( $page['pageType'] == 'AZPage' )
          {

            foreach ( $this->ssg->siteIndexAZ as $letter => $list )
            {
                $pageData['currentAZLetter'] = $letter;
                $html = $twig->render($pageData);
                if ( !empty($html) )
                {
                    /// directory for path
                    $fileDir = $siteDir.'/'.$path.strtolower($letter);
                    $file = $fileDir.'/'.'index.html';
                    if ( !file_exists($fileDir) )
                    {
                        mkdir( $fileDir, 0755, true );
                    }
                    chmod( $fileDir, 0755 );
                    file_put_contents( $file, $html );
                    echo "Render Page: {$path}".strtolower($letter)."\n";

                } else {
                    $msg = "Render Failed<br />\nPath:".$path.strtolower($letter)."<br />\nType: ".$page['pageType']."<br />\nName: ".$page['name'];
                    if ( $this->renderPageOnFailure )
                    {
                        file_put_contents( $file, $msg."<pre>".print_r($page,1)."</pre>" );
                    }
                    echo preg_replace('/(\<br \/\>|\n)/','',$msg)."\n";
                }
            }

            if ( $page['az_index_data_source'] == 'directory-records-federal' )
            { 
                // genreate one subpage per record
                foreach ( $this->ssg->directoryRecordGroups[$this->ssg->siteName]['all']['Federal Agencies']['all'] as $agencyInfo )
                {
                    $agency = $this->ssg->source->entities[$agencyInfo['uuid']];

                    $directoryRecordPage = array_merge($page,[]);
                    $directoryRecordPage['pageType'] = 'federal-directory-record';
                    
                    $urlSafeTitle = $this->ssg->sanitizeForUrl($agency['title']);
                    $directoryRecordPage['friendly_url'] = $url.'/'.$urlSafeTitle;
                    $directoryRecordPage['asset_order_content'] = [
                        [
                            'target_id' => $agency['nid'],
                            'uuid' => $agency['uuid'],
                            'type' => 'node',
                            'bundle' => $agency['type'],
                        ]
                    ];
                    $this->renderPage($directoryRecordPage);
                }
            }

          } else if ( $page['pageType'] == '50StatePage' ) {

            $matches = [];
            if ( preg_match('/^autogenerate\-(.*)/',$page['usa_gov_50_state_category'],$matches) )
            {
                if ( !empty($matches[1]) )
                {
                    /// just get a copy of this array
                    $detailsPage = array_merge($page,[]);
                    $detailsType = ucfirst($matches[1]);
                    $detailsPage['pageType'] = 'StateDetails'.$detailsType;
                    $baseUrl = $url;
                    // for each feature
                    foreach ( $this->ssg->stateAcronyms as $acronym=>$name ) 
                    {
                        if ( !empty($detailsPage['usa_gov_50_state_prefix']) )
                        {
                            $baseUrl = $detailsPage['usa_gov_50_state_prefix'];
                        }
                        $urlSafeName = $this->ssg->sanitizeForUrl($name);
                        $detailsPage['friendly_url'] = $baseUrl.'/'.$urlSafeName;
                        $detailsPage['state'] = $acronym;
                        $this->renderPage($detailsPage);
                    }
                }
            }

          } else if ( $page['pageType'] == 'Features' && empty($page['currentPage']) ) {
            /// feature page with an empty currentPage is seen by the system as the master page
            /// all other paginated subpages generated will have an integer currentPage
            /// and should not generate further subpages 

            if ( !empty($this->ssg->features[$this->ssg->siteName]) )
            {
                $batchSize = !empty($this->ssg->config['featuresPageBatchSize']) ? $this->ssg->config['featuresPageBatchSize'] : 5;
                $maxPage   = ceil(count($this->ssg->features[$this->ssg->siteName])/$batchSize);
                for ( $currentPage = 1; $currentPage <= $maxPage; $currentPage++ )
                {
                    $featuresPaginated = array_merge($page,[]);
                    $featuresPaginated['currentPage']  = $currentPage;
                    $featuresPaginated['friendly_url'] = $url.'/'.$currentPage;
                    $this->renderPage($featuresPaginated);
                }
            }

            $featurePage = array_merge($page,[]);
            $featurePage['pageType'] = 'Feature'; // singular
            // for each state
            foreach ( $this->ssg->features[$this->ssg->siteName] as $feature ) 
            {
                $urlSafeTitle = $this->ssg->sanitizeForUrl($feature['title']);
                $featurePage['friendly_url'] = $url.'/'.$urlSafeTitle;
                $featurePage['asset_order_content'] = [
                    [
                        'target_id' => $feature['nid'],
                        'uuid' => $feature['uuid'],
                        'type' => 'node',
                        'bundle' => $feature['type'],
                    ]
                ];
                $this->renderPage($featurePage);
            }

          }

          $paths = [ $path ];
          return $paths;
  	}

    public function getPageUrl( $page )
    {
        if ( !empty($page['field_friendly_url'])
          && !empty($page['field_friendly_url']['und'])
          && !empty($page['field_friendly_url']['und'][0])
          && !empty($page['field_friendly_url']['und'][0]['value']) )
        {
            return $page['field_friendly_url']['und'][0]['value'];
        }
        if ( !empty($page['friendly_url']) )
        {
            return $page['friendly_url'];
        }
        return null;
    }

    public function preProcessPage( &$page )
    {
        $pageParams = [];
        $this->process( $page, $pageParams );
        return $pageParams;
    }

    public function getTwigPageRenderer( $page )
    {
        $repo_template_dir = $this->ssg->config['templateSync']['repo_template_dir'];
        $repo_template_dir = preg_replace('(^[\.\/]|[\.\/]$)','',$repo_template_dir);

        if ( empty($this->ssg->siteName) ) { error_log(" no renderers for site"); return null; }

        if ( empty($this->templates[$this->ssg->siteName]) )
        {
            $this->templates[$this->ssg->siteName] = [];
        }
        if ( empty($this->templates[$this->ssg->siteName]['twig']) )
        {
            $this->templates[$this->ssg->siteName]['twig'] = [];
        }
        ;
        if ( empty($this->templates[$this->ssg->siteName]['twig'][$page['pageType']]) )
        {
            /// if the template file exists
            if ( !file_exists('./templates/twig/'.$repo_template_dir.'/'.$page['pageType'].'.twig') )
            {
                $this->templates[$this->ssg->siteName]['twig'][$page['pageType']] = null;
            } else {
                try {
                    $this->templates[$this->ssg->siteName]['twig'][$page['pageType']] = $this->templateRenderer->load($page['pageType'].'.twig');
                } catch (Exception $e) { 
                    $this->templates[$this->ssg->siteName]['twig'][$page['pageType']] = null;
                }
            }
        }

        return $this->templates[$this->ssg->siteName]['twig'][$page['pageType']];
    }

    public function initTemplatesDirs()
    {
        if ( !file_exists($this->baseDir.'/templates/') )
        {
            mkdir( $this->baseDir.'/templates/', 0755, true );
        }
        if ( !file_exists($this->baseDir.'/templates/twig') )
        {
            mkdir( $this->baseDir.'/templates/twig', 0755, true );
        }

        if ( !file_exists($this->baseDir.'/templates/compiled/') )
        {
            mkdir( $this->baseDir.'/templates/compiled/', 0755, true );
        }
        if ( !file_exists($this->baseDir.'/templates/compiled/twig') )
        {
            mkdir( $this->baseDir.'/templates/compiled/twig', 0755, true );
        }
    }

    public function process( &$page, &$params )
    {
      $params = array_merge($params,$page);

      $params['config']   = $this->ssg->config;

      $params['siteName'] = $this->ssg->siteName;
      $params['siteUrl']  = $this->ssg->config['siteUrl'];

      $params['entities'] = $this->ssg->source->entities;
      $params['sitePage'] = $this->ssg->sitePage;
      $params['homePage'] = $this->ssg->homePage;
  
      $params['directoryRecordGroups'] = $this->ssg->directoryRecordGroups;
      $params['siteIndexAZ'] = $this->ssg->siteIndexAZ;
      $params['currentAZLetter'] = null;
  
      $params['features']        = $this->ssg->features;
      $params['featuresByTopic'] = $this->ssg->featuresByTopic;

      if ( $page['pageType']=='Features' 
        && empty($params['currentPage']) )
      {
        $params['currentPage'] = 1;
      } else if ( !isset($params['currentPage']) ) {
        $params['currentPage'] = null;
      }

      $params['stateDetails']    = $this->ssg->stateDetails;
      $params['stateAcronyms']   = $this->ssg->stateAcronyms;
  
      
    }

}
