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
$titrePage = "Atouts et Réussites";
$sncfLibelles = array( 'Accueil','Activités','Atelier Atouts et Réussites' );
$sncfLiens = array( 'ACTAccueil.php','ACTactivites.php' );
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
<div id="global">
	<h1>l'atelier atouts et réussites</h1>
	<p>L’atelier atouts et réussites a pour objectif de
		<ul>
			<li>Vous préparer à répondre à la question <em>"quels sont vos 3-4 <b>domaines de compétences professionnelles</b> ?"</em>&nbsp;&nbsp;&nbsp;puis à <b>illustrer et prouver</b> ces compétences par des <b>réalisations</b>.
			</li>
			<li>Vous préparer à énoncer votre <b>métier</b> et à parler des grandes <b>étapes de votre parcours</b></li>
		</ul>
	</p>
	<p>L’enjeu  est important : sans idées claires sur ces points vous ne pourrez pas être très performant en entretien. L’Objectif est ambitieux et demande un travail préalable de votre part..
	</p>
	<p>Cet atelier donne les principes d’action nécessaires à la mise en œuvre.</p>
	<h2>Une réalisation, c’est quoi ?</h2>
	<p>C’est un succès, une réussite.</p>
	<p>Face à un problème, un dysfonctionnement ou un objectif, vous avez mis en place une <b>solution</b> qui a amené un <b>résultat</b>.
	<h2>C’EST UNE REALISATION</h2>
	<p>Une <b>réalisation</b>, c’est intéressant parce que c’est la base de votre expérience  professionnelle, <b>la preuve</b>  de votre  <b>savoir-faire</b>.
	</p>
	<p>C’est  donc par l’approche <em>Réalisation</em>&nbsp;&nbsp;&nbsp;que nous vous proposons d’avancer.</p>
	<p>Une <b>réalisation</b> peut se décrire en répondant à 4 questions :
		<ul>
			<li>La situation de départ et l’objectif ?</li>
			<li>Les actions et décisions mises en œuvre ?</li>
			<li>Les résultats ?</li>
			<li>Les savoir-faire développés ou acquis ?</li>
		</ul>
	</p>
	<p>Pour préparer cet atelier, nous vous invitons à <b>écrire</b> un minimum de trois réalisations.</p>
	<p>Ne retenez pas celles qui sont  trop lointaines : elles ne prouveraient pas grand-chose.</p>
	<p>N’oubliez pas qu’elles peuvent concerner de l’extra professionnel.</p>
</div>
	<!--<p id="piedDePage"></p>-->
</div>
</body>
</html>
