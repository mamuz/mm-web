# mm-web

[![Build Status](https://travis-ci.org/mamuz/mm-web.svg?branch=master)](https://travis-ci.org/mamuz/mm-web)
[![Dependency Status](https://www.versioneye.com/user/projects/53628797fe0d07768b0001e5/badge.png)](https://www.versioneye.com/user/projects/53628797fe0d07768b0001e5)
[![Coverage Status](https://coveralls.io/repos/mamuz/mm-web/badge.png?branch=master)](https://coveralls.io/r/mamuz/mm-web?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mamuz/mm-web/badges/quality-score.png?s=b03a2d5d3c33bcf30edec09a0f7ce9fa5a554df9)](https://scrutinizer-ci.com/g/mamuz/mm-web/)

Homepage with ZF2 and Doctrine2

## Domain

Practices, principles and patterns about web-development with PHP

## Functional Features

- Skeleton with twitter-Bootstrap
- Contact
- ContentManager
- Responsive Frontend
- Blog: Postlist is infinitive

## Non-Functional Features

- Composer
- ErrorLogging
- Recaptcha by GoogleApi
- GoogleTracking Plugin
- Reportmail for new contact entry
- UserInput Filter
- Markdown parser for ContentManager and BlogPosts
- ORM
- AnnotationBuilder
- Hashed Repository Identities
- Config Cache
- Autoload classmap
- Custom ServiceManager for each module
- GitHub, Travis-CI, Coveralls.io and VersionEye
- PHPUnit with Mockery

## Installation

### Create Application

```sh
cd /var/www
```
```sh
git clone https://github.com/mamuz/mm-web.git
```
```sh
cd mm-web
```
```sh
php composer.phar self-update; php composer.phar install
```

### Apache Setup

Add virtual host to apache

```sh
<VirtualHost *:80>
    DocumentRoot /var/www/mm-web/public
    ServerName local.mm-web.de
    AccessFileName .htaccess
    SetEnv APPLICATION_ENV "development"
    <Location />
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} -s [OR]
        RewriteCond %{REQUEST_FILENAME} -l [OR]
        RewriteCond %{REQUEST_FILENAME} -d
        RewriteRule ^ - [NC,L]
        RewriteRule ^ /index.php [NC,L]
    </Location>
    <Directory "/var/www/mm-web/public">
        DirectoryIndex index.php
        Options Indexes MultiViews FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

Add servername 'local.mm-web.de' to host file and restart apache server.

### Data directory

Create an directory for temporaly data

```sh
mkdir -p /var/www/mm-web/data/logs
```
```sh
mkdir -p /var/www/mm-web/data/cache
```
```sh
mkdir -p /var/www/mm-web/data/DoctrineORMModule
```
```sh
chmod -R 0775 /var/www/mm-web/data
```

### Environment

Virtual Host config already defined an APPLICATION_ENV to "development".
For other environments change it to "staging" or "production".
TestEnvironment is defined by "testing".
Besides Virtual Host config an APPLICATION_ENV can be defined in public/environment.php which will be included
by public/index.php.

```php
putenv("APPLICATION_ENV=development");
```

## Composer

Dependencies are handled by Composer package manager.

```sh
php composer.phar self-update; php composer.phar update
```

## Testrunner

In test directory an over all module tesrunner exists.
Be sure that each module is defined in test\config.php and in test\phpunit.xml.
Each module must have an autoloader classmap.

### Execute Testrunner

```sh
phpunit -c test/
```

### Autoload Classmap

Each module must have an autoloader classmap

```sh
cd ./module/{name}; ../../vendor/bin/classmap_generator.php -w
```

## Travis-CI

Travis Service integration is configured in .travis.yml.
To check dependencies it is VersionEye Service integrated.
Code coverage is integrated by Coveralls.io and configured in .coverall.yml.
For Coveralls.io it must be "satooshi/php-coveralls" installed.

## Doctrine Integration

Create a new config file for doctrine in config/autoload and be sure that will not be commit to VCS.
Inside that file define your connection:

```php
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params'      => array(
                    'host'          => 'localhost',
                    'port'          => '3306',
                    'user'          => 'xxxxxxx',
                    'password'      => 'xxxxxxx',
                    'dbname'        => 'mm-web',
                    'charset'       => 'utf8',
                    'driverOptions' => array(1002 => 'SET NAMES utf8'),
                ),
            ),
        ),
    ),
);
```

## Application Configuration

In config/application.config define which modules will be integrated and the config cache behavior.
