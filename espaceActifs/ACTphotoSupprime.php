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
$titrePage = "suppression photo";
$sncfLibelles = array( 'Accueil', 'Données', 'Suppression photo' );
$sncfLiens = array( 'ACTAccueil.php', 'ACTdonnees.php' );
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
		<div id="global">
			<h1>Espace actifs - suppression photo</h1>

<?php
$nomFichier = '../photosId/id' . $_GET[ 'id' ] . ".png";
$result = unlink( $nomFichier );
//
if( $result )
	echo 	'<h2>Suppression effectuée</h2>';else
	echo 	'<h2>Erreur : la suppression n\'a pas été effectuée</h2>';?>
		</div>
		<div id="btnRetour">
			<a onclick="window.close();">
				<img src="../images/btnRetour.gif">
			</a>
		</div>
	</body>
</html>