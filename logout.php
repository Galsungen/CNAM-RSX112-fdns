<?php
/*
 * 	@author	Galsungen - http://blog.galsungen.net
 * 	Année 2010
 *	RSX112 - Sécurité et réseaux - Projet FDNS
 */

	session_start();
	$_SESSION = array();
	session_destroy ();
	$host  = $_SERVER['HTTP_HOST'];
	$url = "http://".$host.'/index.php';
	header("Location: $url");
?>