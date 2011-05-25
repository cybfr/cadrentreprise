<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN" "http://www.w3.org/YT/xhtml1/DTD/xhtml1-strict.dtd">
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
			<p>Cadres pour l'Entreprise
			<span style="float:right;">
<?php
echo '<div style="visibility:hidden;"></div>';

	require 'includes/librairie.php';

	$lesTokens = explode( "\\", recupCookie( ) );
	echo $lesTokens[0];
?>
			</span></p>
		</div>
		<div id="cdeFer">
			<a href="identification1.php">Accès Espaces Privés</a>
			&nbsp;>&nbsp;Choix
		</div>

		<p>&nbsp;</p>
<!-- en-têtes -->
		<h1>Choix d'un espace privé</h1>
<?php
		echo '<p style="padding-top:1em;padding-left:1em;">'
			. '<a href="identification3.php?espace=ancien">Espace anciens</a></p>';
		echo '<p style="padding-top:1em;padding-left:1em;">'
			. '<a href="identification3.php?espace=actif">Espace actifs</a></p>';
?>

		<a href="index.php" style="margin-top:200px;">
			<img src="images/btnAnnuler.gif" border="0"  style="margin-top:2em;">
		</a>
	</body>
</html>