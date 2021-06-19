# Smart School

## features
SPA with vueJS  
API Authentication using Laravel Sanctum  

## environment
PHP 8.0.4RC1 (cli)  
Laravel Framework 8.33.1  
MySQL 5.7.24  

## libraries
composer require spatie/laravel-permission  
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"  
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"  

composer require laravel/sanctum  
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"  

in config/sanctum.php:  
'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1,laravel.test' <-- ADD DOMAIN HERE  

## configure database
CREATE USER 'customer_mgr'@'localhost' IDENTIFIED BY 'customer_mgr_pwd';  
CREATE DATABASE 'customer';  
GRANT ALL PRIVILEGES ON customer.* TO 'customer_mgr'@'localhost';  

## .env
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=YOUR_DATABASE  
DB_USERNAME=YOUR_USERNAME  
DB_PASSWORD=YOUR_PASSWORD  

## laravel 8.0
composer require laravel/legacy-factories  

## database migration
php artisan migrate:fresh --seed  

## clear cache
composer install  
php artisan optimize  
php artisan storage:link  
php artisan cache:clear  
php artisan clear-compiled  

## deploy development server
php -S localhost:8000 -t public  

## Node
v12  
npm install  
npm run dev  
npm run watch  

# access denied
setenforce 0  
-or-  
sudo setsebool -P httpd_can_sendmail 1  
sudo setsebool -P httpd_can_network_connect 1  

## Tech Stacks
Laravel Framework 8.47.0  
PHP 7.3.28  
VueJS v3.1.1 / npm v7.17.0 / node v12.22.1  
MySQL Ver 15.1 Distrib 10.3.28-MariaDB  
Bootstrap v4  
Linux distro: RHEL 8.4  

<img src="../main/screenshots/portal-about.JPG" width="60%">
