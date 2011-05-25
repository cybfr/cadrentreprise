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
$titrePage = "initiation réseau";
$sncfLibelles = array( 'Accueil','Activités','Atelier Initiation Réseau' );
$sncfLiens = array( 'ACTAccueil.php','ACTactivites.php' );
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
		<div id="global">
			<h1>l'atelier initiation réseau</h1>
			<p>L’atelier "initiation au réseau" a pour objectif de donner aux adhérents une méthodologie pour construire et entretenir un réseau.
			</p>
			<p>Il s’agit ici de créer et d’utiliser ce  réseau  en situation de repositionnement professionnel.</p>
			<p>Cet atelier donne les principes d’action nécessaires à la mise en œuvre.</p>
			<h2>Les points abordés </h2>
			<h3>Partie théorique</h3>
			<ul>
				<li>Comment chercher un emploi,</li>
				<li>L’approche directe,</li>
				<li>Approcher les opérationnels,</li>
				<li>Structure du réseau,</li>
				<li>Construire le réseau,</li>
				<li>Les acteurs du réseau,</li>
				<li>Les facteurs clés du succès,</li>
			</ul>
			<h3>Partie pratique</h3>
			<ul>
				<li>Préparation et suivi de l’ entretien</li>
				<li>retours d’expérience</li>
			</ul>
		</div>
	<!--<p id="piedDePage"></p>-->
		</div>
	</body>
</html>
