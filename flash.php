<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN">
<html XMLS="HTTP://WWW.W3.ORG/1999/XHTML" XML:LANG="FR" LANG="FR">
	<head>
		<title>CPE - Cadres pour l'Entreprise - flash</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" HREF="css/style.css">
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>
<!-- en-têtes -->
<?php
echo '<div style="visibility:hidden;"></div>';
$lEtage = 0;
$sncfLibelles = array( 'Accueil', 'flash adhérents' );
$sncfLiens = array( 'index.php' );
require "includes/enTetes.php";
?>
<!-- Contenu -->
		<div id="global">
			<h1>Flash adh&eacute;rents</h1>
			<table style="margin-left:40" border="1">
				<tr style="margin:0.3cm;" align="center">
					<td width="35%">
						Réunions générales
					</td>
					<td width="45%">
						Le mardi apr&egrave;s-midi 14h-16h
					</td>
				</tr>
				<tr style="margin:0.3cm;text-align:center;">
					<td>
						Commission emploi
					</td>
					<td>
						les lundis et mardis
					</td>
				</tr>
			</table>
			<div id="btnRetour">
				<a href="index.php"><img src="images/btnRetour.gif"></a>
			</div>
			<!--<p id="piedDePage"></p>-->
		</div>
	</body>
</html>
