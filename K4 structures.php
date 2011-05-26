<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>CPE - Cadres pour l'Entreprise - structure</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>
<!-- en-têtes -->
<?php
echo '<div style="visibility:hidden;"></div>';
$lEtage = 2;
$sncfLibelles = array( 'Cadre', 'structures d\'accueil' );
$sncfLiens = array( 'K4 cadres.php' );
require "includes/enTetes.php";
?>
<!-- Contenu -->
		<div id="global">
			<h1>Pour un nouvel élan, rejoignez Cadres Pour l'Entreprise</h1>
			<img src="images/binome1mir.jpg" width="99" height="118" alt="Binôme" />
			<table>
				<tr>
					<td style="width: 60%">
						<h2>Nous vous aidons</h2>
						<ul>
							<li style="margin-top:5; margin-left:20;">
								à confronter vos expériences et échanger des informations
							</li>
							<li style="margin-left:20;">
								à définir ensemble les actions à mener en binôme composé d'un membre permanent et d'un adhérent en recherche d'emploi
							</li>
							<li style="margin-left:20;">
								à enrichir votre réseau grâce à la diversité des parcours professionnels des  adhérents de CPE
							</li>
						</ul>
					</td>
					<td>
						<img src="images/intervention.jpg" width="256" height="144" alt="Intervention" />
					</td>
				</tr>
				<tr>
					<td>
						<h2>Nous vous offrons</h2>
						<ul>
							<li style="margin-top:5; margin-left:20;">
								un suivi personnalisé par un parrain CPE
							</li>
							<li style="margin-left:20;">
								des réunions hebdomadaires
							</li>
							<li style="margin-left:20;">
								des interventions de cabinets de recrutement
							</li>
							<li style="margin-left:20;">
								des conférences sur les marchés du travail avec des acteurs économiques
							</li>
							<li style="margin-left:20;">
								des réunions &quot;réseau&quot; pour partager des idées et des contacts
							</li>
						</ul>
					</td>
					<td>
						<img style="float:right;" src="images/reseaux.jpg" width="149" height="216" alt="Réseaux" />
					</td>
				</tr>
			</table>
			<h1>VOUS N'ÊTES PLUS SEUL(E) !</h1>
			<div id="btnRetour">
				<a href="K4%20cadres.php">
					<img src="images/btnRetour.gif" alt="Retour" />
				</a>
			</div>
			<!--<p id="piedDePage"></p>-->
		</div>
	</body>
</html>
