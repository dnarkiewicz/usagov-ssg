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
  * `./ssg --freshdata`
  * `./ssg --freshtemplates`
  * `./ssg --freshdata --freshtemplates`
  * `./ssg --pushs3`
  * `./ssg --pushs3 --freshdata`
  * `./ssg --pushs3 --freshtemplates`
  * `./ssg --pushs3 --freshdata --freshtemplates`

### TEST:
* `./test`
  * `cd sites/usa.gov`
  * `php -S localhost:8000`

