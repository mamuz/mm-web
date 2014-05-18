#!/bin/sh

rm -rf ./build

mkdir -p ./build/logs
mkdir -p ./build/coverage
mkdir -p ./build/codebrowser
mkdir -p ./build/api

./vendor/bin/pdepend --summary-xml=./build/logs/summary.xml \
    --jdepend-chart=./build/logs/pdepend.svg --overview-pyramid=./build/logs/pyramid.svg ./module

./vendor/bin/phpunit -c ./test --coverage-html ./build/coverage --coverage-clover ./build/logs/clover.xml

./vendor/bin/phpmd ./module html codesize,controversial,design,unusedcode --exclude test > ./build/logs/phpmd.html
./vendor/bin/phpmd ./module xml codesize,controversial,design,unusedcode --exclude test > ./build/logs/phpmd.xml

./vendor/bin/phpcs --standard=PSR2 --ignore=test,autoload_classmap.php,module.config.php --report-file=./build/logs/phpcs.log ./module
./vendor/bin/phpcs --standard=PSR2 --ignore=test,autoload_classmap.php,module.config.php --report=xml --report-file=./build/logs/phpcs.xml ./module

for D in `find ./module -maxdepth 1 -type d`
do
    ./vendor/bin/phpcpd --log-pmd=./build/logs/phpcpd_`basename ${D}`.xml --min-lines=3 --min-tokens=20 --exclude=test ${D} > ./build/logs/phpcpd_`basename ${D}`.log
done

./vendor/bin/phploc --exclude="test" ./module > ./build/logs/phploc.log

./vendor/bin/phpdcd --exclude="test" ./module > ./build/logs/phpdcd.log

./vendor/bin/security-checker security:check ./composer.lock > ./build/logs/security.log

./vendor/bin/phpcb --log ./build/logs -o ./build/codebrowser -i test -s ./module

phpdoc -i *test*,*Test,autoload_classmap.php,module.config.php -d ./module -t ./build/api
