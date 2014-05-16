#!/bin/sh

mkdir -p build/logs
mkdir -p build/coverage
mkdir -p build/codebrowser
mkdir -p build/api

./vendor/bin/pdepend --summary-xml=./build/logs/summary.xml \
    --jdepend-chart=./build/logs/pdepend.svg --overview-pyramid=./build/logs/pyramid.svg ./module

./vendor/bin/phpunit -c ./test --coverage-html ./build/coverage --coverage-clover ./build/logs/clover.xml

./vendor/bin/phpmd ./module html codesize,controversial,design,unusedcode --exclude test > ./build/logs/phpmd.html

./vendor/bin/phpcs --standard=./vendor/squizlabs/php_codesniffer/CodeSniffer/Standards/PSR2 --ignore=test,autoload_classmap.php,module.config.php --report-file=./build/logs/phpcs.log ./module

./vendor/bin/phpcpd --names-exclude="Module.php" --exclude="test" ./module > ./build/logs/phpcpd.log

./vendor/bin/phploc --exclude="test" ./module > ./build/logs/report.log

./vendor/bin/phpcb -o ./build/codebrowser -i test -s ./module

phpdoc -i *test*,*Test -d ./module -t ./build/api
