<?php
date_default_timezone_set('Asia/Manila');
$config = require 'config.php';
define('BASE_URL', $config['base_url']); // BASE_URL should be '/hris_mpc'
require "functions.php";
require "Database.php";
require "router.php";
