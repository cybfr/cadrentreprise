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

$titrePage = "recherches";
$sncfLibelles = array( 'Accueil', 'Recherches' );
$sncfLiens = array( 'ACTAccueil.php' );
require "includes/ACTenTetes.php";
require( '../includes/mySql.php' );

echo '<div id="global">';
echo '<h1>Pour vos recherches</h1>';

$query = "SELECT categorie FROM tblLiens GROUP BY categorie";
$res = mysql_query( $query ) or die( '<br>...'.$query.'<br>...'.mysql_error() );
echo '<ul>';
$rang = 0;
while( $l=mysql_fetch_assoc( $res ) )
	echo '<li><a href="#' . $rang++ . '">' . $l[ 'categorie' ] . '</a></li>';
echo '</ul>';

$query = "SELECT categorie,url,texte FROM tblLiens ORDER BY categorie";
$res = mysql_query( $query ) or die( '<br>...'.$query.'<br>...'.mysql_error() );
$categorieEnCours = 'azertyuiop';

$rang=0;
while( $l=mysql_fetch_assoc( $res ) )
	{
	if( $l[ 'categorie' ] != $categorieEnCours )
		{
		if( $categorieEnCours != 'azertyuiop' )
			echo '</div>';
		$categorieEnCours = $l[ 'categorie' ];
		echo '<h2><a name="' . $rang++ . '">' . $categorieEnCours . '</a></h2>';
		echo '<div style="padding-left:4em;">';
		}
	if( $l[ 'texte' ] == '' )
		$l[ 'texte' ] = '...';
	echo '<p><a href="' . $l[ 'url' ] . '" >' . $l[ 'texte' ] . '</a></p>';
	}
echo '</div>';
?>

		</div>
	</body>
</html>
