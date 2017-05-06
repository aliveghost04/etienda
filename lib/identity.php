<?php
	$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$url = urlencode($url);
	if(isset($_SESSION['loged'])) {
		if ($_SESSION['loged'] != true) {
			if (isset($_GET['url'])) header("location: login.php?url=" . $url); 
			else header("location: login.php?url=$url");
		} 
	} else {
		if (isset($_GET['url'])) header("location: login.php?url=" . $url); 
		else header("location: login.php?url=$url");
	}
?>