# USAGOV SSG


### PREPARE:
* brew install php
* brew install composer
* git clone https://github.com/dnarkiewicz/usagov-ssg.git
* cd usagov-ssg
* composer install
* cp config/USA.gov.config-default.php config/USA.gov.config.php
* Update repo parameters to allow access to the Template source directory

### RUN:
* php ssg.php

### CHECK:
* cd sites/usa.gov
* php -S localhost:8000

