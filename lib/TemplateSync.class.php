<?php

namespace ctac\ssg;

class TemplateSync
{
    public $ssg;

    public $sourceDir;
    public $sourceTemplateDir;
    public $destTemplateDir;
    public $siteDir;

    public $freshTemplates;

    public function __construct( &$ssg )
    {
        $this->ssg = &$ssg;

        $repoTemplateDir = $this->ssg->config['templateSync']['repo_template_dir'];
        $repoTemplateDir = preg_replace('(^[\.\/]|[\.\/]$)','',$repoTemplateDir);

        $this->sourceDir           = './templates/sync';
        $this->sourceTemplateDir  = $this->sourceDir.'/'.$repoTemplateDir;

        $this->destDir             = './templates/twig';
        $this->destTemplateDir    = $this->destDir.'/'.$repoTemplateDir;

        $this->siteDir             = './sites/'.trim(strtolower($this->ssg->siteName));
        
        $this->freshTemplates     = false;
    }

    public function sync()
    {
        $prepare = $this->prepare();
        $pull    = $this->pull();
        $assets  = $this->mergeAssets();
    }

    public function prepare()
    {
        echo "Templates: preparing directories ... ";
        $this->prepareDir($this->sourceDir);
        $this->prepareDir($this->sourceTemplateDir);
        $this->prepareDir($this->destDir);
        $this->prepareDir($this->destTemplateDir);
        $this->prepareDir($this->siteDir);
        echo "done\n";
    }
    public function prepareDir( &$path )
    {
        if ( empty($path) )
        {
            return false;
        }
        if ( !is_dir($path) )
        {
            mkdir($path, 0744, true);
        }
        if ( !is_writable($path) )
        {
            chmod($path, 0744 );
        }
        $real_path = realpath($path);
        if ( empty($real_path) )
        {
            return false;
        }
        if ( !is_dir($real_path) || !is_writable($real_path) )
        {
            return false;
        }
        $path = $real_path;
        return true;
    }

    public function pull()
    {
        $pullVerified = $this->verifyPull();
        /// check for existing directory
        if ( $this->freshTemplates && !$pullVerified )
        {
            echo "Templates: pulling fresh templates ... ";
            if ( !empty($this->sourceDir) && $this->sourceDir !== '/' )
            {
                $remove_cmd = "rm -rf {$this->sourceDir}";
                // echo $remove_cmd."\n";
                $rslt = `{$remove_cmd} 2>&1`;
            }

            /// grab data from source repo
            $git_repo = 'https://'.urlencode($this->ssg->config['templateSync']['repo_user'])
                    .':'.urlencode($this->ssg->config['templateSync']['repo_pass'])
                    .'@'.$this->ssg->config['templateSync']['repo_url'];
            
            $clone_cmd = "git clone '{$git_repo}' {$this->sourceDir}";
            // echo $clone_cmd."\n";
            $rslt = `{$clone_cmd} 2>&1`;
            
            if ( strpos($rslt, 'Authentication failed') !== false ) {
                echo("Error - Could not pull from source-repository due to authentication-error.\n");
                return false;
            }

            if ( strpos($rslt, 'not found') !== false ) {
                echo("Error - Could not find source-repository\n");
                return false;
            }

            /// switch to the branch we want
            $branch_cmd = "cd {$this->sourceDir} && git checkout {$this->ssg->config['templateSync']['repo_branch']}";
            // echo $branch_cmd."\n";
            $rslt = `{$branch_cmd} 2>&1`;
            if ( strpos($rslt, 'error') === 0 ) {
                echo("Error - Could not switch to branch \"{$this->ssg->config['templateSync']['repo_branch']}\" in source-repo.\n");
                return false;
            }
            echo "done\n";
            $this->mergeTemplates();
        } else if ( $this->freshTemplates && $pullVerified ) {
            echo "Templates: refreshing current templates ... ";
            /// use what we already have
            $update_cmd = "cd {$this->sourceDir}"
                         ." && git checkout {$this->ssg->config['templateSync']['repo_branch']} 2>&1 >/dev/null"
                         ." && git pull";
            // echo $update_cmd."\n";
            $rslt = `{$update_cmd} 2>&1`;
            echo "done\n";
            $this->mergeTemplates();
        } else if ( !$this->verifyDestTemplatesExist() ) {
            echo "Templates: using synced templates\n";
            $this->mergeTemplates();
        } else {
            echo "Templates: using existing templates\n";
        }
        return $this->verifyPull() && $this->verifyDestTemplatesExist();
    }

