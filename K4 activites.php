<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>CPE - Cadres pour l'Entreprise - activités</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>
<!-- en-têtes -->
<?php
echo '<div style="visibility:hidden;"></div>';
$lEtage = 2;
$sncfLibelles = array( 'Cadre', 'activités' );
$sncfLiens = array( 'K4 cadres.php' );
require "includes/enTetes.php";
?>
		<div id="global">
			<h1>Pour &nbsp;un nouvel élan, rejoignez Cadres Pour l'Entreprise</h1>
			<p>Vous avez &agrave; votre disposition :</p>
			<ul>
				<li>des ateliers de réflexion</li>
				<li>une graphologue</li>
				<li>des cercles de langues</li>
				<li>un atelier de relooking</li>
			</ul>
			<table>
				<tr>
					<td style="width: 50%">
						<h2>Ateliers de réflexion</h2>
						<ul style="margin:0 2em 0 2em;">
							<li>pour définir et construire votre projet <br />professionnel</li>
							<li>pour muscler et remuscler votre motivation</li>
							<li>pour négocier le virage de la reconversion</li>
						</ul>
						<h2>Graphologue</h2>
						A la suite d' une étude graphologique, approfondira avec vous l'adéquation entre votre profil et votre CV.
						<h2>Cercles de langue</h2>
						Pour maintenir et améliorer votre niveau en anglais, espagnol...
						<h2>Atelier de relooking</h2>
						Pour soigner votre apparence et vous sentir mieux dans les relations avec les autres
					</td>
					<td>
						<img src="images/Reflechir.jpg" width="200" alt="Refléchr" /><br />
						<img src="images/minicv.jpg" width="200" alt="MiniCV" />
					</td>
				</tr>
			</table>
			<div id="btnRetour">
				<a href="K4%20cadres.php">
					<img src="images/btnRetour.gif" alt="Retour" /> 
				</a>
			</div>
			<!--<p id="piedDePage"></p>-->
		</div>
	</body>
</html>
