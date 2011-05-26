<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>CPE - Cadres pour l'entreprise - qui sommes-nous</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>
<!-- en-têtes -->
<?php
echo '<div style="visibility:hidden;"></div>';
$lEtage = 0;
$sncfLibelles = array( 'Accueil', 'qui sommes nous' );
$sncfLiens = array( 'index.php' );
require "includes/enTetes.php";
?>
<!-- Contenu -->
		<div id="global">
			<h1>Qui sommes nous ?</h1>
			<p>Une association loi 1901, née en 1979 <br />qui adopte son intitulé définitif&nbsp;
					&quot;<span style="color: red;">Cadres pour l'Entreprise</span>&quot;
				&nbsp;en 1983&nbsp;
			</p>
			<table>
				<tr>
					<td style="width: 65%">
						<h2>Notre objectif</h2>
						<ul>
							<li>Apporter aux cadres en recherche d'emploi l'aide technique et morale nécessaire pour favoriser le retour à l'activité
							</li>
							<li>Proposer aux entreprises un éventail de compétences et d'expériences dont la promotion est assurée par des actions de prospection collective
							</li>
						</ul>
					</td>
					<td style="width: 25%">
						<img src="images/equipe.jpg" width="174" height="129" alt="equipe" />
					</td>
				</tr>
				<tr>
					<td>
						<h2>Nos adhérents</h2>
						<ul>
							<li>Des cadres en recherche d'emploi</li>
							<li>Des cadres en entreprise, des consultants en activité  maintenant des liens  avec l'association</li>
							<li>Des cadres bénévoles assurant l'encadrement permanent des activités et garantissant la pérennité de l'association
							</li>
						</ul>
					</td>
					<td>
						<img src="images/Reunion hebdo-2.jpg" width="174" height="129" alt="Réunion" />
					</td>
				</tr>
				<tr>
					<td>
						<h2>Notre fonctionnement</h2>
						<ul>
							<li>Un conseil d'Administration de douze membres élus pour trois ans parmi ces adhérents</li>
							<li>Un bureau de huit membres désignés par le conseil d'administration</li>
							<li>Des commissions gérant les diverses activités de l'association</li>
						</ul>
					</td>
					<td>
						<img src="images/AG1.jpg" width="174" alt="AG" />
					</td>
				</tr>
				<tr>
					<td>
						<h2>Nos Partenaires</h2>
						<ul>
							<li>Organisateurs de salons professionnels,</li>
							<li>Cabinets de recrutement spécialisés</li>
							<li>...</li>
						</ul>
						<div style="padding-left:40px;" >
							<a href="K1%20partenaires.php">
								En savoir plus ?
							</a>
						</div>
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
			<div id="btnRetour">
				<a href="index.php"><img src="images/btnRetour.gif" alt="Retour" /></a>
			</div>
			<!--<p id="piedDePage"></p>-->
		</div>
	</body>
</html>
