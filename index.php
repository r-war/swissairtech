<?php
set_time_limit(0);
error_reporting(E_ERROR);
require 'vendor/autoload.php';
define('BASE_PATH', __DIR__ . '/' );
include(BASE_PATH.'init.php');
include_once( Attributes::CORE_CLASS_PATH . 'Application.php');
$oApplication = Application::getInstance();
$oApplication->start();
$oApplication->process();
?>