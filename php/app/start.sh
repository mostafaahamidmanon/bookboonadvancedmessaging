#!/bin/sh
composer install
symfony server:ca:install
symfony proxy:domain:attach manondomain
symfony server:prod
symfony server:start -d