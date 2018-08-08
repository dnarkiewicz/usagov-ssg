<?php

namespace ctac\ssg;

class StaticSiteGenerator
{
    public $time;
    public $siteName;

    public $pages;
    public $pageTree;
    public $sitePage;
    public $homePage;
    public $pageTypes;

    public $siteIndexAZ;
    public $features;
    public $featuresByTopic;
    public $directoryRecordGroups;
    public $stateDetails;
    public $stateAcronyms;

    public $renderer;
    public $config;

    public $loadDatafromSource;

    public function __construct( $siteName )
    {
        $this->time = microtime();
        $this->siteName  = $siteName;

        /// setup page references
        $this->pages     = [];
        $this->sitePage  = null;
        $this->homePage  = null;
        $this->pageTypes = [];

        /// setup content references
        $this->directoryRecordGroups = [];
        $this->features = [];
        $this->featuresByTopic = [];

        $this->pagesByUrl = [];
        $this->siteIndexAZ  = [];
        $this->stateAcronyms = [
            'um'=>'minor outlying islands','mh'=>'republic of the marshall islands','pw'=>'republic of palau','fm'=>'federated states of micronesia',
            'gu'=>'guam','as'=>'american samoa','al'=>"alabama",'ak'=>"alaska",'az'=>"arizona",'ar'=>"arkansas",'ca'=>"california",'co'=>"colorado",
            'ct'=>"connecticut",'de'=>"delaware",'dc'=>"district of columbia",'fl'=>"florida",'ga'=>"georgia",'hi'=>"hawaii",'id'=>"idaho",
            'il'=>"illinois",'in'=>"indiana",'ia'=>"iowa",'ks'=>"kansas",'ky'=>"kentucky",'la'=>"louisiana",'me'=>"maine",'md'=>"maryland",
            'ma'=>"massachusetts",'mi'=>"michigan",'mn'=>"minnesota",'ms'=>"mississippi",'mo'=>"missouri",'mt'=>"montana",'ne'=>"nebraska",
            'nv'=>"nevada",'nh'=>"new hampshire",'nj'=>"new jersey",'nm'=>"new mexico",'ny'=>"new york",'nc'=>"north carolina",'nd'=>"north dakota",
            'oh'=>"ohio",'ok'=>"oklahoma",'or'=>"oregon",'pa'=>"pennsylvania",'ri'=>"rhode island",'sc'=>"south carolina",'sd'=>"south dakota",
            'tn'=>"tennessee",'tx'=>"texas",'ut'=>"utah",'vt'=>"vermont",'va'=>"virginia",'wa'=>"washington",'wv'=>"west virginia",'wi'=>"wisconsin",
            'wy'=>"wyoming", 'as' => 'american samoa', 'vi' => 'u.s. virgin islands', 'mp' => 'northern mariana islands', 'pr' => 'puerto rico', 'gu' => 'guam'
        ];

        /// get helper objects
        $this->config      = ConfigLoader::loadConfig( $this->siteName );
        $this->source      = new DrupalAPIDataSource( $this );
        $this->renderer    = new PageRenderer( $this );
        $this->templates   = new TemplateSync( $this ); 
        $this->destination = new SiteDestination( $this );

        $this->getDatafromSource = false;

    }

    public function pushToDestination()
    {
        $this->destination->push();
    }

    public function syncTemplates()
    {
        $this->templates->sync();
    }

    public function storeDataInCache()
    {
        if ( !is_dir('./cache/') ) { mkdir('./cache/'); }
        $cacheFile='./cache/'.$this->siteName.'.cache';
        if ( !file_exists($cacheFile) )
        {
            touch($cacheFile);
        }
        if ( !is_writable($cacheFile) ) 
        { 
            chmod($cacheFile,0644);
        }
        $cache = serialize([ 
            'entities'=>$this->source->entities, 
            'entitiesById'=>$this->source->entitiesById,
            'redirects'=>$this->source->redirects,
        ]);
        $bytes = file_put_contents($cacheFile, $cache);
        return !empty( $bytes );
    }
    public function loadData()
    {
        $sourceFail = false;
        if ( $this->getDatafromSource )
        {
            /// if we want data from source - we might only need to update
            /// how do we know if we want totally new data or just updated
            echo "Data: loading from source ... ";
            if ( $this->loadDataFromSource() ) 
            {
                return true; 
            } else {
                $sourceFail = true;
            }
        }
        echo "Data: loading from cache ... ";
        if ( ! $this->loadDataFromCache()  ) 
        { 
            echo "not found\n";
            if ( !$sourceFail )
            {   
                echo "Data: loading from source ... ";
                if ( $this->loadDataFromSource() ) 
                {
                    return true; 
                }
            }
        }
        echo "done\n";
        return false;
    }
    public function loadDataFromSource()
    {
        $this->source->pull();
        return $this->storeDataInCache();
    }
    public function loadDataFromCache()
    {
        if ( !is_dir('./cache/') ) { return false; }
        $cacheFile='./cache/'.$this->siteName.'.cache';
        if ( !file_exists($cacheFile) || !is_readable($cacheFile) ) { return false; }
        $cache = unserialize(file_get_contents($cacheFile));
        if (
            empty($cache)
            || !array_key_exists('entities',     $cache)
            || !array_key_exists('entitiesById', $cache)
        ) { return false; }
        $this->source->entities     = $cache['entities'];
        $this->source->entitiesById = $cache['entitiesById'];
        if ( array_key_exists('redirects', $cache) )
        {
            $this->source->redirects     = $cache['redirects'];
        }
        return true;
    }

