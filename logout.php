<?php
	session_start();
	if (isset($_GET['url'])) {
		$url = $_GET['url'];
	} else $url = "index.php";

	session_destroy();
	header("location: $url");
?>