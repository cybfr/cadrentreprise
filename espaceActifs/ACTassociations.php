<?php
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
	echo '<p><a href="' . $l[ 'url' ] . '" >' . htmlspecialchars($l[ 'texte' ]).'
	</a></p>';
	}
echo '</div>';
?>

		</div>
	</body>
</html>