    public function verifyPull()
    {
        /// check to make sure everything is there that we need
        /// we need, at minimum, a template dir and one template named after each page type
        /// we could return false right away - but then we miss all the sweet errors
        $result = true;
        if ( !is_dir($this->sourceTemplateDir) ) {
            //error_log("Template Sync: can't find template dir: $this->sourceTemplateDir");
            $result = false;
        }
        $rslt = `cd {$this->sourceDir} && git checkout {$this->ssg->config['templateSync']['repo_branch']} 2>&1 >/dev/null`;
        $branch_name = trim(`cd {$this->sourceDir} && git rev-parse --abbrev-ref HEAD`);
        if ( $branch_name != $this->ssg->config['templateSync']['repo_branch'] )
        {
            //error_log("Template Sync: not in correct branch '{$this->ssg->config['templateSync']['repo_branch']}' != '$branch_name'");
            $result = false;
        }
        return $result && $this->verifySourceTemplatesExist();
    }

    public function verifySourceTemplatesExist()
    {
        /// we could return false right away - but then we miss all the sweet errors
        $result = true;
        foreach ( $this->ssg->pageTypes as $type )
        {
            $template_file = "{$this->sourceTemplateDir}/{$type}.twig";
            // echo "verifying $template_file ... \n";
            if ( !file_exists($template_file) )
            {
                // error_log("Template Sync: verify local: can't find template for $type: $template_file");
                $result = false;
            }
        }
        return $result;
    }

    public function verifyDestTemplatesExist()
    {
        return true;
        /// we could return false right away - but then we miss all the sweet errors
        $result = true;
        foreach ( $this->ssg->pageTypes as $type )
        {
            $template_file = "{$this->destTemplateDir}/{$type}.twig";
            // echo "verifying $template_file ... \n";
            if ( !file_exists($template_file) )
            {
                error_log("Template Sync: verify local: can't find template for $type: $template_file");
                $result = false;
            }
        }
        return $result;
    }

    public function mergeTemplates()
    {
        echo "Templates: merging template files ... ";
 
        // we want the template directories somewhere we can use them
        // echo "cp -r {$this->sourceTemplateDir} {$this->destTemplateDir}";
        $this->ssg->copy_recurse($this->sourceTemplateDir,$this->destTemplateDir);

        echo "done\n";
    }

    public function mergeAssets()
    {
        echo "Templates: merging public asset files ... ";

        if ( !is_writable($this->siteDir) )
        {
            $this->ssg->chmod_recurse($this->siteDir,0744);
        }
        // we want these /asset directories moved to root
        $asset_dirs = [ 'js', 'css', 'fonts', 'images' ];
        foreach ( $asset_dirs as $dir )
        {
            $sourceAssetDir = "{$this->sourceDir}/assets/{$dir}";
            $destAssetDir   = "{$this->siteDir}/{$dir}";
            if ( !is_dir($destAssetDir) )
            { 
                mkdir($destAssetDir,0744,true);
            }
            if ( !is_writable($destAssetDir) )
            {
                $this->ssg->chmod_recurse($destAssetDir,0744);
            }
            $this->ssg->copy_recurse($sourceAssetDir,$destAssetDir);
            /****/
            # TMP LOCATION
            $destAssetDir   = "{$this->siteDir}/sites/all/themes/usa/{$dir}";
            if ( !is_dir($destAssetDir) )
            { 
                mkdir($destAssetDir,0744,true);
            }
            if ( !is_writable($destAssetDir) )
            {
                $this->ssg->chmod_recurse($destAssetDir,0744);
            }
            $this->ssg->copy_recurse($sourceAssetDir,$destAssetDir);
            /****/
        }

        echo "done\n";
    }

}