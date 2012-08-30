<?php
/*
 * 	@author	Galsungen - http://blog.galsungen.net
 * 	Année 2010
 *	RSX112 - Sécurité et réseaux - Projet FDNS
 */

//formulaire pour lire les enregistrements en base et afficher leur résultat

session_start();

require_once('abdd.php');
require_once('fonctions.php');

//debug($_POST);
//debug($_SESSION);

//On récupère les info sur l'utilisateur qu'il ait une session ou non pour remplir le journal
$ip_visiteur = $_SERVER['REMOTE_ADDR'];
$date_jour = date('Y-m-d');
$heure_connexion = date('His');
$Erreur ="";
$tabenr = array();

//si des variables sont présentes dans POST, on les met en place sinon on initialise à vide
if(isset($_POST['ip'])){$ip = $_POST['ip'];} else{$ip = "";}
if(isset($_POST['nom'])){$nom = $_POST['nom'];} else{$nom = "";}
if(isset($_POST['Chercher'])){$Chercher = true;} else{$Chercher = false;}

//Si la variable de session en contient pas d'info, on renvoit la personne vers la page de login.
if(($_SESSION['nomusr'] == "") && ($_SESSION['role'] == ""))
{
	//on log l'accès non autorisé dans le journal
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
    or die("Impossible de se connecter : " . mysql_error());

	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
	
	$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('', 'acces sans session à la page de lecture', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";

	$result = mysql_query($sql);
	if (!$result) {die('Requete invalide : ' . mysql_error());}
	
	//on le redirige vers la page d'accueil
	$host  = $_SERVER['HTTP_HOST'];
	$url = "http://".$host.'/index.php';	
	header("Location: $url");
}

//Si les variables sont bonnes, on permet de chercher un enregistrement à condition qu'aucun des deux champs ne soit vide
if(($Chercher) && ($ip != ""))
{	
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
    or die("Impossible de se connecter : " . mysql_error());

	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
	
	if(verifIP($ip)){	
		//on recherche les noms correspondant à cette ip
		$sql = "SELECT * FROM `gd_dns` WHERE `ip` = '".mysql_real_escape_string($ip)."';";
	
		$result = mysql_query($sql);
		if (!$result) {die('Requete invalide : ' . mysql_error());}

		while($row=mysql_fetch_assoc($result)) {
	       $tabenr[] = $row;
	   	}
	
		if(count($tabenr) > 0)
		{
		   	//on enregistre la recherche dans le journal
			$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($_SESSION['nomusr'])."', 'consultation enregistrements pour l\'ip : ".mysql_real_escape_string($ip)."', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
		
			$result = mysql_query($sql);
			if (!$result) {die('Requete invalide : ' . mysql_error());}
		}
		else{
			//Il n'y a pas de résultats, on affiche une phrase explicative
			$Erreur = "Pas d'enregistrements pour $ip.";
			//on enregistre la recherche infructueuse dans le journal
			$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($_SESSION['nomusr'])."', 'consultation enregistrements pour l\'ip : ".mysql_real_escape_string($ip).". Pas de résultats.', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
		
			$result = mysql_query($sql);
			if (!$result) {die('Requete invalide : ' . mysql_error());}
			
		}
		mysql_close($link);
	}
	else{
		$Erreur = "Merci de saisir une IP valide.";
	   	//on enregistre la recherche dans le journal
		$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($_SESSION['nomusr'])."', 'Consultation d\'une mauvaise ip : ".mysql_real_escape_string($ip)."', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
	
		$result = mysql_query($sql);
		if (!$result) {die('Requete invalide : ' . mysql_error());}
	}
}
elseif(($Chercher) && ($nom != "")){
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
    or die("Impossible de se connecter : " . mysql_error());

	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}

	//on recherche les noms correspondant à cette ip
	$sql = "SELECT * FROM `gd_dns` WHERE `nom` = '".mysql_real_escape_string($nom)."';";

	$result = mysql_query($sql);
	if (!$result) {die('Requete invalide : ' . mysql_error());}

	while($row=mysql_fetch_assoc($result)) {
       $tabenr[] = $row;
   	}

   	if(count($tabenr) > 0)
	{
	   	//on enregistre la recherche dans le journal
		$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($_SESSION['nomusr'])."', 'consultation enregistrement pour le nom : ".mysql_real_escape_string($nom)."', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
	
		$result = mysql_query($sql);
		if (!$result) {die('Requete invalide : ' . mysql_error());}
	}
	else{
		//Il n'y a pas de résultats, on affiche une phrase explicative
		$Erreur = "Pas d'enregistrements pour $nom.";
		//on enregistre la recherche infructueuse dans le journal
		$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($_SESSION['nomusr'])."', 'consultation enregistrements pour le nom : ".mysql_real_escape_string($nom).". Pas de résultat.', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
	
		$result = mysql_query($sql);
		if (!$result) {die('Requete invalide : ' . mysql_error());}
		
	}
	
	mysql_close($link);
}
elseif(($Chercher) && ($nom == "") && ($ip == ""))
{
	$Erreur = "Veuillez saisir un nom ou une ip pour effectuer une recherche.";
}
?>

<!-- On sépare les traitements de l'affichage -->
<html>
	<head>
		<title>Rechercher un enregistrement</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8">
		<link href="feuille.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<h1>Rechercher un enregistrement :</h1>
		<!-- On affiche le formulaire avec champs pré-remplis si en mémoire -->
			<?php
				echo "<form method='post' action='".$_SERVER['PHP_SELF']."' ENCTYPE='multipart/form-data'>";
				echo "<p>IP : <input type='text' value='$ip' name='ip'></p>";
				echo "<p>Nom <input type='text' value='$nom' name='nom'></p>";
				echo "<p><input type='submit' value='Chercher' name='Chercher'></p>";
				echo "<p class='error'>$Erreur</p>";
			?>
			</form>
			
		<!-- On affiche les résultats si il y a eu une demande -->
		<?php 
			if(($Chercher) && $tabenr){
				echo "<h2 align='center'>Résultats</h2><table border='1' align='center'><tr><td>Nom</td><td>IP</td></tr>";
				foreach($tabenr as $key => $value){
					echo"<tr><td>".$value['nom']."</td><td>".$value['ip']."</td></tr>";
				}
				echo"</table>";
			}

			require_once('menu.php');
		?>
	</body>
</html>

