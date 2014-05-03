# Application

## Installation

Run doctrine orm command line to create database table:

```sh
./vendor/bin/doctrine-module
```

## Configuration

Change routing in module config, which will be resolved to path property of page entity.

## Creating new Pages

Create new entities in page database table and set page content to content property.
Content will be parsed as markdown.

## Workflow

If routing is successful to a page entity found by active flag and path property,
page content will be responsed in a new view model. Otherwise it will set 404 status code
to http response
