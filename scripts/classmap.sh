#!/bin/sh

for D in `find ./module -maxdepth 1 -type d`
do
    Folder=$(basename ${D})
    if [ "$Folder" != "module" ]
        then ./vendor/bin/classmap_generator.php -w -s -l ./module/"${Folder}"
    fi
done
