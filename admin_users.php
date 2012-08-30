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
if(isset($_POST['login'])){$login = $_POST['login'];} else{$login = "";}
if(isset($_POST['role'])){$role = $_POST['role'];} else{$role = "";}
if(isset($_POST['mdp'])){$mdp = $_POST['mdp'];} else{$mdp = "";}
if(isset($_POST['edition'])){$edition = $_POST['edition'];} else{$edition = "";}
if(isset($_POST['Envoyer'])){$Envoyer = true;} else{$Envoyer = false;}
if(isset($_SESSION['nomusr'])){$nomusr = $_SESSION['nomusr'];} else{$nomusr = "";}
$Erreur = "";
$Resultat = "";
$roles = array('lecteur', 'ecrivain', 'admin');

//Si la variable de session en contient pas d'info, on renvoit la personne vers la page de login.
if(($nomusr == "") || ($_SESSION['role'] != 'admin'))
{
	//on log l'accès non autorisé dans le journal
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
    or die("Impossible de se connecter : " . mysql_error());

	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
	
	$sql = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($nomusr)."', 'acces non admin à la page de gestion des utilisateurs.', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";

	$result = mysql_query($sql);
	if (!$result) {die('Requete invalide : ' . mysql_error());}
	
	//on le redirige vers la page d'accueil
	$host  = $_SERVER['HTTP_HOST'];
	$url = "http://".$host.'/index.php';	
	header("Location: $url");
}

