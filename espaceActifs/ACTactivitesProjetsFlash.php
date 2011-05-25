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
$titrePage = "projets flash";
$sncfLibelles = array( 'Accueil','Activités','Atelier Initiation Réseau' );
$sncfLiens = array( 'ACTAccueil.php','ACTactivites.php' );
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
<div id="global">
	<h1>l'atelier projets flash</h1>
	<p>Pour chaque adhérent, l’atelier "projet flash" consiste à présenter et décrire son offre d'emploi, au format très synthétique d'une carte de visite.
		Cette offre d'emploi s'appuie sur un profil individuel valorisé par une expérience, des compétences et des traits de caractère.
	</p>
	<h2>Organisation pratique</h2>
	<h3>Réunion d'information et de préparation.</h3>
	<p>Rappel définition et objectif et recommandations  pour la rédaction du projet flash.
		Présentation du mode opératoire et prise de rendez-vous pour les entretiens individuels (2 à 3 jours après).
	</p>
	<h3>Préparation du projet flash par l'adhérent</h3>
	<p>L'adhérent rédige son projet flash avant l'entretien individuel et dans le cadre présenté en réunion de préparation.
	</p>
	<h3>Entretien individuel</h3>
	<p>Entretien de 30 à 45 minutes avec le responsable bénévole animateur de l'atelier et la participation d'un autre adhérent.
		Il permet d'examiner le projet flash proposé et de s'accorder ensemble sur sa rédaction finale ainsi que son classement dans l’édition qui sera ensuite diffusée.
	</p>
	<h3>Mise en forme</h3>
	<p>Saisie faite par CPE dans les 24 heures et, via internet, envoi à l'adhérent pour vérification et validation.
	</p>
	<h3>Signature</h3>
	<p>Etape finale obligatoire pré requise à toute diffusion, qui consiste pour l'adhérent à donner par écrit à CPE l'autorisation formelle de reproduire et diffuser son projet flash sur internet d'une part, en publication papier d'autre part.
	</p>
	<h3>Publication</h3>
	<p>Le projet flash est d'une part installé sur le site CPE, et d'autre part ajouté à la nouvelle publication papier remise
		aux entreprises contactées dans les salons et les opérations terrain.
	</p>
</div>
	<!--<p id="piedDePage"></p>-->
</div>
</body>
</html>