    public function buildSiteTreeFromEntities()
    {
        echo "Site Tree: building from entities ... ";
        $treeStartTime = microtime(true);

        $this->pages        = [];
        $this->pagesByUrl   = [];
        $this->sitePage     = null;
        $this->homePage     = null;
        $this->topicsPage   = null;
        $this->pageTypes    = [];

        $this->directoryRecordGroups = [];
        $this->features = [];
        $this->featuresByTopic = [];
        $this->stateDetails = [];

        $this->siteIndexAZ = ['A'=>[],'B'=>[],'C'=>[],'D'=>[],'E'=>[],'F'=>[],'G'=>[],'H'=>[],'I'=>[],'J'=>[],'K'=>[],'L'=>[],'M'=>[],'N'=>[],'O'=>[],'P'=>[],'Q'=>[],'R'=>[],'S'=>[],'T'=>[],'U'=>[],'V'=>[],'W'=>[],'X'=>[],'Y'=>[],'Z'=>[]];

        foreach( $this->source->entities as $uuid=>$entity )
        {
            /// IF THIS IS A PAGE
            if ( isset($entity['tid']) && isset($entity['vocabulary_machine_name'])
                 && $entity['vocabulary_machine_name']=='site_strucutre_taxonomy' )
            {
                $this->pages[$uuid] =& $this->source->entities[$uuid];
                if ( !array_key_exists($entity['pageType'],$this->pageTypes) )
                {
                    $this->pageTypes[$entity['pageType']] = $entity['pageType'];
                }
                /**DBG** /
                if ( $entity['type_of_page_to_generate'] == 'a-z-index' )
                {
                    echo 'AZ: '.$entity['friendly_url']." : ". $entity['type_of_page_to_generate']."\n";
                }
                if ( $entity['type_of_page_to_generate'] == '50-state-page' )
                {
                    echo '50: '.$entity['friendly_url']." : ". $entity['usa_gov_50_state_category']."\n";
                }
                /*\DBG**/
                if ( empty($entity['parent']) && $entity['name']===$this->siteName )
                {
                    $this->sitePage =& $this->source->entities[$uuid];
                }
                if ( $entity['pageType'] === 'More' && empty($this->topicsPage) )
                {
                    $this->topicsPage =& $this->source->entities[$uuid];
                }
                if ( $entity['pageType'] === 'Home' && empty($this->homePage) )
                {
                    $this->homePage =& $this->source->entities[$uuid];
                }
                if ( !empty($this->pages[$uuid]['friendly_url']) && empty($this->pagesByUrl[$this->pages[$uuid]['friendly_url']]) )
                {
                    $this->pagesByUrl[$this->pages[$uuid]['friendly_url']] =& $this->source->entities[$uuid];
                }
                if ( !empty($entity['usa_gov_50_state_category']) ) {
                    $this->source->entities[$uuid]['usa_gov_50_state_category'] = preg_replace('/^field_/','',$entity['usa_gov_50_state_category']);
                }
                /// CORRECT THIS HERE UNTIL ECAS/CMP FIELD CHANGE IS ADDEDED
                /*
                if ( $entity['pageType'] === 'DirectoryRecord' )
                {
                    if ( !empty($this->pages[$uuid]['friendly_url'])
                         && $this->pages[$uuid]['friendly_url'] == "\/forms\/a" )
                    {
                        //$this->pages[$uuid]['directory-record-link-field'] = 'links';
                        //$entity['directory-record-access-me'] == 'form';
                    } else {
                        //$this->pages[$uuid]['directory-record-link-field'] = 'friendly_url';
                    }
                } else {
                    //$this->pages[$uuid]['directory-record-link-field'] = null;
                }
                */
                // build a fake sub-page for each one of these special cases
                /// FEATURES - generate landing page, and all sub pages
                /// AZ-INDEX - list of each displayable page, grouped by first letter of browser_title
                /// AZ-DIRREC - list of listable directory records, grouped by first letter of title
                $i=0;
                if ( !empty($entity['browser_title']) && !empty($entity['generate_page']) && strtolower($entity['generate_page'])=='yes' )
                {
                    $letter = strtoupper($entity['browser_title']{0});
                    $this->siteIndexAZ[$letter][] = [ 'uuid'=>$entity['uuid'], 'title'=>$entity['browser_title'] ];
                }

            /// IF THIS IS A CONTENT ITEM
            } else {

                if ( $this->isFeature($entity) )
                {
                    $fubs = !empty($entity['for_use_by']) ? $entity['for_use_by'] : [$this->siteName];
                    foreach ( $fubs as $fub )
                    {
                        if ( strtolower($fub) == 'feature' )
                        {
                            continue;
                        }
                        if ( !array_key_exists($fub,$this->features) )
                        {
                            $this->features[$fub] = [];
                        }
                        $this->features[$fub][$entity['uuid']] =& $this->source->entities[$entity['uuid']];
                        if ( !array_key_exists($fub,$this->featuresByTopic) )
                        {
                            $this->featuresByTopic[$fub] = [];
                        }
                        if ( array_key_exists('asset_topic_taxonomy',$entity) )
                        {
                            foreach ( $entity['asset_topic_taxonomy'] as $asset_topic )
                            {
                                if ( !array_key_exists($asset_topic['uuid'],$this->featuresByTopic[$fub]) )
                                {
                                    $this->featuresByTopic[$fub][$asset_topic['uuid']] = [];
                                }
                                $this->featuresByTopic[$fub][$asset_topic['uuid']][$entity['uuid']] =& $this->source->entities[$entity['uuid']];
                            }
                        }
                    }
                }

                /// fill in any missing states from our hardcoded list
                if ( $entity['type'] == 'state_details' )
                {
                    if ( !empty($entity['state_acronym'])
                      && !empty($entity['state_canonical_name']) )
                    {
                        if ( @count($entity['state_acronym']) <= 2
                          && empty($this->stateAcronyms[ strtolower($entity['state_acronym']) ]) )
                        {
                            $this->stateAcronyms[strtolower($entity['state_acronym'])] = strtolower($entity['state_canonical_name']);
                        }
                    }
                    $fubs = !empty($entity['for_use_by']) ? $entity['for_use_by'] : [$this->siteName];
                    foreach ( $fubs as $fub )
                    {
                        if ( !array_key_exists( $fub, $this->stateDetails ) )
                        {
                            $this->stateDetails[$fub] = [];
                        }
                        $this->stateDetails[$fub][] = [ 'uuid'=>$uuid, 'state_canonical_name'=>strtolower($entity['state_canonical_name']), 'title'=>$entity['title'] ];
                    }
                }

                if ( @!empty($entity['directory_type']) )
                {
                    $state      = !empty($entity['state'])    ? strtolower($entity['state']) : strtolower('None');
                    $state_name = ( array_key_exists($state,$this->stateAcronyms) ) ? $this->stateAcronyms[$state] : 'None';
                    $group_by   = !empty($entity['group_by']) ? $entity['group_by'] : 'None';
                    $type       = $entity['directory_type'];
                    $fubs       = !empty($entity['for_use_by']) ? $entity['for_use_by'] : [$this->siteName];

                    if ( empty($entity['friendly_url']) )
                    {
                        $entity['friendly_url'] = '';
                        if ( array_key_exists('title',$entity) )
                        {
                            $entity['friendly_url'] = $this->sanitizeForUrl($entity['title']);
                        }
                    }

                    foreach ( $fubs as $fub )
                    {
                        if ( !array_key_exists( $fub, $this->directoryRecordGroups ) )
                        {
                            $this->directoryRecordGroups[$fub] = [ 'all'=>[], 'forms'=>[], 'none'=>[] ];
                        }
                        if ( !array_key_exists( $state, $this->directoryRecordGroups[$fub] ) )
                        {
                            $this->directoryRecordGroups[$fub][$state] = [];
                        }

                        if ( !array_key_exists( $type, $this->directoryRecordGroups[$fub]['all'] ) )
                        {
                            $this->directoryRecordGroups[$fub]['all'][$type] = [ 'all'=>[] ];
                        }
                        if ( !array_key_exists( $type, $this->directoryRecordGroups[$fub][$state] ) )
                        {
                            $this->directoryRecordGroups[$fub][$state][$type] = [ 'all'=>[] ];
                        }

                        if ( !array_key_exists( 'Federal Agencies', $this->directoryRecordGroups[$fub]['all'] ) )
                        {
                            $this->directoryRecordGroups[$fub]['all']['Federal Agencies'] = [ 'all'=>[] ];
                        }
                        if ( !array_key_exists( 'Federal Agencies', $this->directoryRecordGroups[$fub][$state] ) )
                        {
                            $this->directoryRecordGroups[$fub][$state]['Federal Agencies'] = [ 'all'=>[] ];
                        }

                        if ( !array_key_exists( $group_by, $this->directoryRecordGroups[$fub]['all'][$type] ) ) {
                            $this->directoryRecordGroups[$fub]['all'][$type][$group_by] = [];
                        }
                        if ( !array_key_exists( $group_by, $this->directoryRecordGroups[$fub][$state][$type] ) ) {
                            $this->directoryRecordGroups[$fub][$state][$type][$group_by] = [];
                        }
                        /** */
                        
                        $this->directoryRecordGroups[$fub]['all'][$type]['all'][]  = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];
                        $this->directoryRecordGroups[$fub][$state][$type]['all'][] = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];

                        $this->directoryRecordGroups[$fub]['all'][$type][$group_by][]  = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];
                        $this->directoryRecordGroups[$fub][$state][$type][$group_by][] = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];

                        /// AZ Index
                        if ( ( array_key_exists('show_on_az_index',$entity)
                                && trim(strtolower($entity['show_on_az_index'])) == 'yes'
                                && trim(strtolower($type)) == 'federal agencies' )
                           || strtolower($type) == 'state government agencies' )
                        {
                            $letter = strtoupper($entity['title']{0});

                            $this->directoryRecordGroups[$fub]['all'][$type][$letter][]  = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];
                            $this->directoryRecordGroups[$fub][$state][$type][$letter][] = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];

