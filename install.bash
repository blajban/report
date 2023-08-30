#!/bin/bash

composer install
npm install 
npm run build
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate