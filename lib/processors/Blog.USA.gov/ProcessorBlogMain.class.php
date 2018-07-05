<?php

namespace ctac\ssg;

class ProcessorBlogMain
{
  public $renderer;
  public $page;

  function __contructor( &$renderer, &$page )
  {
    $this->renderer =& $renderer;
    $this->page =& $page;
  }

  function process( &$params )
  {
    $this->setMainParams($params);
  }

  public function setMainParams( &$params )
  {
    $params['uuid'] = $this->page['uuid'];
    $params['name'] = $this->page['name'];
    $params['siteUrl']   = !empty($this->renderer->ssg->config['siteUrl']) ? $this->renderer->ssg->config['siteUrl'] : '';
    $params['pageTitle'] = $this->page['name'];
    $params['toggleHTML'] = '';
    $params['menuTerms']  = '';
    $params['mobileMenuHTML'] = $this->renderer->ssg->sitePage['field_head_html']['und'][0]['value'];
    $params['footerHtml']     = $this->renderer->ssg->sitePage['field_end_html']['und'][0]['value'] . $this->page['field_head_html']['und'][0]['value'];
  }

}
