<?php

namespace ctac\ssg;

class SiteDestination
{
    public $ssg;
    public $source;
    public $dest;
    public $bads;
    public $s3Sync;
    public $s3Pull;
    public $sourceInventory;
    public $destInventory;

	public function __construct( $ssg )
	{
        $this->ssg = $ssg;
        
        $this->source = './sites/'.trim(strtolower($this->ssg->siteName));
        $this->dest   = 's3://'.trim($this->ssg->config['aws']['bucket']);

        $this->s3Sync = "aws s3 sync {$this->source} {$this->dest} --delete";
        $this->s3Pull = "aws s3 sync {$this->dest} {$this->source} --delete";

        $this->bads = [ 'command not found', 'usage', 'error' ];
    }
    
    public function generateInventoryFiles()
    {
        $sourceInventory = $this->getFilesInDir($this->source);
        $destInventoryFile = $this->dest.'/inventory.json';
        if ( file_exists($destInventoryFile) )
        {
            $destInventoryData = file_get_contents($destInventoryFile);
            // if ( )
        }
        // $destInventory
    }

    public function sync()
    {
        $this->generateInventoryFile();
        // echo "Syncing to destination bucket\n";
        // try using the aws command-line tool on whole directory
        // if (!($filesSynced = $this->syncFilesCli()))
        // {
            echo "Sync Files ... trying sdk\n";
            $filesSynced = $this->syncFilesSdk();
        // }
        if ( !$filesSynced ) 
        { 
            echo "Sync Files ... aws sdk failed\n";
            return false; 
        }
        $filesSynced = true;

        $redirectsSynced = $this->syncRedirects();
        if ( !$redirectsSynced ) 
        { 
            echo "Sync Redirects ... failed\n";
            return false; 
        }

        return ( $filesSynced && $redirectsSynced );
    }

    public function syncFilesCli()
    {
        $looksGood = true;

        echo $this->s3Sync." --dryrun\n";
        $result = `{$this->s3Sync} --dryrun`;
        foreach ( $this->bads as $bad )
        {
            if ( stristr($bad,$result) )
            {
                $looksGood = false;
            }
        }
        if ( $looksGood )
        {
            echo $this->s3Sync."\n";
            $result = `{$this->s3Sync}`;
            foreach ( $this->bads as $bad )
            {
                if ( stristr($bad,$result) )
                {
                    $looksGood = false;
                }
            }
        }
        return $looksGood;
    }

    public function syncFilesSdk()
    {
        $sdk = new \Aws\Sdk($this->ssg->config['aws']);
        $s3 = $sdk->createS3();
        $s3->registerStreamWrapper();

        /// get local and remote file listings
        $removeFromDest = [];
        $destFiles   = $this->getFilesInDir($this->dest);
        $sourceFiles = $this->getFilesInDir($this->source);

        /// remove any old files
        foreach ( $destFiles as $key=>$destFile )
        {
            if ( preg_match('/index.html$/',$key) && !preg_match('/^index.html/',$key) )
            {
                $key = dirname($key);
            }
            if ( $key == '.' || $key == '..' ) { continue; }
            /// if remote-destination has no local-source equiv
            ///     it should be removed from remote-destination
            if ( !array_key_exists($key,$sourceFiles) )
            {
                echo "Remove from destination : $key\n";
                flush();
                $removeFromDest[] = $key;
            }
        }
        if ( !empty($removeFromDest) )
        {
            // $s3->deleteObjects([
            //     'Bucket'  => $this->ssg->config['aws']['bucket'],
            //     'Delete' => [
            //         'Objects' => array_map(function ($key) {
            //             return ['Key' => $key];
            //         }, $removeFromDest)
            //     ],
            // ]);
        }

        /// add/update any new/changed files
        foreach ( $sourceFiles as $key=>$sourceFile )
        {
            if ( preg_match('/index.html$/',$key) && !preg_match('/^index.html/',$key) )
            {
                $key = dirname($key);
            }
            if ( $key == '.' || $key == '..' ) { continue; }
            /// if local-source has no remote-destination equiv
            ///     it should be added to remote-destination
            if ( !array_key_exists($key,$destFiles) )
            {
                echo "Sync: Create $key\n";
                flush();
                try {
                    $s3->putObject([
                        'Bucket' => $this->ssg->config['aws']['bucket'],
                        'Key'    => $key,
                        'Body'   => fopen($sourceFile['path'], 'r'),
                        'ACL'    => 'public-read',
                        //'WebsiteRedirectLocation' => '',
                    ]);
                } catch (\Aws\S3\Exception\S3Exception $e) {
                    echo "Sync: There was an error adding the file $key.\n";
                    flush();
                }
            } else { /// this file exists on both places
                $destFile = $destFiles[$key];
                /// this file has changed
                if ( $destFile['md5'] != $sourceFile['md5'] ) 
                {
                    echo "Sync: Update $key\n";
                    flush();
                    try {
                        $s3->putObject([
                            'Bucket' => $this->ssg->config['aws']['bucket'],
                            'Key'    => $key,
                            'Body'   => fopen($sourceFile['path'], 'r'),
                            'ACL'    => 'public-read',
                            // 'WebsiteRedirectLocation' => '',
                        ]);
                    } catch (\Aws\S3\Exception\S3Exception $e) {
                        echo "Sync: There was an error updating the file $key.\n";
                        flush();
                    }
                } else {
                    echo "Sync: NoChange $key\n";
                    flush();
                }
            }
        }
        echo "\n";
    }

