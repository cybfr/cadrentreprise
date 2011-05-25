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
require_once "includes/librairie.php";
$lePath = getPathRacine();
$titrePage = "assistance";
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
		<div id="global">
			<h1>Assistance Espace pour Adhérents Actifs</h1>
			<p>Bienvenue dans l'espace dédié aux adhérents actifs de CPE.</p>
			<h2>le site est structuré en 8 chapitres</h2>
			<p>Pour accéder à un des chapitres, cliquez son nom dans la colonne affichée à gauche de votre écran..</p>
			<p>Les chapitres sont les suivants :
<ul>
<li>Accueil : décrit brièvement le fonctionnement de l'Association et vous donne accès à la charte des adhérents ainsi qu'à quekques statistiques</li>
<li>Agenda : liste les activités (ateliers en particulier) et vous permet d'entrer en relation avec les animateurs bénévoles.</li>
<li>Activités : décrit en détail les activités proposées par CPE pour vous accompagner dans votre recherche d'emploi.</li>
<li>Documents : donnes accès à de nombreux documents très utiles.</li>
<li>Recherches : une liste de liens sur des sites également utiles.</li>
<li>Nouvelles : nouvelles d'adhérents venant de retrouver un emploi.</li>
<li>Données personnelles : liste les données intégrées par l'Association dans votre dossier et vous explique comment demander leur modification.</li>
<li>Réseau : permet de rechercher les anciens CPE qui pourraient vous aider dans votre recherche d'emploi.</li>
</ul>
			</p>
<h2>Le menu horizontal</h2>
<p>Dans la partie supérieure de l'écran vous voyez (barre orange) un menu horizontal qui propose 3 options :
<ul>
<li>Contact : pour adresser un courriel au Président, à la Commission Emploi ou au Webmestre</li>
<li>Assistance : pour afficher le présent écran</li>
<li>Déconnexion : pour vous déconnecter de l'espace actifs. La déconnexion est essentielle pour la sécurité.</li>
</ul>
<h2>Vos remarques et suggestions</h2>
<p>Pour améliorer ce site et le garder focalisé sur vos besoins, vos remarques et suggestions sont bienvenues.</p>
<p>Pour les formuler, utiliser "Contact" dans le menu horizontal et choisissez le Webmestre comme destinataire.</p>
<div style="border:3px solid orange;padding-left:10px;padding-right:10px;">
<p>L'espace actifs du site web CPE est un complément aux contacts directs que vous entretiendrez lors des réunions du mardi, les ateliers, les salons et opérations de terrain.</p>
<p>Ces contacts directs sont essentiels dans le cadre de CPE.</p>
</div>
		</div>
	<!--<p id="piedDePage"></p>-->
		</div>
	</body>
</html>
