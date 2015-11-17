<?php
if(php_sapi_name()!="cli")
    exit("This apps must be run in CLI mode");

define('APP_NAME', 'SHELL');
define('APP_PATH','./Apps/');
define('MODE_NAME', 'cli');
// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';