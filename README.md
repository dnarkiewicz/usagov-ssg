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
  * `./ssg --fresh-data --local-redirects` to use redirects listed in a local file rather than from data source
  * `./ssg --fresh-templates` to pull a fresh set of templates, default to local templates
  * `./ssg --push-s3` to deploy the site to an s3 bucket
  * `./ssg --no-debug-pages` to not generate fake pages with debug info on failure
  * `./ssg --fractal-examples` to generate a directory of example data useful for fractal

### TEST:
* `./test`
  * `cd sites/usa.gov`
  * `php -S localhost:8000`
  * OR `sudo php -S localhost:80`

