#!/bin/sh

rm -rf ./build

mkdir -p ./build/logs
mkdir -p ./build/coverage

pdepend --jdepend-chart=./build/logs/pdepend.svg --overview-pyramid=./build/logs/pyramid.svg ./module
phpunit -c ./tests --coverage-html ./build/coverage
phpcpd ./module > ./build/logs/phpcpd.txt
phpmd ./module html codesize,controversial,design,unusedcode --exclude tests > ./build/logs/phpmd.html
phpcs --standard=PSR2 --ignore=tests,autoload_classmap.php,plugin_classmap.php,template_map.php,module.config.php --report-file=./build/logs/phpcs.log ./module
./vendor/bin/security-checker security:check ./composer.lock > ./build/logs/security.log
