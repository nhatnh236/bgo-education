<?php
	ob_start();
	//session_start();
	require_once("../model/model.php");
	session_start();
	// Unset all session values 
	$_SESSION = array();
	 
	// Destroy session 
	session_destroy();
	header("location:http://localhost/www/TDUONG/mobile/");
	exit();
	ob_end_flush();
?>