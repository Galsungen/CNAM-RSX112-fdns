<?php
/*
 * 	@author	Galsungen - http://blog.galsungen.net
 * 	Année 2010
 *	RSX112 - Sécurité et réseaux - Projet FDNS
 */

	//gestion du menu de bas de page en fonction des rôles
	$menu = "";
	if(($_SESSION['role'] == "ecrivain") || ($_SESSION['role'] == "admin")){
		$menu = "- <a href='save.php'>Ajout Enregistrement</a> - <a href='suppression.php'>Suppression d'Enregistrement</a> - <a href='journal.php'>Logs des op&eacute;rations</a>";
	}			
	
	if(($_SESSION['role'] == "admin")){
		$menu = $menu." - <a href='admin_users.php'>Administration des utilisateurs</a> - <a href='journal_connexions.php'>Logs connexions</a>";
	}
	echo "</p>";
	echo "<p><a href='read.php'>Lecture Enregistrement</a>".$menu." - <a href='logout.php'>Logout</a></p>";
?>