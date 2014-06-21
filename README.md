# mm-web

[![Build Status](https://travis-ci.org/mamuz/mm-web.svg?branch=master)](https://travis-ci.org/mamuz/mm-web)
[![Dependency Status](https://www.versioneye.com/user/projects/53628be3fe0d07ed79000192/badge.svg)](https://www.versioneye.com/user/projects/53628be3fe0d07ed79000192)
[![Coverage Status](https://coveralls.io/repos/mamuz/mm-web/badge.png?branch=master)](https://coveralls.io/r/mamuz/mm-web?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mamuz/mm-web/badges/quality-score.png?s=b03a2d5d3c33bcf30edec09a0f7ce9fa5a554df9)](https://scrutinizer-ci.com/g/mamuz/mm-web/)

Homepage with ZF2 and Doctrine2

## Domain

Private homepage to provide informations about: Practices, principles and patterns in web-development with PHP

## Functional Features

- Skeleton with twitter-Bootstrap
- Responsive Frontend
- Contact
- ContentManager
- Blog: Postlist is infinitive

## Non-Functional Features

- ErrorLogging
- GoogleTracking Plugin
- Automail for new contact entry
- Config Cache
- Asset Versioning
- Output cache

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
curl -s https://getcomposer.org/installer
php composer.phar self-update; php composer.phar install
```

### Apache Setup

Add virtual host to apache

```sh
<VirtualHost *:80>
    DocumentRoot /var/www/mm-web/public
    ServerName local.mm-web.de
    <Location />
        RewriteEngine On
        RewriteRule ^(.*)\.[\d]{10}\.(css|js)$ $1.$2 [L]
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

Add servername `local.mm-web.de` to host file and restart apache server.

### Data directory

Create directories for temporary data

```sh
sh ./scripts/mkdata.sh
```

### Environment

In `./environment.php` is an APPLICATION_ENV defined to `development`.
For other environments change it to `staging` or `production`.

```php
putenv("APPLICATION_ENV=development");
```

## Composer

Dependencies are handled by Composer package manager.

### Install dependencies with composer

```sh
php composer.phar self-update; php composer.phar install
```

## Testrunner

In test directory an over all module tesrunner exists.
Be sure that each module is defined in `./test/config.php` and in `./test/phpunit.xml`.
Each module must have an autoloader classmap.

### Execute Testrunner

```sh
./vendor/bin/phpunit -c test/
```

### Filemaps

Each module should have an autoloader classmap and a template map.

```sh
sh ./scripts/generate_maps.sh
```

## Application Configuration

In `./config/application.config` define which modules will be integrated and the config cache behavior.

## Application Module Configuration

See [README.md in Application module](https://github.com/mamuz/mm-web/tree/master/module/Application) for more informations.

## Scripts

See [README.md in scripts directory](https://github.com/mamuz/mm-web/tree/master/scripts) for more informations.
