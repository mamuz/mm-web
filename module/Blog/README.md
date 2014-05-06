# Blog

## Installation

Run doctrine orm command line to create database table:

Dump the sql..
```sh
./vendor/bin/doctrine-module  orm:schema-tool:update --dump-sql
```
Force update
```sh
./vendor/bin/doctrine-module  orm:schema-tool:update --force
```
In usage of environment variable..
```sh
export APPLICATION_ENV=development; ./vendor/bin/doctrine-module  orm:schema-tool:update
```

## Requirements

- Hashids/HashIds to encrypt repository identities
- jquery.jscroll to provide an infinife scrolling which replaced pagination with autocompletion

## AssetManager

To provide module public assets it must be configured in module config

```php
return array(
    'asset_manager'   => array(
        'resolver_configs' => array(
            'paths' => array(
                'Blog' => __DIR__ . '/../public',
            ),
        ),
    ),
);
```
