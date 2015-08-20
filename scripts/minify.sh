#!/bin/sh

java -jar ../yuicompressor-2.4.8.jar public/js/jquery.initializer.plugin.js -o public/js/jquery.initializer.plugin-min.js
java -jar ../yuicompressor-2.4.8.jar public/css/base.css -o public/css/base-min.css
