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
                    $fubs[]     = 'all';

                    /// groupings are done by these fields 
                    /// there is 'all' variation for FUB, STATE, and GROUP_BY but not TYPE
                    /// directoryRecordGroups[$fub][$state][$type][$group_by]

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
                        if ( ( /* array_key_exists('show_on_az_index',$entity)
                                && trim(strtolower($entity['show_on_az_index'])) == 'yes'
                                && */ trim(strtolower($type)) == 'federal agencies' )
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
                        if ( /*array_key_exists('show_on_az_index',$entity)
                             && trim(strtolower($entity['show_on_az_index'])) == 'yes'
                             && */ trim(strtolower($type)) == 'federal agencies' )
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
                            $letter = strtoupper($entity['title']{0});
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
                $sharesTopic = array_filter($sharesTopic, function($v) {
                    return isset($v['created']) && $v['created'] > time()-1209600;///two weeks ago  3600*24*7*2;
                });
                array_multisort(
                    array_column($sharesTopic,'created'), SORT_ASC,
                    array_column($sharesTopic,'changed'), SORT_ASC,
                    $sharesTopic
                );
                if ( !empty($sharesTopic) )
                {
                   $first = array_shift($sharesTopic);
                   $this->source->entities[$uuid]['whats_new'] = [ 'uuid'=>$first['uuid'], 'title'=>$first['title'] ];
                } else {
                    $this->source->entities[$uuid]['whats_new'] = null;
                }
            }
        }

        foreach ( $this->stateDetails as $fub=>&$details )
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
                            $feature['shares_topic'][$sharesTopic['uuid']] = [
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

    public function sanitizeForUrl( $string='' )
    {
        $string = $this->_remove_accents($string);
    
        $string = trim($string);
        $string = strtolower($string);
        $string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $string);
    
        $replaceWithDash = array('_', '/', "\\", ' ', '.', '~', '(', ')', '[', ']', ':', ';', '!', '@', '”', '"', "'", "?",",");
    
        $string = str_replace($replaceWithDash, '-', $string);
    
        while ( strpos($string, '--') !== false ) {
            $string = str_replace('--', '-', $string);
        }
    
        $string = trim($string, '-');
        return $string;
    }
    
    public function _remove_accents($string)
    {
        if ( !preg_match('/[\x80-\xff]/', $string) )
            return $string;
    
        if ($this->_seems_utf8($string)) {
            $chars = array(
                // Decompositions for Latin-1 Supplement
                chr(194).chr(170) => 'a', chr(194).chr(186) => 'o',
                chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
                chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
                chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
                chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
                chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
                chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
                chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
                chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
                chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
                chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
                chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
                chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
                chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
                chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
                chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
                chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
                chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
                chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
                chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
                chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
                chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
                chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
                chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
                chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
                chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
                chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
                chr(195).chr(182) => 'o', chr(195).chr(184) => 'o',
                chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
                chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
                chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
                chr(195).chr(191) => 'y', chr(195).chr(152) => 'O',
                // Decompositions for Latin Extended-A
                chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
                chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
                chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
                chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
                chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
                chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
                chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
                chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
                chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
                chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
                chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
                chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
                chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
                chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
                chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
                chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
                chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
                chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
                chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
                chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
                chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
                chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
                chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
                chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
                chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
                chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
                chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
                chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
                chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
                chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
                chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
                chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
                chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
                chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
                chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
                chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
                chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
                chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
                chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
                chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
                chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
                chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
                chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
                chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
                chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
                chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
                chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
                chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
                chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
                chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
                chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
                chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
                chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
                chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
                chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
                chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
                chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
                chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
                chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
                chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
                chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
                chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
                chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
                chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
                // Decompositions for Latin Extended-B
                chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
                chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
                // Euro Sign
                chr(226).chr(130).chr(172) => 'E',
                // GBP (Pound) Sign
                chr(194).chr(163) => '',
                // Vowels with diacritic (Vietnamese)
                // unmarked
                chr(198).chr(160) => 'O', chr(198).chr(161) => 'o',
                chr(198).chr(175) => 'U', chr(198).chr(176) => 'u',
                // grave accent
                chr(225).chr(186).chr(166) => 'A', chr(225).chr(186).chr(167) => 'a',
                chr(225).chr(186).chr(176) => 'A', chr(225).chr(186).chr(177) => 'a',
                chr(225).chr(187).chr(128) => 'E', chr(225).chr(187).chr(129) => 'e',
                chr(225).chr(187).chr(146) => 'O', chr(225).chr(187).chr(147) => 'o',
                chr(225).chr(187).chr(156) => 'O', chr(225).chr(187).chr(157) => 'o',
                chr(225).chr(187).chr(170) => 'U', chr(225).chr(187).chr(171) => 'u',
                chr(225).chr(187).chr(178) => 'Y', chr(225).chr(187).chr(179) => 'y',
                // hook
                chr(225).chr(186).chr(162) => 'A', chr(225).chr(186).chr(163) => 'a',
                chr(225).chr(186).chr(168) => 'A', chr(225).chr(186).chr(169) => 'a',
                chr(225).chr(186).chr(178) => 'A', chr(225).chr(186).chr(179) => 'a',
                chr(225).chr(186).chr(186) => 'E', chr(225).chr(186).chr(187) => 'e',
                chr(225).chr(187).chr(130) => 'E', chr(225).chr(187).chr(131) => 'e',
                chr(225).chr(187).chr(136) => 'I', chr(225).chr(187).chr(137) => 'i',
                chr(225).chr(187).chr(142) => 'O', chr(225).chr(187).chr(143) => 'o',
                chr(225).chr(187).chr(148) => 'O', chr(225).chr(187).chr(149) => 'o',
                chr(225).chr(187).chr(158) => 'O', chr(225).chr(187).chr(159) => 'o',
                chr(225).chr(187).chr(166) => 'U', chr(225).chr(187).chr(167) => 'u',
                chr(225).chr(187).chr(172) => 'U', chr(225).chr(187).chr(173) => 'u',
                chr(225).chr(187).chr(182) => 'Y', chr(225).chr(187).chr(183) => 'y',
                // tilde
                chr(225).chr(186).chr(170) => 'A', chr(225).chr(186).chr(171) => 'a',
                chr(225).chr(186).chr(180) => 'A', chr(225).chr(186).chr(181) => 'a',
                chr(225).chr(186).chr(188) => 'E', chr(225).chr(186).chr(189) => 'e',
                chr(225).chr(187).chr(132) => 'E', chr(225).chr(187).chr(133) => 'e',
                chr(225).chr(187).chr(150) => 'O', chr(225).chr(187).chr(151) => 'o',
                chr(225).chr(187).chr(160) => 'O', chr(225).chr(187).chr(161) => 'o',
                chr(225).chr(187).chr(174) => 'U', chr(225).chr(187).chr(175) => 'u',
                chr(225).chr(187).chr(184) => 'Y', chr(225).chr(187).chr(185) => 'y',
                // acute accent
                chr(225).chr(186).chr(164) => 'A', chr(225).chr(186).chr(165) => 'a',
                chr(225).chr(186).chr(174) => 'A', chr(225).chr(186).chr(175) => 'a',
                chr(225).chr(186).chr(190) => 'E', chr(225).chr(186).chr(191) => 'e',
                chr(225).chr(187).chr(144) => 'O', chr(225).chr(187).chr(145) => 'o',
                chr(225).chr(187).chr(154) => 'O', chr(225).chr(187).chr(155) => 'o',
                chr(225).chr(187).chr(168) => 'U', chr(225).chr(187).chr(169) => 'u',
                // dot below
                chr(225).chr(186).chr(160) => 'A', chr(225).chr(186).chr(161) => 'a',
                chr(225).chr(186).chr(172) => 'A', chr(225).chr(186).chr(173) => 'a',
                chr(225).chr(186).chr(182) => 'A', chr(225).chr(186).chr(183) => 'a',
                chr(225).chr(186).chr(184) => 'E', chr(225).chr(186).chr(185) => 'e',
                chr(225).chr(187).chr(134) => 'E', chr(225).chr(187).chr(135) => 'e',
                chr(225).chr(187).chr(138) => 'I', chr(225).chr(187).chr(139) => 'i',
                chr(225).chr(187).chr(140) => 'O', chr(225).chr(187).chr(141) => 'o',
                chr(225).chr(187).chr(152) => 'O', chr(225).chr(187).chr(153) => 'o',
                chr(225).chr(187).chr(162) => 'O', chr(225).chr(187).chr(163) => 'o',
                chr(225).chr(187).chr(164) => 'U', chr(225).chr(187).chr(165) => 'u',
                chr(225).chr(187).chr(176) => 'U', chr(225).chr(187).chr(177) => 'u',
                chr(225).chr(187).chr(180) => 'Y', chr(225).chr(187).chr(181) => 'y',
                // Vowels with diacritic (Chinese, Hanyu Pinyin)
                chr(201).chr(145) => 'a',
                // macron
                chr(199).chr(149) => 'U', chr(199).chr(150) => 'u',
                // acute accent
                chr(199).chr(151) => 'U', chr(199).chr(152) => 'u',
                // caron
                chr(199).chr(141) => 'A', chr(199).chr(142) => 'a',
                chr(199).chr(143) => 'I', chr(199).chr(144) => 'i',
                chr(199).chr(145) => 'O', chr(199).chr(146) => 'o',
                chr(199).chr(147) => 'U', chr(199).chr(148) => 'u',
                chr(199).chr(153) => 'U', chr(199).chr(154) => 'u',
                // grave accent
                chr(199).chr(155) => 'U', chr(199).chr(156) => 'u',
            );
    
            $string = strtr($string, $chars);
        } else {
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
                .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
                .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
                .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
                .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
                .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
                .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
                .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
                .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
                .chr(252).chr(253).chr(255);
    
            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
    
            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }
    
        return $string;
    }
    
    public function _seems_utf8($str)
    {
        $length = strlen($str);
        for ($i=0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80) $n = 0; # 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
            elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
            elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
            elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
            elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
            else return false; # Does not match any model
            for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;
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
