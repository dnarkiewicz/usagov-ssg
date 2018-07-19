<?php

namespace ctac\ssg;

class ConfigLoader
{
    public static function loadConfig( $name, $dir='config' )
    {
        $configFile = realpath( getcwd().'/'.$dir ) .'/'. trim(strtolower($name)).'.config.php';
        return self::loadFile($configFile);
    }

  	public static function loadFile( $fileName=null )
  	{
        if ( file_exists($fileName) )
        {
            require($fileName);
            if ( !empty($config) )
            {
                if ( !empty($config['aws']['aws_access_key_id']) )
                {
                    putenv('AWS_ACCESS_KEY_ID='.$config['aws']['aws_access_key_id']);
                }
                if ( !empty($config['aws']['aws_secret_access_key']) )
                {
                    putenv('AWS_SECRET_ACCESS_KEY='.$config['aws']['aws_secret_access_key']);
                }
                if ( !empty($config['aws']['aws_session_token']) )
                {
                    putenv('AWS_SESSION_TOKEN='.$config['aws']['aws_session_token']);
                }
                return $config;
            } else {
                error_log('Cannot find config within file '.$fileName);
            }
        } else {
            error_log('Cannot find file '.$fileName);
        }
        return [];
  	}

}
