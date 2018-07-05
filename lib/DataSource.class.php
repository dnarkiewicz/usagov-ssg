<?php

namespace ctac\ssg;

class DataSource
{
	public $ssg;
	public $entities;
  public $entitiesById;

	public function __construct( $ssg )
	{
		$this->ssg          = $ssg;
		$this->entities     = [];
    $this->entitiesById = [ 'tid'=>[], 'nid'=>[] ];
	}

	public function getEntities( $since=0 )
	{
    $this->entities     = [];
    $this->entitiesById = [ 'tid'=>[], 'nid'=>[] ];
    return;
	}

}
