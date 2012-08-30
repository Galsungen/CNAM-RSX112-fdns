<?php
/*
 * 	@author	Galsungen - http://blog.galsungen.net
 * 	Année 2010
 *	RSX112 - Sécurité et réseaux - Projet FDNS
 */

session_start();

//formulaire pour pouvoir ajouter un enregistrement

require_once('abdd.php');
require_once('fonctions.php');

//debug($_POST);
//debug($_SESSION);

//On récupère les info sur l'utilisateur qu'il ait une session ou non pour remplir le journal
$ip_visiteur = $_SERVER['REMOTE_ADDR'];
$date_jour = date('Y-m-d');
$heure_connexion = date('His');

//Si la variable de session en contient pas d'info, on renvoit la personne vers la page de login.
if(($_SESSION['nomusr'] == "") && (($_SESSION['role'] != 'admin') || ($_SESSION['role'] != 'ecrivain')))
{
	//on log l'accès non autorisé dans le journal
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
    or die("Impossible de se connecter : " . mysql_error());

	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
	
	$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('', 'acces sans session au journal', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";

	$result = mysql_query($sql);
	if (!$result) {die('Requete invalide : ' . mysql_error());}
	
	//on le redirige vers la page d'accueil
	$host  = $_SERVER['HTTP_HOST'];
	$url = "http://".$host.'/index.php';	
	header("Location: $url");
}
else
{
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
    or die("Impossible de se connecter : " . mysql_error());

	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}

	//on enregistre la consultation de la page
	$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($_SESSION['nomusr'])."', 'consultation du journal', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";

	$result = mysql_query($sql);
	if (!$result) {die('Requete invalide : ' . mysql_error());}
	
	//On récupère l'ensemble des enregistrements du journal
	$sql = "SELECT * FROM `gd_journal`;";

	$result = mysql_query($sql);
	if (!$result) {die('Requete invalide : ' . mysql_error());}
	mysql_close($link);
	
	while($row=mysql_fetch_assoc($result)) {
       $tabjournal[] = $row;
   	}
	
//debug($tabjournal);

//On affiche le résultat sous la forme d'un tableau à colonnes
	echo "<html><head><title>Journal des Op&eacute;rations</title></head><body><h1 align='center'>Journal des Op&eacute;rations</h1>";
	echo "<table border='1' align='center'>";
	echo "<tr><td>Date</td><td>Heure</td><td>utilisateur</td><td>IP de l'utilisateur</td><td>Action</td><td>Nom DNS concern&eacute</td></tr>";
	foreach($tabjournal as $key => $value){
		echo "<tr><td>".$tabjournal[$key]['date']."</td><td>".$tabjournal[$key]['HHmmss']."</td><td>".$tabjournal[$key]['utilisateur']."</td><td>".$tabjournal[$key]['ip']."</td><td>".$tabjournal[$key]['action']."</td><td>".$tabjournal[$key]['nom']."</td></tr>";
	}
	echo "</table>";

	require_once('menu.php');
	
	echo "</body></html>";
}
?>

