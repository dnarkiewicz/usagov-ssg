<?php

namespace ctac\ssg;

class ProcessorMain
{
  public $renderer = null;
  public $page     = null;

  public function __construct( &$renderer, &$page )
  {
    $this->renderer =& $renderer;
    $this->page     =& $page;
  }

  public function process( &$params )
  {
    $params = array_merge($params,$this->page);
    // $params['page'] = $this->page;

    # global things provided for all pages

    $params['siteName']    = $this->renderer->ssg->siteName;

    $params['siteUrl']     = 'https://usa-stg.gsa.ctacdev.com/'; //prod-stage-test etc
    $params['gobSiteUrl']  = 'https://usa-gobierno-stg.gsa.ctacdev.com/'; //prod-stage-test etc
    $params['wwwSiteUrl']  = 'https://usa-stg.gsa.ctacdev.com/'; //prod-stage-test etc
    $params['blogSiteUrl'] = 'https://usa-blog-stg.gsa.ctacdev.com/'; //prod-stage-test etc
    
    $params['entities'] = $this->renderer->ssg->source->entities;

    $params['directoryRecordGroups'] = $this->renderer->ssg->directoryRecordGroups;
    $params['siteIndexAZ'] = $this->renderer->ssg->siteIndexAZ;
    $params['currentAZLetter'] = null;

    $params['features']        = $this->renderer->ssg->features;
    $params['featuresByTopic'] = $this->renderer->ssg->featuresByTopic;
    $params['stateDetails']    = $this->renderer->ssg->stateDetails;
    $params['stateAcronyms']   = $this->renderer->ssg->stateAcronyms;

    $params['sitePage'] = $this->renderer->ssg->sitePage;
    $params['homePage'] = $this->renderer->ssg->homePage;
    
  }
}