    public function syncRedirects()
    {
return true;
        $sdk = new \Aws\Sdk($this->ssg->config['aws']);
        $s3 = $sdk->createS3();

        $sourceFiles = $this->getFilesInDir($this->source);
        foreach ( $sourceFiles as $key=>$sourceFile )
        {
            // echo "check for redirect in $key \n";
            $html = file_get_contents($sourceFile['path']);
            if ( stristr($html,'http-equiv="refresh"') )
            {
                $m = [];
                if ( preg_match("/http\-equiv=\"refresh\"\s+content=\"\d+;url=\'?(.*?)\'?\" \/\>/",$html,$m) ) 
                {
                    if ( !empty($m[1]) )
                    {
                        echo "Sync: Redirect @ $key => {$m[1]}\n";
                        flush();

                        $s3->putObject([
                            'Bucket' => $this->ssg->config['aws']['bucket'],
                            'Key'    => $key,
                            'WebsiteRedirectLocation' => $m[1]
                        ]);
                    }
                }
            }
        }
        // foreach ( $this->ssg->source->redirects as $redirect )
        // {
        //     $path = ltrim($redirect['source_path'],'/');
        //     if ( !empty($path) && substr($path,-1)!=='/' ) { $path .= '/'; }
        //     $base = basename($path);
            
        //     $siteDir = $this->ssg->config['baseDir'].'/sites/'.trim(strtolower($this->ssg->siteName));
        //     $fileDir = $siteDir.'/'.$path;
        //     if ( $base !== 'index.html' ) 
        //     { 
        //         $file = $fileDir.'/index.html';
        //     } else {
        //         $file = $fileDir;
        //     }
        // }
        return true;
    
    }

    public function getFilesInDir($targetDir)
    {
        echo "Getting files in dir: $targetDir\n";
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($targetDir));
        $files    = [];
        foreach ($iterator as $file) 
        {
            if (!$file->isDir())
            {
                $path = $file->getPathname();
                echo "Getting File : $path\n";
                $key = str_replace($targetDir.'/','',$path);
                if ( preg_match('/index.html$/',$key) && !preg_match('/^index.html/',$key) )
                {
                    $key = dirname($key);
                }
                if ( $key == '.' || $key == '..' ) { continue; }    
                $files[$key] = [
                    'key'=>$key,
                    'path'=>$path,
                    'md5'=>md5_file($path)
                ];
            }
        }
        ksort($files);
        return $files;
    }

}