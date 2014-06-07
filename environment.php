<?php

putenv("APPLICATION_ENV=development");

define('REQUEST_MEMORY_USAGE', memory_get_usage());
define('REQUEST_MICROTIME', microtime(true));
ini_set("display_errors", 1);
error_reporting(E_ALL);
