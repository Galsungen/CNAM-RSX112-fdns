<?php

/*
 * 	@author	Galsungen - http://blog.galsungen.net
 * 	Année 2010
 *	RSX112 - Sécurité et réseaux - Projet FDNS
 */

// simple fonction pour afficher des variables
function debug($var)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

//fonction pour double encodage md5 des mdp
function codagemd5($mdp1)
{
	$mdp2 = md5(md5($mdp1));
	return $mdp2;
}

//fonction pour vérifier la validité d'un ip
function verifIP($ip)
{
	if (ereg("^(((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]{1}[0-9]|[1-9])\.){1}((25[0-5]|2[0-4][0-9]|[1]{1}[0-9]{2}|[1-9]{1}[0-9]|[0-9])\.){2}((25[0-5]|2[0-4][0-9]|[1]{1}[0-9]{2}|[1-9]{1}[0-9]|[0-9]){1}))$",$ip)){$response = true;} 
	else {$response = false;}   
	return $response;
}


