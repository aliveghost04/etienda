<?php
	
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_HOST", "localhost");
	define("DB_NAME", "dcu");

	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$domain = $domainName = $_SERVER['HTTP_HOST'].'/dcu/';
	define("PROTOCOL", $protocol);
	define("SITE_URL", $protocol . $domain);