if($_POST['suppr'] != ''){
	$ref_suppr = substr($_POST['suppr'], 6);
	if($ref_suppr != $_SESSION['nomusr'])
	{
		$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
	    or die("Impossible de se connecter : " . mysql_error());
	
		$db_selected = mysql_select_db($nombdd, $link);
		if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
	
		$sql = "DELETE FROM `gd_identification` WHERE `login`='$ref_suppr';";
	
		$result = mysql_query($sql);
		if (!$result){die('Requete invalide : ' . mysql_error());}
		else{
			$Resultat = "Suppression de $ref_suppr effectuée avec succès.";
			//On enregistre la dernière action dans le journal
			$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
			    or die("Impossible de se connecter : " . mysql_error());
			
			$db_selected = mysql_select_db($nombdd, $link);
			if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
						$sql2 = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($nomusr)."', 'Suppression de $ref_suppr.', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
			$result = mysql_query($sql2);
			if (!$result) {die('Requete invalide : ' . mysql_error());}
			mysql_close($link);
		}
	}
	else{
		$Erreur = "Impossible de se supprimer soit même.";
		//On enregistre la dernière action dans le journal
		$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
		    or die("Impossible de se connecter : " . mysql_error());
		
		$db_selected = mysql_select_db($nombdd, $link);
		if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
		$sql2 = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($nomusr)."', '$ref_suppr ne peut pas se supprimer lui-même.', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
		$result = mysql_query($sql2);
		if (!$result) {die('Requete invalide : ' . mysql_error());}
		mysql_close($link);

	}
}
elseif($_POST['edit'] != '')
{
		$id_modif = substr($_POST['edit'], 5);

		$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
	    or die("Impossible de se connecter : " . mysql_error());

		$db_selected = mysql_select_db($nombdd, $link);
		if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}

		$sql = "SELECT * FROM `gd_identification` WHERE `login`='$id_modif';";

		$result = mysql_query($sql);
		if (!$result)
		{
			die('Requete invalide : ' . mysql_error());
		}
		else
		{
			$row = mysql_fetch_assoc($result);
			$login = $row['login'];
			$password = $row['mdp'];
			$fonction = $row['role'];
			$edition = 'yes';
		}
		mysql_close($link);
}
elseif(($Envoyer) && ($login != "") && ($mdp != ""))
{	
	//vérification utilisateurs duppliqués
	$Err = false;
	//nous vérifions que l'utilisateur n'est pas déjà présent dans la base
	//si oui la requete avec IGNORE ne modifiera rien mais on ne redirige pas afin deconserver les champs pour une modification
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
    or die("Impossible de se connecter : " . mysql_error());

	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}

	$sql = "SELECT * FROM `gd_identification` WHERE `login`='$login';";

	$result = mysql_query($sql);
	if (!$result) {die('Requete invalide : ' . mysql_error());}

	$row =mysql_fetch_assoc($result);
	mysql_close($link);

	if(($row['login'] == $login) && ($edition != 'yes'))
	{
		$Err = true;
		$Erreur = "Ce Login d'utilisateur est déjà utilisé, veuillez le changer.";
		//On enregistre la dernière action dans le journal
		$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
		    or die("Impossible de se connecter : " . mysql_error());
		
		$db_selected = mysql_select_db($nombdd, $link);
		if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
		$sql2 = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($nomusr)."', 'Demande d\'ajout de ".mysql_real_escape_string($login)." qui existait déjà.', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
		$result = mysql_query($sql2);
		if (!$result) {die('Requete invalide : ' . mysql_error());}
		mysql_close($link);
	}

	if($edition == 'yes')
	{
		$sql = "UPDATE `gd_identification` SET `mdp`='".mysql_escape_string(codagemd5($mdp))."', `role`='".mysql_escape_string($role)."' WHERE `login`='".mysql_escape_string($login)."';";
	}
	elseif($Err == false)
	{
		$sql = "INSERT INTO `gd_identification` (`login`, `role`, `mdp`) VALUES ('".mysql_escape_string($login)."', '".mysql_escape_string($role)."', '".mysql_escape_string(codagemd5($mdp))."');";
	}

	if($Err == false)
	{
		$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
	    or die("Impossible de se connecter : " . mysql_error());

		$db_selected = mysql_select_db($nombdd, $link);
		if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}

		$result = mysql_query($sql);
		if (!$result)
		{
			die('Requete invalide : ' . mysql_error());
		}
		else
		{
			if($edition == 'yes')
			{
				$Resultat = "Utilisateur $login modifié avec succès.";
				//On enregistre la dernière action dans le journal
				$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
			    or die("Impossible de se connecter : " . mysql_error());

				$db_selected = mysql_select_db($nombdd, $link);
				if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
				$sql2 = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($nomusr)."', 'Modification de ".mysql_real_escape_string($login)." avec succès.', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
				$result = mysql_query($sql2);
				if (!$result) {die('Requete invalide : ' . mysql_error());}
				mysql_close($link);
			}
			else
			{
				$Resultat = "Utilisateur $login ajouté avec succès.";
				//On enregistre la dernière action dans le journal
				$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
				    or die("Impossible de se connecter : " . mysql_error());

				$db_selected = mysql_select_db($nombdd, $link);
				if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
				$sql2 = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($nomusr)."', 'Ajout de ".mysql_real_escape_string($login)." avec succès.', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
				$result = mysql_query($sql2);
				if (!$result) {die('Requete invalide : ' . mysql_error());}
				mysql_close($link);
			}
		}
	}
}
elseif(($Envoyer) && ($login != "") && ($mdp == ""))
{
	$Erreur = "Le champ login est vide.";
	//On enregistre la dernière action dans le journal
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
    	or die("Impossible de se connecter : " . mysql_error());

	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
	$sql2 = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($nomusr)."', 'Essai d\'ajout d\'un utilisateur avec le champ de login vide, '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
	$result = mysql_query($sql2);
	if (!$result) {die('Requete invalide : ' . mysql_error());}
	mysql_close($link);
}
elseif(($Envoyer) && ($login == "") && ($mdp != ""))
{
	$Erreur = "Le champ Mot de passe est vide.";
	//On enregistre la dernière action dans le journal
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
	    or die("Impossible de se connecter : " . mysql_error());
	
	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
	$sql2 = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($nomusr)."', 'Essai d\'ajout de ".mysql_real_escape_string($login)." avec un mot de passe vide.', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
	$result = mysql_query($sql2);
	if (!$result) {die('Requete invalide : ' . mysql_error());}
	mysql_close($link);
}
elseif(($Envoyer) && ($login == "") && ($mdp == ""))
{
	$Erreur = "Les deux champs sont vides. Merci de renseigner les deux pour ajouter un utilisateur.";
	//On enregistre la dernière action dans le journal
	$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
	    or die("Impossible de se connecter : " . mysql_error());
	
	$db_selected = mysql_select_db($nombdd, $link);
	if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
	$sql2 = "INSERT INTO `gd_journal` (`utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES ('".mysql_real_escape_string($nomusr)."', 'Essai d\'ajout d\'utilisateur sans login ni mot de passe.', '".mysql_real_escape_string($ip_visiteur)."', '', '".mysql_real_escape_string($date_jour)."', '".mysql_real_escape_string($heure_connexion)."');";
	$result = mysql_query($sql2);
	if (!$result) {die('Requete invalide : ' . mysql_error());}
	mysql_close($link);
}

