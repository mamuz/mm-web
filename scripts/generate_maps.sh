#!/bin/sh

for D in `find ./module -maxdepth 1 -type d`
do
    Folder=$(basename ${D})
    if [ "$Folder" != "module" ]
    then
        ./vendor/bin/classmap_generator.php -w -s -l ./module/"${Folder}"
        ./vendor/bin/templatemap_generator.php -w -l ./module/"${Folder}" -v ./module/"${Folder}"/view
        ./vendor/bin/pluginmap_generator.php -w -l ./module/"${Folder}"
    fi
done
