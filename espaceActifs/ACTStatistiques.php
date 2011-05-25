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
$titrePage = "statistiques";
$sncfLibelles = array( 'Accueil', 'Statistiques' );
$sncfLiens = array( 'ACTAccueil.php' );
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
	<div id="global">
		<h1>Statistiques CPE</h1>
<img src="images/stats_age.png" width="75%"><img src="images/stats_departs.png" width="75%"><img src="images/stats_duree.png" width="74%"><img src="images/stats_genre.png" width="74%">	</div>
	<!--<p id="piedDePage"></p>-->
</div>
	</body>
</html>
