<?php
require 'environment.php';

global $config;
global $db;

$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/estoque2/");
	$config['dbname'] = 'estoque2';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
	$config['charset'] = 'utf8';
} else {
	define("BASE_URL", "http://localhost/estoque2/");
	$config['dbname'] = 'nova_loja';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
	$config['charset'] = 'utf8';
}

$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'].";charset=".$config['charset'], $config['dbuser'], $config['dbpass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);