# The complete project is on "master" branch, instead of "main"

## CountryApp
Test task with php, composer/packagist , vue.js 3.0 and ecossytem + element plus ui 

## Install
composer install - will pull all the dependencies from packagist

## Run
php -S 127.0.0.1:8000  - with php-cli version 7.4 

The client-app whose readme.md is in it's own directory normaly runs on localhost:8080 so the communication will go between these two ports. The entry point of the php api in index.php has header modifier to allow the cors between the client and server. 

- This client project works with axios, and jwt bearer auth2.0 provided by the servers firebase/php-jwt package. For now it returns regular accessToken with expiry interval, and normally it would return a refreshToken too. 

- DDL export from the database (phpmyadmin interface) will be available to import and use directly. 

-Additionaly this can be expanded with maps functionality, maybe Google Maps provider or ArcGis, services that require subscription for api-key.
