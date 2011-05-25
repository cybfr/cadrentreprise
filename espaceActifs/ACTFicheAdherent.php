<?php
if( !isset( $_COOKIE['CPEid'] ) )
	{	// cookie pas défini : on va vers l'authentification
		//	avec l'url cible en paramètre (dans cette url cible, l'ancre
		//	est délimitée par '.m.' et les param au delà du prmier par .p.
	$lUri = $_SERVER[ 'REQUEST_URI'];
	$lUrl = 'Location: ../identification1.php?url='
		. urlencode( $lUri );
	header( $lUrl );
	exit;
	}
require_once "includes/librairie.php";
require_once "../includes/librairie.php";
require "../includes/mySql.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN" "http://www.w3.org/YT/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="HTTP://WWW.W3.ORG/1999/XHTML" xml:lang="FR" lang="FR">
	<head>
		<title>CPE - Espace Adhérents Actifs</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" HREF="css/ACTstyle.css">
		<style>
			em {color:red; font-style:normal; text-decoration:bold;}
		</style>
		<style type="text/css">
		td
			{background-color:#efefef;border:5px ridge #a0a0ff;}
		td a
			{text-decoration:none;}
		.titre
			{text-align:center;font-family:arial;font-size:1.3em;font-style:italic;font-weight:bold;padding-bottom:0.3em;}
		.sousTitre
			{text-align:center;text-transform:uppercase;font-size:0.9m;font-style:normal;padding-bottom:0.3em;}
		.pointsForts
			{padding: 0.8em 0 1em 0.8em;text-align:left;font-size:0.9em;list-style-type:circle;list-style-position:outside;}
		.pointsForts ul
			{margin:0px;padding-left:10px;}
		.complements
			{padding-left:20px;padding-top:2px;font-size:0.9em;text-align:left;font-style:italic;}
		.telephone
			{float:left;padding-top:1em;padding-left:20px;}
		.reference
			{float:right;padding-top:1em;padding-right:20px;}
		</style>
	</head>
<!-- en-têtes -->
	<body id="global2" style="padding-top:10px;">
		<div id="header2">
			<img src="../images/logo50.gif" alt="logo CPE" />
<?php
echo 		'<div style="float:right;">';
$login = getLogin();
if( $login === false )
	{
	echo 		'<br>Accès refusé<br>';
	exit;
	}
echo 			$login;
echo		'</div>';
?>
			<p>Cadres pour l'Entreprise</p>
		</div>
		<div id="cdeFer">
			Fiche adhérent
		</div>
<!-- Contenu -->
<?php
echo '<div style="float:right">';
echo 	'<img src="../photosId/id' . $_GET['idAdherent'] . '.png" border="1">';
echo '</div>';
echo '<div style="margin-left:20px;padding-top:20px;">';
echo '<p>' . $_GET['prenomNom'];
if( isset( $_GET[ 'statut' ] ) )
	{
	echo ' (membre ';
	switch( $_GET[ 'statut' ] )
		{
		case 'BENEVOLE' :
			echo 'bénévol';
			break;
		case 'ACTIF' :
			echo 'actif)';
			break;
		case 'INTER' :
			echo 'actif récent)';
			break;
		default :
			echo '???)';
			break;
		}
	}
echo '</p>';
echo '<p>' . $_GET['email'] . '</p>';
if( $_GET['mobile'] != '' )
	echo '<p>' . $_GET['mobile'] . '</p>';
else
	echo '<p>' . $_GET['fixe'] . '</p>';

$query = "SELECT * FROM tblMiniCV"
	. " WHERE idAdherent=" . $_GET[ 'idAdherent' ];
$result = mysql_query($query) or die('<br>...'.$query.'<br>...'.mysl_error());
if( ( $nbr = mysql_num_rows( $result ) ) == 0 )
	echo '<p>pas de projet flash</p>';
else
	{
	Require( '../includes/unProjetFlash.php' );
	echo '<p>' . $nbr . ' projets flash : </p>';
	echo '<div style="margin-left:10px;">';
	echo 		'<table style="margin:10px;margin-right:20px;padding:5px">';
	while( $l = mysql_fetch_assoc( $result ) )
		{
affichageHTMLunProjetFlash( $l, 0, '', false );
		}
	}
echo '</table></div>';
?>			<div style="margin:10px 0 0px 20px;clear:both;">
				<a href="javascript:close('contact')">
					<img src="../images/btnRetour.gif" border="0">
				</a>
			</div>
		</form>
	</body>
</html>