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

//si des variables sont présentes dans POST, on les met en place sinon on initialise à vide
if(isset($_POST['ip'])){$ip = $_POST['ip'];} else{$ip = "";}
if(isset($_POST['nom'])){$nom = $_POST['nom'];} else{$nom = "";}
if(isset($_POST['Envoyer'])){$Envoyer = true;} else{$Envoyer = false;}
$Erreur = "";
$Resultat = "";

//Si la variable de session en contient pas d'info, on renvoit la personne vers la page de login.
if(($_SESSION['nomusr'] == "") && (($_SESSION['role'] != 'admin') || ($_SESSION['role'] != 'ecrivain')))
{
	//on log l'accès non autorisé dans le journal
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
    or die("Impossible de se connecter : " . mysql_error());

	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
	
	$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('', 'acces sans session à la page d'écriture, '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";

	$result = mysql_query($sql);
	if (!$result) {die('Requete invalide : ' . mysql_error());}
	
	//on le redirige vers la page d'accueil
	$host  = $_SERVER['HTTP_HOST'];
	$url = "http://".$host.'/index.php';	
	header("Location: $url");
}

//Si les variables sont bonnes, on permet de modifier ou d'ajouter un enregistrement
if(($Envoyer) && ($ip != "") && ($nom != ""))
{	
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
    or die("Impossible de se connecter : " . mysql_error());

	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}

	//on vérifie que l'enregsitrement n'existe pas déjà
	$sql = "SELECT * FROM `gd_dns` WHERE `nom` = '".mysql_real_escape_string($nom)."';";

	$result = mysql_query($sql);
	if (!$result) {die('Requete invalide : ' . mysql_error());}
	mysql_close($link);
	
	$tabenr = mysql_fetch_assoc($result);
//debug($tabenr);	
//debug(count($tabenr));
if(count($tabenr) > 1)
	{
		//ce nom est déjà associé à cette ip ou à une autre
		if($nom == $tabenr['nom'])
		{
			//On log le souci dans le journal
			$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
		    or die("Impossible de se connecter : " . mysql_error());
		
			$db_selected = mysql_select_db($nombdd, $link);
			if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
			
			$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($_SESSION['nomusr'])."', '".mysql_real_escape_string($nom)." est déjà associé à ".mysql_real_escape_string($tabenr['ip'])."', '".mysql_real_escape_string($ip_visiteur)."', '".mysql_real_escape_string($nom)."', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
		
			$result = mysql_query($sql);
			if (!$result) {die('Requete invalide : ' . mysql_error());}

			mysql_close($link);
			
			//On explique le souci
			$Erreur = "$nom est déjà associé à $tabenr[ip]. Vous devez supprimer le premier enregistrement avant d'associer ce nom à une autre IP.";
		}
	}
	else
	{
		//On vérifie l'IP, si elle n'est pas bonne on renvoit on formulaire
		if(!verifIP($ip))
		{
				//on log la mauvaise ip dans le journal
				$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
			    or die("Impossible de se connecter : " . mysql_error());
			
				$db_selected = mysql_select_db($nombdd, $link);
				if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
				
				$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($_SESSION['nomusr'])."', 'ip invalide', '".mysql_real_escape_string($ip_visiteur)."', '".mysql_real_escape_string($nom)."', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
			
				$result = mysql_query($sql);
				if (!$result) {die('Requete invalide : ' . mysql_error());}

				mysql_close($link);
				$Erreur = "Cette IP est invalide.";				
		}
		
		if($Erreur == ""){
			//il n'y a pas d'enregistrement pour ce nom, on l'insère
			$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
		    or die("Impossible de se connecter : " . mysql_error());
		
			$db_selected = mysql_select_db($nombdd, $link);
			if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
	
			$sql = "INSERT INTO `gd_dns` (`nom`, `ip`) VALUES ('".mysql_real_escape_string($nom)."', '".mysql_real_escape_string($ip)."');";
			$result = mysql_query($sql);
			if (!$result) {die('Requete invalide : ' . mysql_error());}
			
			//enregistrement action dans le journal
			$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($_SESSION['nomusr'])."', 'Ajout enregistrement : ".mysql_real_escape_string($ip)." - ".mysql_real_escape_string($nom)."' , '".mysql_real_escape_string($ip_visiteur)."', '".mysql_real_escape_string($nom)."', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
			$result = mysql_query($sql);	
			if (!$result) {die('Requete invalide : ' . mysql_error());}
			
			//affichage message insertion ok & renvois formulaire vide
			mysql_close($link);
			$Resultat = "Insertion de $nom - $ip réalisée avec succès.";
		}
	}
}
elseif(($Envoyer) && ($ip != "") && ($nom == ""))
{
	$Erreur = "Le champ nom est vide.";
}
elseif(($Envoyer) && ($ip == "") && ($nom != ""))
{
	$Erreur = "Le champ IP est vide.";
}
elseif(($Envoyer) && ($ip == "") && ($nom == ""))
{
	$Erreur = "Les deux champs sont vides. Merci de renseigner les deux pour ajouter un enregistrement.";
}

?>

<!-- On sépare les traitements de l'affichage -->
<html>
	<head>
		<title>Ajout d'un enregistrement</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8">
		<link href="feuille.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<h1>Ajout d'un enregistrement :</h1>
		<!-- On affiche le formulaire avec champs pré-remplis si en mémoire -->
			<?php
				echo "<form method='post' action='".$_SERVER['PHP_SELF']."' ENCTYPE='multipart/form-data'>";
				echo "<p>IP : <input type='text' value='$ip' name='ip'></p>";
				echo "<p>Nom <input type='text' value='$nom' name='nom'></p>";
				echo "<p><input type='submit' value='Envoyer' name='Envoyer'></p>";
				echo "<p class='error'>$Erreur</p>";
				echo "<p class='good'>$Resultat</p>";
			?>
			</form>
			<?php require_once('menu.php'); ?>
	</body>
</html>