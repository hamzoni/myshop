<?php
define("BASE_URL", str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']));
define("ROOT_DIR",     "myshop");
define("OP_DIR",	"app");
// password for decrypt_file 
define("SPEC_PWD", "fptdining"); 
// path to page_stats
define("PAGE_STATS", getcwd()."\data\page_stats.txt");
define("PAGE_INFO", getcwd()."\data\contact.txt");
/*
	page_stats labels
	"DETAIL" => [
		"VIEWS" => [],
		"TRANSACTIONS" => [],
		"ACCOUNTS" => [],
		"INCOMES" => []
	],
	"SUMMARY" => [
		"S_VIEWS" => 0,
		"S_TRANSACTIONS" => 0,
		"S_ACCOUNTS" => 0,
		"S_INCOMES" => 0
	]
*/
define("PG_D", "DETAIL");
define("PG_S", "SUMMARY");
// today date
define("TODAY_DATE", strtotime(date("Y/m/d")));
// random favicon
define("V_FAVICON",round(microtime(true)));