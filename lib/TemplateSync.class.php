<?php

namespace ctac\ssg;

class TemplateSync
{
    public $ssg;

    public $source_dir;
    // public $source_template_base;
    public $source_template_dir;

    // public $dest_template_base;
    public $dest_template_dir;

    public $site_dir;

    public function __construct( &$ssg )
    {
        $this->ssg = &$ssg;

        // $repo_template_base = $this->ssg->config['templateSync']['repo_template_base'];
        // $repo_template_base = preg_replace('(^[\.\/]|[\.\/]$)','',$repo_template_base);

        $repo_template_dir = $this->ssg->config['templateSync']['repo_template_dir'];
        $repo_template_dir = preg_replace('(^[\.\/]|[\.\/]$)','',$repo_template_dir);

        $this->source_dir           = './templates/sync';
        $this->source_template_dir  = $this->source_dir.'/'.$repo_template_dir;

        $this->dest_dir             = './templates/twig';
        $this->dest_template_dir    = $this->dest_dir.'/'.$repo_template_dir;

        $this->site_dir             = './sites/'.trim(strtolower($this->ssg->siteName));
    }

    public function sync( $force_fresh_pull=null )
    {
        $prepare = $this->prepare();
        $pull    = $this->pull($force_fresh_pull);
        $assets  = $this->mergeAssets();
    }

    public function prepare()
    {
        echo "Templates: preparing directories ... ";
        $this->prepareDir($this->source_dir);
        // $this->prepareDir($this->source_template_base);
        $this->prepareDir($this->source_template_dir);
        $this->prepareDir($this->dest_dir);
        // $this->prepareDir($this->dest_template_base);
        $this->prepareDir($this->dest_template_dir);
        $this->prepareDir($this->site_dir);
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
            // echo "mkdir => {$path} \n";
            mkdir($path, 0744, true);
        }
        if ( !is_writable($path) )
        {
            // echo "chmod => {$path} \n";
            chmod($path, 0744 );
        }
        $real_path = realpath($path);
        if ( empty($real_path) )
        {
            return false;
        }
        if ( !is_dir($real_path) || !is_writable($real_path) )
        {
            // echo " $real_path not writable \n";
            return false;
        }
        // echo " $path = $real_path \n";
        $path = $real_path;
        return true;
    }

    public function pull( $type=false )
    {
        /// check for existing directory
        if ( $type=='force' || ( empty($type) && !$this->verifyPull() ) )
        {
            echo "Templates: pulling fresh templates ... ";
            if ( !empty($this->source_dir) && $this->source_dir !== '/' )
            {
                $remove_cmd = "rm -rf {$this->source_dir}";
                // echo $remove_cmd."\n";
                $rslt = `{$remove_cmd} 2>&1`;
            }

            /// grab data from source repo
            $git_repo = 'https://'.urlencode($this->ssg->config['templateSync']['repo_user'])
                    .':'.urlencode($this->ssg->config['templateSync']['repo_pass'])
                    .'@'.$this->ssg->config['templateSync']['repo_url'];
            
            $clone_cmd = "git clone '{$git_repo}' {$this->source_dir}";
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
            $branch_cmd = "cd {$this->source_dir} && git checkout {$this->ssg->config['templateSync']['repo_branch']}";
            // echo $branch_cmd."\n";
            $rslt = `{$branch_cmd} 2>&1`;
            if ( strpos($rslt, 'error') === 0 ) {
                echo("Error - Could not switch to branch \"{$this->ssg->config['templateSync']['repo_branch']}\" in source-repo.\n");
                return false;
            }
            echo "done\n";
            $this->mergeTemplates();
        } else if ( $type=='fresh' ) {
            echo "Templates: refreshing current templates ... ";
            /// use what we already have
            $update_cmd = "cd {$this->source_dir}"
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
        if ( !is_dir($this->source_template_dir) ) {
            //error_log("Template Sync: can't find template dir: $this->source_template_dir");
            $result = false;
        }
        $rslt = `cd {$this->source_dir} && git checkout {$this->ssg->config['templateSync']['repo_branch']} 2>&1 >/dev/null`;
        $branch_name = trim(`cd {$this->source_dir} && git rev-parse --abbrev-ref HEAD`);
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
            $template_file = "{$this->source_template_dir}/{$type}.twig";
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
            $template_file = "{$this->dest_template_dir}/{$type}.twig";
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
        $this->ssg->copy_recurse($this->source_template_dir,$this->dest_template_dir);
        // `cp -r {$this->source_template_base} {$this->dest_template_base}`;

        echo "done\n";
    }

    public function mergeAssets()
    {
        echo "Templates: merging public asset files ... ";

        if ( !is_writable($this->site_dir) )
        {
            $this->ssg->chmod_recurse($this->site_dir,0744);
        }
        // we want these /asset directories moved to root
        $asset_dirs = [ 'js', 'css', 'fonts', 'images' ];
        foreach ( $asset_dirs as $dir )
        {
            $source_asset_dir = "{$this->source_dir}/assets/{$dir}";
            $dest_asset_dir   = "{$this->site_dir}/{$dir}";
            if ( !is_dir($dest_asset_dir) )
            { 
                // echo "\nmkdir => $dest_asset_dir\n";
                mkdir($dest_asset_dir,0744,true);
                //`mkdir -p $dest_asset_dir`;
            }
            if ( !is_writable($dest_asset_dir) )
            {
                $this->ssg->chmod_recurse($dest_asset_dir,0744);
                //`chmod -r 0744 $dest_asset_dir`;
            }
            $this->ssg->copy_recurse($source_asset_dir,$dest_asset_dir);
            // `cp -r {$source_asset_dir} {$dest_asset_dir}`;
        }

        echo "done\n";
    }

}