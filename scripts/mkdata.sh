#!/bin/sh

mkdir -p ./data/cache
mkdir -p ./data/DoctrineORMModule
mkdir -p ./data/logs
mkdir -p ./data/cache/assets

chmod -R 0775 ./data
chmod -R 0777 ./data/cache/assets