?>

<!-- On sépare les traitements de l'affichage -->
<html>
	<head>
		<title>Gestion des utilisateurs</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8">
		<link href="feuille.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<h1>Ajout d'un Utilisateur :</h1>
		<!-- On affiche le formulaire avec champs pré-remplis si en mémoire -->
			<?php
			//si la variable résultat est remplie, on a effectué une tache avec succès. On l'affiche avant le formulaire puis reinitialise les variables
			if($Resultat != ""){
				$login = "";
				$role="";
			}
			//formulaire de saisie d'un nouvel utilisateur
			echo "<form method='POST'>
				<p><input type='hidden' name='edition' value='$edition' /></p>
			    <p>Login : <input type='text' name='login'/ value='$login' /></p>
			    <p>Mot de passe : <input type='text' name='mdp' /></p>
				<p>Rôle : <SELECT name='role' value='$role' >\n";
				foreach($roles as $value)
				{
					echo "<OPTION VALUE='$value' ".($fonction == $value ? 'selected' : '').">$value</OPTION>";
				}
		echo "</SELECT></p>
			<p class='error'>$Erreur</p>
			<p class='good'>$Resultat</p>
			<p><INPUT type='submit' value='Envoyer' name='Envoyer'>
			</form><br/><hr/><br/>";
	
		//Affichage des utilisateurs déjà présents et de leurs rôles
		foreach($roles as $value)
		{
				$tabusers = array();
				echo "<h3>$value</h3>";
				$link = mysql_connect($adrbdd, $usrbdd, $pwdusr)
			    or die("Impossible de se connecter : " . mysql_error());
	
				$db_selected = mysql_select_db($nombdd, $link);
				if (!$db_selected) {die ('Impossible de selectionner la base de donnees : ' . mysql_error());}
	
				$sql = "SELECT * FROM `gd_identification` WHERE `role`='$value' ORDER BY 'login';";
	
				$result = mysql_query($sql);
				if (!$result) {die('Requete invalide : ' . mysql_error());}
	
				while ($row =mysql_fetch_assoc($result))
		        {
		            $tabusers[]=$row;
		        }
	
				mysql_close($link);

				$count = count($tabusers);
				if($count != 0)
				{
					echo "<table border='1'>\n<tr><td>Login</td></tr>";
	
					foreach($tabusers as $key => $value)
					{
	
						echo "<tr>
							<td>".$value['login']."</td>
							<td>
							<form method='POST'>
							<INPUT border=0 src='images/user_edit.png' type='image' Value='edit_".$value['login']."' name='edit'>\n
							<INPUT border=0 src='images/user_delete.png' type='image' Value='suppr_".$value['login']."' name='suppr'>\n
							</form></td></tr>";
					}
					echo "</table>\n";
				}
		}
			?>
		
			</form>
			<?php require_once('menu.php'); ?>
	</body>
</html>