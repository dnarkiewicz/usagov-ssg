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
