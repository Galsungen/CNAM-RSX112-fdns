<?php

/*
 * 	@author	Galsungen - http://blog.galsungen.net
 * 	Année 2010
 *	RSX112 - Sécurité et réseaux - Projet FDNS
 */

session_start();

require_once('abdd.php');
require_once('fonctions.php');

//debug($_POST);
//debug($_SESSION);

//Variables nécessaires dans la page.
$Erreur = "";
if(isset($_POST['identifiant'])){$identifiant = $_POST['identifiant'];} else{$identifiant = "";}
if(isset($_POST['motdp'])){$motdp = $_POST['motdp'];} else{$motdp = "";}
if(isset($_POST['Envoyer'])){$Envoyer = true;} else{$Envoyer = false;}

if(($Envoyer) && ($identifiant != "") && ($motdp != ""))
{
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
    or die("Impossible de se connecter : " . mysql_error());

	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}

	$sql = "SELECT * FROM `gd_identification` WHERE `login` = '".mysql_real_escape_string($identifiant)."';";

	$result = mysql_query($sql);
	if (!$result) {die('Requete invalide : ' . mysql_error());}

	$tabusr = mysql_fetch_row($result);

	mysql_close($link);

	if(codagemd5($motdp) == $tabusr[3])
	{
		$nomusr = $tabusr[1];
		$_SESSION['nomusr'] = $tabusr[1];
		$_SESSION['role'] = $tabusr[2];

		#on récupère l'ip du visiteur aisni que la date, puis on stock cela dans la table correspondante de MySQL
		$ip_visiteur = $_SERVER['REMOTE_ADDR'];
		$date_jour = date('Y-m-d');
		$heure_connexion = date('His');

		$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
	    or die("Impossible de se connecter : " . mysql_error());
	
		$db_selected = mysql_select_db($nombdd, $link);
		if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}

		$sql = "INSERT INTO `gd_connexions` (`login`, `IP`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($nomusr)."', '".mysql_real_escape_string($ip_visiteur)."', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
		$result = mysql_query($sql);
		if (!$result) {die('Requete invalide : ' . mysql_error());}
		mysql_close($link);
		$host  = $_SERVER['HTTP_HOST'];
		if(($_SESSION['role'] == "admin") || ($_SESSION['role'] == "ecrivain")) {
			$url = "http://".$host.'/save.php';
		}
		elseif($_SESSION['role'] == "lecteur") {
			$url = "http://".$host.'/read.php';
		}
		header("Location: $url");
	}
	else
	{
		$Erreur = "Mot de passe non valide. Identification refus&eacute;.";
	}
}
elseif(($Envoyer) && (($identifiant == "") || ($motdp == ""))){
	$Erreur = "Au moins un des champs d'identification est vide.";
}
?>

<!-- Séparation Affichage et traitement -->

<html>
	<head>
		<title>gd_fdns</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8">
		<link href="feuille.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<h1>Identifiez vous sur gd_fdns :</h1>
		<!-- On affiche le formulaire avec champs pré-remplis si en mémoire -->
	<?php
		echo "<form method='post' action='".$_SERVER['PHP_SELF']."' ENCTYPE='multipart/form-data'>";
		echo "<p>Identifiant : <input type='text' value='$identifiant' name='identifiant'></p>";
		echo "<p>Mot de passe : <input type='text' value='$motdp' name='motdp'></p>";
		echo "<p><input type='submit' value='Envoyer' name='Envoyer'></p>";
		echo "</form>";
		echo "<p class='error'>$Erreur</p>";
	?>
	</body>
</html>
		