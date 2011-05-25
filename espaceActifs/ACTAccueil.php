<!-- en-têtes -->
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
$tagSupplementaire = '<link rel="alternate" type="application/rss+xml" title="RSS"';
require_once "includes/librairie.php";
$lePath = getPathRacine();
$tagSupplementaire .= 'href="http://' . $lePath . 'espaceActifs/rss.xml">';
$titrePage = "accueil";
$nomPage = "EspActifAccueil/";
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
<div id="global">
	<h1>Accueil Adhérents Actifs</h1>
	<p>Bienvenue dans l'espace dédié aux adhérents actifs de CPE.</p>
<!-- Encart -->
	<div id="encartJaune">
		<h3 style="text-decoration:blink;color:purple;">Nouvelles<br>
			<div style="font-size:0.6em;font-weight:normal;">
				(12/01/2011)
			</div>
		</h3>
		<div id="bloccadreJaune">
<p>Consultez le <a href="http://www.keljob.com/conseils-emploi/barometre-de-lemploi/2011/barometre-de-lemploi-janvier-2011.html">
baromètre de l'emploi</a> publié par le site keljob.com.</p>
			<p>Nouveau document utile : <a href="ACTbibliotheque.php">créer des alertes Google</a> (merci à Xavier)</p>
			<p>Bonne année 2011, que chacun d'entre vous réalise ses projets.</p>
			<p>Des nouvelles de Jean-Pierre DUHEN : cliquez Nouvelles</p>
		</div>
	</div>
<br><br><br><br><br><br>
	<h2>Votre association</h2>
	<p>l’association a pour but d’aider des cadres confirmés, en recherche d’emploi, à retrouver une activité rémunérée au moyen <b>d’actions collectives</b>.
	</p>
	<p><b>Prioritairement</b>, cette aide consiste à retrouver ou à conserver les comportements professionnels au travers d’ACTIONS au contact des entreprises. (prospection dans de nombreux salons professionnels ou pendant des opérations de terrain)
	</p>
	<p><b>Subsidiairement</b>, cette aide consiste à proposer des ATELIERS et des ACTIVITES d’accompagnement visant principalement à préparer à ces actions vers les entreprises.
	</p>
	<p>Chaque activité, chaque atelier, est animé par un bénévole ou par un binôme (bénévole/bénévole ou bénévole/adhérent en recherche d'emploi)
	</p>
	<p>Les actions, ateliers, activités proposés par un animateur (ou un binôme) doivent faire  initialement l’objet d’un canevas ou d’une procédure (objet, méthode, applications) et  être préalablement validés par le Bureau de Cadres Pour l’Entreprise.
	</p>
	</p>
	<h2><a href="ACTCharte.php">Charte de l'adhérent CPE</a></h2>
	<p>Chaque adhérent s'engage à respecter la charte qu'il a signée.</p>
	<p>L'adhérent s'engage ainsi en particulier à participer aux actions prioritaires de l'association qui sont effectuées dans une démarche solidaire.
	</p>
	<h2><a href="ACTStatistiques.php">Statistiques CPE</a></h2>
</div>
	<!--<p id="piedDePage"></p>-->
</div>
</body>
</html>
