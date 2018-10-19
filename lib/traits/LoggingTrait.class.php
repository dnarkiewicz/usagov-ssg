<?php

namespace ctac\ssg;

$GLOBALS['logMessage'] = '';

trait LoggingTrait
{
    public $runtimeEnvironment;

    public function determineRuntimeEnvironment()
    {
        if ( function_exists('variable_get') )
        {
            $this->runtimeEnvironment = 'drupal';
        } else if ( class_exists('\Aws\Sdk') ) {
            $this->runtimeEnvironment = 'standalone';
        } else {
            $this->runtimeEnvironment = 'standalone';
        }
    }

    public function log($msg,$debugOnly=true)
    {
        $GLOBALS['logMessage']  .= $msg;

        if ( $this->runtimeEnvironment == 'drupal' )
        {
            $result = db_query("
                UPDATE {ssg_builds} 
                SET 
                    log=concat(ifnull(log,''), :log), 
                    updated=UNIX_TIMESTAMP() 
                WHERE 
                    uuid=:uuid
            ",[
                ':uuid'=>$this->uuid,
                ':log'=>$msg
            ]);
            $msg = "SiteBuild:{$this->uuid} {$msg}";
            if ( $debugOnly )
            {
                return;
            }
            error_log(preg_replace("/[\n\r\t\s]+$/",'',$msg));
        } else {
            echo $msg;
        }
    }

}