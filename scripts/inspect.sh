#!/bin/sh

rm -rf ./build

mkdir -p ./build/logs
mkdir -p ./build/coverage

./vendor/bin/pdepend --jdepend-chart=./build/logs/pdepend.svg --overview-pyramid=./build/logs/pyramid.svg ./module
./vendor/bin/phpunit -c ./test --coverage-html ./build/coverage
./vendor/bin/phpmd ./module html codesize,controversial,design,unusedcode --exclude test > ./build/logs/phpmd.html
./vendor/bin/phpcs --standard=PSR2 --ignore=test,autoload_classmap.php,plugin_classmap.php,template_map.php,module.config.php --report-file=./build/logs/phpcs.log ./module
./vendor/bin/security-checker security:check ./composer.lock > ./build/logs/security.log
