#!/bin/sh

mkdir -p build/logs
mkdir -p build/coverage

./vendor/bin/pdepend --summary-xml=./build/logs/summary.xml \
    --jdepend-chart=./build/logs/pdepend.svg --overview-pyramid=./build/logs/pyramid.svg ./module

./vendor/bin/phpunit -c ./test --coverage-html ./build/coverage --coverage-clover ./build/logs/clover.xml

./vendor/bin/phpmd ./module html codesize,controversial,design,unusedcode --exclude test > ./build/logs/phpmd.html

./vendor/bin/phpcs --ignore=test --report=full --report-file=./build/logs/phpcs.log ./module

./vendor/bin/phpcpd --exclude="test" ./module > ./build/logs/phpcpd.log

./vendor/bin/phploc --exclude="test" ./module/ > ./build/logs/report.log

./vendor/bin/phpcb -o ./build/codebrowser -i test -s ./module