                            if ( strtolower($type) == 'state government agencies' )
                            {
                                $this->directoryRecordGroups[$fub]['all']['Federal Agencies']['all'][]    = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];
                                $this->directoryRecordGroups[$fub][$state]['Federal Agencies']['all'][]   = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];

                                $this->directoryRecordGroups[$fub]['all']['Federal Agencies'][$letter][]  = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];
                                $this->directoryRecordGroups[$fub][$state]['Federal Agencies'][$letter][] = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];
                            }

                            if ( !empty($entity['synonym']) )
                            {
                                foreach ( $entity['synonym'] as $synonym )
                                {
                                    $letter = strtoupper($synonym['value']{0});
                                    $this->directoryRecordGroups[$fub]['all'][$type]['all'][]  = [ 'uuid'=>$uuid, 'title'=>$synonym['value'] ];
                                    $this->directoryRecordGroups[$fub][$state][$type]['all'][] = [ 'uuid'=>$uuid, 'title'=>$synonym['value'] ];

                                    $this->directoryRecordGroups[$fub]['all'][$type][$letter][]  = [ 'uuid'=>$uuid, 'title'=>$synonym['value'] ];
                                    $this->directoryRecordGroups[$fub][$state][$type][$letter][] = [ 'uuid'=>$uuid, 'title'=>$synonym['value'] ];

                                    if ( strtolower($type) == 'state government agencies' )
                                    {
                                        $this->directoryRecordGroups[$fub]['all']['Federal Agencies']['all'][]  = [ 'uuid'=>$uuid, 'title'=>$synonym['value'] ];
                                        $this->directoryRecordGroups[$fub][$state]['Federal Agencies']['all'][] = [ 'uuid'=>$uuid, 'title'=>$synonym['value'] ];
                                        
                                        $this->directoryRecordGroups[$fub]['all']['Federal Agencies'][$letter][]  = [ 'uuid'=>$uuid, 'title'=>$synonym['value'] ];
                                        $this->directoryRecordGroups[$fub][$state]['Federal Agencies'][$letter][] = [ 'uuid'=>$uuid, 'title'=>$synonym['value'] ];
                                    }
                                }
                            }
                        }

                        /// GOV Branches
                        if ( trim(strtolower($type)) == 'federal agencies' )
                        {
                            $letter = strtoupper($entity['title']{0});
                            $branch = !empty($entity['government_branch']) ? $entity['government_branch'] : 'None';

                            $this->directoryRecordGroups[$fub]['all'][$type][$branch][]  = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];
                            $this->directoryRecordGroups[$fub][$state][$type][$branch][] = [ 'uuid'=>$uuid, 'title'=>$entity['title'] ];
                        }

                        /// FORMS Index
                        if ( isset($entity['link_form_links'])
                            && array_key_exists('url',$entity['link_form_links'])
                            && array_key_exists('title',$entity['link_form_links'])
                            && !empty($entity['link_form_links']['url'])
                            && !empty($entity['link_form_links']['title']) )
                        {
                            $letter = strtoupper($entity['link_form_links']['title']{0});
                            $this->directoryRecordGroups[$fub]['forms'][$type][$letter][] = [ 
                                'uuid'=>$uuid, 
                                'title'=>$entity['title'], 
                                'formTitle'=>$entity['link_form_links']['title']
                            ];

                            if ( !empty($entity['synonym']) )
                            {
                                foreach ( $entity['synonym'] as $synonym )
                                {
                                    $letter = strtoupper($synonym['value']{0});
                                    $this->directoryRecordGroups[$fub]['forms'][$type][$letter][] = [ 
                                        'uuid'=>$uuid, 
                                        'title'=>$synonym['value'], 
                                        'formTitle'=>$entity['link_form_links']['title']
                                    ];
                                }
                            }
                        }
                    }

                }
            }
        }

        foreach( $this->source->entities as $uuid=>$entity )
        {
            /// IF THIS IS A PAGE
            if ( isset($entity['tid']) && isset($entity['vocabulary_machine_name'])
                 && $entity['vocabulary_machine_name']=='site_strucutre_taxonomy' )
            {
                $sharesTopic = $this->sharesTopicWith($this->features[$this->siteName],$uuid);
                array_multisort(
                    array_column($sharesTopic,'created'), SORT_ASC,
                    array_column($sharesTopic,'changed'), SORT_ASC,
                    $sharesTopic
                );
                $sharesTopic = array_filter($sharesTopic, function($v) {
                    return isset($v['created']) && $v['created'] > time()-1209600;///two weeks ago  3600*24*7*2;
                });
                if ( !empty($sharesTopic) )
                {
                   $first = array_shift($sharesTopic);
                   $this->source->entities[$uuid]['whats_new'] = [ 'uuid'=>$first['uuid'], 'title'=>$first['title'] ];
                } else {
                    $this->source->entities[$uuid]['whats_new'] = null;
                }
            }
        }

        foreach ( $this->stateDetails as $fud=>&$details )
        {
            array_multisort(
                array_column($details,'state_canonical_name'),SORT_ASC,SORT_STRING|SORT_FLAG_CASE,
            $details);
        }

        foreach ( array_keys($this->features) as $siteName )
        {
            array_multisort(
                array_column($this->features[$siteName],'created'), SORT_ASC,
                array_column($this->features[$siteName],'changed'), SORT_ASC,
            $this->features[$siteName]);
        }

        /// each feature gets a list of associated features
        foreach ( $this->features[$this->siteName] as $uuid=>&$feature )
        {
            $feature['shares_topic'] = [];
            if ( array_key_exists('asset_topic_taxonomy',$feature) )
            {
                foreach ( $feature['asset_topic_taxonomy'] as $asset_topic )
                {
                    if ( array_key_exists($asset_topic['uuid'],$this->featuresByTopic[$this->siteName]) )
                    {
                        foreach ( $this->featuresByTopic[$this->siteName][$asset_topic['uuid']] as &$sharesTopic )
                        {
                            $feature['shares_topic'][] = [
                                'uuid'=>$sharesTopic['uuid'],
                                'title'=>$sharesTopic['title'],
                                'changed'=>$sharesTopic['changed'],
                                'created'=>$sharesTopic['created']
                            ];
                        }
                    }
                }
            }
            array_multisort(
                array_column($feature['shares_topic'],'created'), SORT_ASC,
                array_column($feature['shares_topic'],'changed'), SORT_ASC,
            $feature['shares_topic']);
        }

        ksort($this->directoryRecordGroups);
        foreach ( $this->directoryRecordGroups as $fub=>&$fubList )
        {
            ksort($fubList);
            if ( array_key_exists('none',$fubList) )
            {
                $fubList = array('none'  => $fubList['none'])  + $fubList;
            }
            if ( array_key_exists('forms',$fubList) )
            {
                $fubList = array('forms' => $fubList['forms']) + $fubList;
            }
            if ( array_key_exists('all',$fubList) )
            {
                $fubList = array('all'   => $fubList['all'])   + $fubList;
            }
            foreach ( $fubList as $state=>&$stateList )
            {
                ksort($stateList);
                foreach ( $stateList as $type=>&$typeList )
                {
                    ksort($typeList);
                    if ( array_key_exists('None',$typeList) )
                    {
                        $typeList = array('None'  => $typeList['None'])  + $typeList;
                    }
                    if ( array_key_exists('all',$typeList) )
                    {
                        $typeList = array('all'   => $typeList['all'])   + $typeList;
                    }
                    foreach ( $typeList as $group=>&$groupList )
                    {
                        array_multisort(
                            array_column($groupList,'title'), SORT_ASC,SORT_STRING|SORT_FLAG_CASE,
                        $groupList);
                    }
                }
            }
        }

        ksort($this->siteIndexAZ);
        foreach ( $this->siteIndexAZ as $letter=>&$pages )
        {
            array_multisort(
                array_column($pages,'title'), SORT_ASC,SORT_STRING|SORT_FLAG_CASE,
                array_column($pages,'uuid'),  SORT_ASC,
            $pages);
        }

        $this->buildMenus();

        /// undo all references get copies instead of references
        foreach ( array_keys($this->pages) as $uuid )
        {
            $this->pages[$uuid] = $this->source->entities[$uuid];
        }
        foreach ( $this->pagesByUrl as $url=>$page )
        {
            $this->pagesByUrl[$url] = $this->source->entities[$page['uuid']];
        }
        if ( !empty($this->sitePage) && !empty($this->sitePage['uuid']) )
        {
            $this->sitePage   = $this->source->entities[$this->sitePage['uuid']];
        }
        if ( !empty($this->homePage) && !empty($this->homePage['uuid']) )
        {
            $this->homePage   = $this->source->entities[$this->homePage['uuid']];
        }
        if ( !empty($this->topicsPage) && !empty($this->topicsPage['uuid']) )
        {
            $this->topicsPage = $this->source->entities[$this->topicsPage['uuid']];
        }

        // $treeEndTime = microtime(true);
        // $tunit=['sec','min','hour'];
        // $treeTime = round($treeEndTime - $treeStartTime,4);
        // $treeTime = ( $treeTime >= 1 ) ? @round($treeTime/pow(60,   ($i=floor(log($treeTime, 60)))),   2).' '.$tunit[$i] : "$treeTime sec";
        // // echo "\n BuildTree time($treeTime)";
        echo "done\n";
    }

    public function sanitizeForUrl( $str='' )
    {
        $table = array(
            ' '=>'-', 'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj', 'Ž'=>'Z', 'ž'=>'z', 'C'=>'C', 'c'=>'c', 'C'=>'C', 'c'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'R'=>'R', 'r'=>'r', "'"=>'-', '"'=>'-', '.'=>'-', ','=>'-', '('=>'-', ')'=>'-'
        );
        $str = strtr($str, $table);
        $str = strtolower($str);
        #$str = preg_replace('/[\s\.,\(\)\]+/','-',$str);
        $str = preg_replace('/\W+/','-',$str);
        $str = preg_replace('/-+/','-',$str);
        $str = preg_replace('/^-+/','',$str);
        $str = preg_replace('/-+$/','',$str);
        return $str;
    }
    public function isFeature($entity)
    {
        return array_key_exists('type',$entity)
                && in_array($entity['type'],['text_content_type','html_content_type','multimedia_content_type'])
                && array_key_exists('for_use_by',$entity)
                && (
                    ( is_array($entity['for_use_by'])
                      && in_array('Feature',$entity['for_use_by'])
                    ) || (
                        is_string($entity['for_use_by'])
                        && 'feature' == strtolower($entity['for_use_by'])
                    )
                );
    }
    public function sharesTopicWith($entities,$uuid)
    {
        if ( !array_key_exists($uuid,$this->source->entities) )
        {
            return [];
        }
        $entity = $this->source->entities[$uuid];
        if ( !array_key_exists('asset_topic_taxonomy',$entity) )
        {
            return [];
        }
        $topics = [];
        foreach ( $entity['asset_topic_taxonomy'] as $asset_topic )
        {
            $topics[$asset_topic['uuid']] = true;
        }
        $sharesTopic = [];
        foreach ( $entities as &$test )
        {
            if ( !array_key_exists('asset_topic_taxonomy',$test) )
            {
                continue;
            }
            foreach ( $test['asset_topic_taxonomy'] as $asset_topic )
            {
                if ( isset($topics[$asset_topic['uuid']]) )
                {
                    $sharesTopic[] =& $test;
                }
            }
        }
        return $sharesTopic;
    }

    public function buildMenus()
    {
        foreach( $this->pages as $uuid=>&$page )
        {
            if ( $this->sitePage['uuid']==$page['uuid'] )
            {
                $page['menu'] = $this->buildMainNavMenu($page);
            } else {
                $page['menu'] = $this->buildNavMenu($page);
            }
            $page['child_pages'] = $this->buildPageMenu($page);
        }
    }
    public function buildMainNavMenu($page) 
    {
        $menu = [];
        $directChildren = $this->filteredDescendantPages($page,'children','generate_menu');
        $alsoInclude    = $this->filteredDescendantPages($page,'also_include_on_nav_page','generate_menu');

        $menu = array_merge($directChildren, $alsoInclude);
        array_multisort(
            array_column($menu,'name'),  SORT_ASC,SORT_STRING|SORT_FLAG_CASE,
            array_column($menu,'tid'),   SORT_ASC,
        $menu);

        foreach ( $menu as &$menuItem )
        {
            if ( !empty($this->source->entities[$menuItem['uuid']]) )
            {
               $menuItem['menu'] = $this->buildMainNavSubMenu($this->source->entities[$menuItem['uuid']]);
            }
        }

        return $menu;
    }
    public function buildMainNavSubMenu(&$page) 
    {
        $menu = [];

        $directChildren = $this->filteredDescendantPages($page,'children','generate_menu');
        array_multisort(
            array_column($directChildren,'weight'),SORT_ASC,
            array_column($directChildren,'name'),  SORT_ASC,SORT_STRING|SORT_FLAG_CASE,
            array_column($directChildren,'tid'),   SORT_ASC,
        $directChildren);

        $alsoInclude    = $this->filteredDescendantPages($page,'also_include_on_nav_page','generate_menu');
        array_multisort(
            array_column($alsoInclude,'name'),SORT_ASC,SORT_STRING|SORT_FLAG_CASE,
            array_column($alsoInclude,'tid'), SORT_ASC,
        $alsoInclude);

        $menu = array_merge($directChildren, $alsoInclude);
        return $menu;
    }
    public function buildNavMenu( &$page ) 
    {
        $menu = [];

        $directChildren = $this->filteredDescendantPages($page,'children','generate_menu');
        $alsoInclude    = $this->filteredDescendantPages($page,'also_include_on_nav_page','generate_menu');

        $menu = array_merge($directChildren, $alsoInclude);

        array_multisort(
            array_column($menu,'name'),SORT_ASC,SORT_STRING|SORT_FLAG_CASE,
            array_column($menu,'tid'), SORT_ASC,
        $menu);

        return $menu;
    }
    public function buildPageMenu( &$page ) 
    {
        $menu = [];

        $directChildren = $this->filteredDescendantPages($page,'children','generate_page');
        $alsoInclude    = $this->filteredDescendantPages($page,'also_include_on_nav_page','generate_page');

        $menu = array_merge($directChildren, $alsoInclude);

        array_multisort(
            array_column($menu,'name'),SORT_ASC,SORT_STRING|SORT_FLAG_CASE,
            array_column($menu,'tid'), SORT_ASC,
        $menu);

        return $menu;
    }

    public function filteredDescendantPages(&$page,$pageSourceKey='children',$generateCheckKey='generate_menu',$sortByKey=false,$sortByWeight=false)
    {
        if ( empty($page[$pageSourceKey]) ) { return []; }
        $pageList = [];
        foreach($page[$pageSourceKey] as $i=>$item)
        {
            if ( !is_array($item) || !array_key_exists('uuid',$item) || empty($item['uuid']) || empty($this->source->entities[$item['uuid']]) ) { continue; }
            $child =& $this->source->entities[$item['uuid']];
            if ( array_key_exists($generateCheckKey,$child) && $child[$generateCheckKey]=='no' ) { 
                continue; 
            }
            $listItem = [
                'uuid'=>$child['uuid'],
                'name'=>$child['name'],
                'friendly_url'=>$child['friendly_url'],
                'css_class'=>$child['css_class'],
                'description_meta'=>$child['description_meta'],
                'weight'=>$child['weight'],
                'tid'=>$child['tid'],
                'generate_menu'=>$child['generate_menu'],
                'generate_page'=>$child['generate_page'],
            ];
            $pageList[$child['uuid']] = $listItem;
        }
        return $pageList;
    }

    public function validatePage( $filename, $checkHtml = true )
    {
        $fileExists = file_exists($filename);
        $fileFilled = ( filesize($filename) > 0 );

        $fileValid = ( $fileExists && $fileFilled );
        
        if ( $checkHtml ) 
        {
            $fileHandle = fopen($filename, 'r');
            $fileHeader = fread($fileHandle, 100);
            fclose($fileHandle);
            $fileHeader = trim($fileHeader);
            $fileIsHtml = ( $fileHeader{0} == '<');
        }

        return ( $fileExists && $fileFilled && $fileIsHtml );
    }
    public function validateSite()
    {
        if ( empty($this->pagesByUrl) )
        {
            echo "Validate Site: no site found to validate\n";
            return null;
        }
        $requiredPages = 0;
        $renderedPages = 0;
        foreach ( $this->pagesByUrl as $url=>&$page )
        {
            $requiredPages++;
            $pageDir = rtrim( './sites/'.trim(strtolower($this->siteName),'/').'/'.trim($url,'/'), '/' );
            $pageFile = $pageDir.'/index.html';

            if ( $this->validatePage($pageFile) )
            {
                $renderedPages++;
            } else {
                echo "Invalid: {$url}\n";
            }

            /// some special pages generate further sub-pages
            if ( $page['pageType'] == 'AZPage' )
            {
                foreach ( $this->siteIndexAZ as $letter => $list )
                {
                    $requiredPages++;
                    $subUrl = $url.'/'.strtolower($letter);
                    $subPageDir = rtrim( $pageDir.'/'.trim(strtolower($letter),'/'), '/' );
                    $subPageFile = $subPageDir.'/index.html';
                    if ( $this->validatePage($subPageFile) )
                    {
                        $renderedPages++;
                    } else {
                        echo "Invalid: {$subUrl}\n";
                    }        
                }
            } else if ( $page['pageType'] == '50StatePage' ) {
                if ( !empty($page['usa_gov_50_state_category']) 
                  && preg_match('/^autogenerate\-(.*)/',$page['usa_gov_50_state_category']) )
                {
                    foreach ( $this->stateAcronyms as $stateAcronym=>$stateName ) 
                    {
                        $requiredPages++;
                        $subUrl = $url.'/'.$this->sanitizeForUrl($stateName);
                        if ( !empty($page['usa_gov_50_state_prefix']) )
                        {
                            $subUrl = $page['usa_gov_50_state_prefix']
                                        .'/'.$this->sanitizeForUrl($stateName);
                        }
                        $subPageDir = rtrim('./sites/'.trim(strtolower($this->siteName)).'/'.trim($subUrl,'/'), '/' );
                        $subPageFile = $subPageDir.'/index.html';
                        if ( $this->validatePage($subPageFile) )
                        {
                            $renderedPages++;
                        } else {
                            echo "Invalid: {$subUrl}\n";
                        }        
                    }
                }
            } else if ( $page['pageType'] == 'Features' ) {
    
                foreach ( $this->features[$this->siteName] as $feature ) 
                {
                    $requiredPages++;
                    $urlSafeTitle = $this->sanitizeForUrl($feature['title']);
                    $subUrl = $url.'/'.$urlSafeTitle;
                    $subPageDir = rtrim( $pageDir.'/'.$urlSafeTitle, '/');
                    $subPageFile = $subPageDir.'/index.html';
                    if ( $this->validatePage($subPageFile) )
                    {
                        $renderedPages++;
                    } else {
                        echo "Invalid: {$subUrl}\n";
                    }        
                }
            
            }
        }
        echo "Site Validation: $renderedPages of $requiredPages pages rendered to /sites/{$this->siteName} \n";
        return ($requiredPages <= $renderedPages);
    }

    public function renderSite( $renderPageOnFailure=false )
    {
        if ( empty($this->sitePage) )
        {
            echo "Render: site ... not found\n";
            return false;
        }
        $treeResult = $this->renderTree($this->sitePage);
        $redirectResult = $this->renderRedirects();
        //$redirectResult = true;
        if ( empty($treeResult) ||  empty($redirectResult) ) {
            echo "Render: site ... failed\n";
        } else {
            echo "Render: site ... done\n";
        }
        return $treeResult && $redirectResult;
    }
    public function renderTree( $page, $renderPageOnFailure=false )
    {
        if ( empty($page) )
        {
            return false;
        }
        $this->renderer->renderPage($page,$renderPageOnFailure);
        foreach ( $page['children'] as $childPage )
        {
            if ( !empty($childPage['uuid']) )
            {
                if ( !empty($this->source->entities[$childPage['uuid']]) )
                {
                    $child =& $this->source->entities[$childPage['uuid']];
                    $this->renderTree($child);
                }
            }
        }
        return true;
    }

    public function renderRedirects()
    {
        foreach ( $this->source->redirects as $redirect )
        {
            $this->renderer->renderRedirect($redirect);
        }
        return true;
    }

    public function getPageType( $page )
    {
        if ( array_key_exists('type_of_page_to_generate',$page)
             && is_string($page['type_of_page_to_generate']) )
        {
            $pageType = $page['type_of_page_to_generate'];
        } else if (
             empty($page['field_generate_page'])
          || empty($page['field_generate_page']['und'])
          || empty($page['field_generate_page']['und'][0])
          || empty($page['field_generate_page']['und'][0]['value'])
          ||       $page['field_generate_page']['und'][0]['value']!=='yes'
          || empty($page['field_type_of_page_to_generate'])
          || empty($page['field_type_of_page_to_generate']['und'])
          || empty($page['field_type_of_page_to_generate']['und'][0])
          || empty($page['field_type_of_page_to_generate']['und'][0]['value']) )
        {
            return null;
        } else {
            $pageType = $page['field_type_of_page_to_generate']['und'][0]['value'];
        }
        return $this->formatPageType($pageType);
    }

    public function formatPageType( $type )
    {
        $pageType = trim(strtolower($type));
        return preg_replace('/\s+/','',ucwords(str_replace(['-'],' ',$pageType)));
    }

    public function copy_recurse($src, $dst, $perm=null)
    {
        if ( empty($src) ) { 
            return;
        } else if (is_link($src)) {
            symlink(readlink($src), $dst);
        } elseif (is_dir($src)) {
            if ( !is_dir($dst) ) {
                mkdir($dst,0744,true);
            }
            if ( $perm ) { 
                chmod($dst,$perm); 
            }
            foreach (scandir($src) as $file) {
                if ($file != '.' && $file != '..') {
                    $this->copy_recurse("$src/$file", "$dst/$file");
                }
            }
        } elseif ( is_file($src) ) {
            if ( !is_file($dst) ) {
                if ( !is_dir(dirname($dst)) ) {
                    mkdir(dirname($dst),0744,true);
                }
                touch($dst);
            }
            copy($src, $dst);
            if ( $perm ) { 
                chmod($dst,$perm); 
            }
        } else {
            echo "WARNING: Cannot copy $src (unknown file type)\n";
        }
    }
    public function chmod_recurse($src, $perm)
    {
        if ( empty($src) ) { 
            return;
        } else if (is_link($src)) {
            return;
        } elseif (is_dir($src)) {
            chmod($src,$perm);
            foreach (scandir($src) as $file) {
                if ($file != '.' && $file != '..') {
                    $this->chmod_recurse("$src/$file",$perm);
                }
            }
        } elseif (is_file($src)) {
            chmod($src,$perm);
        } else {
            echo "WARNING: Cannot apply permissions to $src (unknown file type)\n";
        }
    }

}
