# USAGOV SSG


### PREPARE:
* `brew install php`
* `brew install composer`
* `brew install awscli`
* `git clone https://github.com/dnarkiewicz/usagov-ssg.git`
* `cd usagov-ssg`
* `composer install`
* `cp config/USA.gov.config-default.php config/USA.gov.config.php`
* edit config/USA.gov.config.php to update parameters for TemplateSync source
* edit config/USA.gov.config.php to update parameters for Destination S3 Bucket

### RUN:
* `./ssg`
* options:
  * `./ssg --fresh-data` to pull a fresh set of data, defaults to cached data
  * `./ssg --fresh-templates` to pull a fresh set of templates, default to local templates
  * `./ssg --deploy` to deploy the site to an s3 bucket
  * `./ssg --no-debug-pages` to not generate fake pages with debug info on failure

### TEST:
* `./test`
  * `cd sites/usa.gov`
  * `php -S localhost:8000`
  * OR `sudo php -S localhost:80`

 
