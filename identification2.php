<?php
error_reporting(E_ALL);

//	test dispo des cookies
if( !isset( $_COOKIE["testClientAccepteCookie"] ) )
	{
?>
<html xmlns="HTTP://WWW.W3.ORG/1999/XHTML" xml:lang="FR" lang="FR">
	<head>
		<title>CPE - Cadres pour l'entreprise - identification</title>
		<meta name="robots" content="noindex,nofollow">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" HREF="css/style.css">
	</head>
	<body id="global2" style="padding-top:2em;">
	<h1>Votre navigateur doit accepter les cookies.</h1>
	<p>Veuillez modifier les préférences de votre navigateur en suivant les informations disponibles 
		<a href="http://cadrentreprise.asso.fr/cookies.php">ici</a>.</p>
	<p>En cas de difficulté, contactez le Webmestre en lui communiquant le message suivant :</p>
<?php
	echo	'<h2>' . $_SERVER[ 'HTTP_USER_AGENT' ];
	exit;
	}
// Connexion et sélection de la base
require "includes/mySql.php";
require "includes/librairie.php";

// Exécuter des requêtes SQL
$leLogin = $_POST['login'];
$leMdp = $_POST['mdp'];

$query = "SELECT * FROM tblMdp where login='$leLogin' and mdp='$leMdp'";
$result = mysql_query($query) or die("erreur 3");
$nbrLgns = mysql_num_rows($result);
//  echo '<br>ident2.php...'.$query.'<br>...'.$nbrLgns.'...'.$_POST[ 'dest' ].'...'.$_POST['dest'];
if( $nbrLgns == 1 )
	{	// login/mdp OK
	$ligne = mysql_fetch_assoc($result);
	switch( $_POST[ 'dest' ] )
		{
		case 'prives' :
			$ancien = $ligne['ancien'];
			$actif = $ligne['actif'];
//echo '<br>identification2...$actif '.$actif;
			if( $ancien && $actif )
				$dest = "les2";
			else if( $ancien )
				$dest = "ancien";
			else if( $actif )
				{
				if( $actif == -1 )
					$dest = 'actif-1';
				else
					$dest = 'actif';
				}
			else
				$dest = "";		//	accès refusé
//echo '<br>identification2...$dest '.$dest;
			if( $dest <> "" )
				{
				$res = setcookie("CPEid");	//	il ne faudrait pas créer le cookie si "les2" <<<<<<<<<<<<<<<<< 
				$valeur = $leLogin . "\\" . $dest;
//echo '<br>identification2...$valeur '.$valeur;
				initCookie( $valeur );
				switch( $dest )
					{
					case 'ancien' :
						header( 'Location: espaceAnciens/ANCAccueil.php' );
						exit( 0 );
						break;
					case 'actif' :
						header( 'Location: espaceActifs/ACTAccueil.php' );
						exit( 0 );
						break;
					case 'actif-1' :
						header( 'Location: espaceActifs/OffresCEF1.php' );
						exit( 0 );
						break;
					case 'les2' :
						header( 'Location: identificationChoix.php' );
						exit( 0 );;
					}
				}
			break;
		case 'url' :
			//echo '<br>case url';
			$res = setcookie("CPEid");	//	il ne faudrait pas créer le cookie si "les2" <<<<<<<<<<<<<<<<< 
			$valeur = $leLogin . "\\actif";
			initCookie( $valeur );
			//	transcodage de l'url (dans $_POST['url'] :
			//		.p. marque le début d'un paramètre (sauf le premier qui doit utiliser '?'
			//		.m. marque le début d'une ancre - ce dernier élément doit être le dernier
			//			et unique)
			$lUrl = str_replace( array( '.p.', '.m.' ), array( '&', '#' ), 
				urldecode( $_POST[ 'url' ] ) );
			//	appel de l'url
			header( "Location: " . $lUrl );
			break;
		default :
			die( "accès refuse" );
		}
	}
?>
<html xmlns="HTTP://WWW.W3.ORG/1999/XHTML" xml:lang="FR" lang="FR">
	<head>
		<title>CPE - Cadres pour l'entreprise - identification</title>
		<meta name="robots" content="noindex,nofollow">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" HREF="css/style.css">
	</head>
	<body id="global2" style="padding-top:2em;">
		<div id="header2">
			<img src="images/logo50.gif" alt="logo CPE" />
			<p>Cadres pour l'Entreprise</p>
		</div>
		<div id="cdeFer">
			<a href="identification1.php">Accès Espaces Privés</a>
			&nbsp;>&nbsp;Erreur
		</div>

		<p>&nbsp;</p>
		<h2>identifiants ou mot de passe invalides</h2>
		<br>
		<a href="identification1.php">
			<img src="images/btnRetour.gif" border="0">
		</a>
	</body></html>
<?php

// Libération des résultats 
mysql_free_result($result);

// Fermeture de la connexion 
mysql_close($link);
?>