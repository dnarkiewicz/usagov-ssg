<?php

namespace ctac\ssg;

class SiteDestination
{
	public $ssg;

	public function __construct( $ssg )
	{
		$this->ssg = $ssg;
	}

    public function validatePush()
    {

    }

    public function push()
    {
        /**
         solution: aws s3 sync --delete
          
        find local site directory
        generate hashes for each local file
        store hashes in hash file
        grab hashes from remote destination
        compare hash file itself - if no changes, abort
        ????
            prep local dir with changes only 
                - so only one AWS SYNC command is necessary
                - files not in local are deleted from destination
            OR
            compare each file's hashes 
                - if no match, sync up that file
                - if in dest and not in local, remove from dest
            OR
            check site-wide hash, but don't worry about file specific hashes 
                - sync up whole site to a timestamped dir
                - reset bucket to use new dir as siteroot
         **/
    }

    public function deployPush()
    {
    }
}