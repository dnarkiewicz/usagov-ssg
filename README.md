# USAGOV SSG

Copy config/USA.gov.config-default.php to config/USA.gov.config.php
Update any git parameters to allow access to the Template source directory

RUN:
php ssg.php

CHECK:
cd sites/usa.gov
php -S localhost:8000
