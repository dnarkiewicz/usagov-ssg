<?php

namespace ctac\ssg;

class DataSource
{
	public $ssg;
	public $entities;
	public $entitiesById;
	public $redirects;
	public $useLocalRedirects;

	public function __construct( $ssg )
	{
		$this->ssg          = $ssg;
		$this->entities     = [];
   		$this->entitiesById = [ 'tid'=>[], 'nid'=>[] ];
		$this->redirects    = [];
		$this->useLocalRedirects = false;
	}

	public function pull( $since=0 )
	{
		$this->getEntities($since);
		$this->getRedirects();
	}

	public function getEntities( $since=0 )
	{
		$this->entities     = [];
		$this->entitiesById = [ 'tid'=>[], 'nid'=>[] ];
	}

	public function getRedirects()
	{
		$this->redirects    = [];
	}

}
