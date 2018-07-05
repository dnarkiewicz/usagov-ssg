# USAGOV SSG

Copy config/USA.gov.config-default.php to config/USA.gov.config.php
Update any git parameters to allow access to the Template source directory

PREPARE:
brew install php
brew install composer
git clone https://github.com/dnarkiewicz/usagov-ssg.git
cd usagov-ssg
composer install

RUN:
php ssg.php

CHECK:
cd sites/usa.gov
php -S localhost:8000

