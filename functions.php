<?php 
	// functions.php
	require("/home/kristelg/config.php");
	
	// et saab kasutada $_SESSION muutujaid
	// k�igis failides mis on selle failiga seotud
	session_start(); 
	
	/* �HENDUS */
	$database = "if16_kristelg";
	$mysqli = new mysqli($serverHost, $serverUsername,  $serverPassword, $database);
	
?>