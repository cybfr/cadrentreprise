<?php // régénération fichier .htpasswd
//	path vers fichiers .htaccess et .htpasswd --> $lePath
//	'Mac' ou 'PC' --> $laPlateforme (sans signification si $laCible != 'L'
$lePath = $_SERVER[ 'SCRIPT_FILENAME' ];
if( substr( $lePath, 0, 1 ) == '/' )
	$laPlateforme = 'Mac';
else
	$laPlateforme = 'PC';
$lesSegments = explode( '/', $lePath );
$lePath = "";
foreach( $lesSegments as $leSegment )
	{
	if( $leSegment == 'identification4.php'
		OR $leSegment == 'admin' ) break;
	$lePath = $lePath . $leSegment . '/';
	}

$laCible = $_SERVER[ 'SERVER_NAME' ];
$debutCible = substr( $laCible, 0, 1 );
//	fichier des logins/mots de passe
$query = "SELECT * FROM tblMdp";
$result = mysql_query($query);
$nbrLogins = mysql_num_rows($result);
if( $nbrLogins == 0 ) die( 'aucun login' );

$leFichier = $lePath . 'yeu/.htpasswd';
$handle = fopen( $leFichier, "w");
if( !$handle ) die( 'erreur ouverture ' . $leFichier );

while( ($line = mysql_fetch_assoc($result)) )
	{	//	les mots de passe sont en clair sur free et sur PC
	if( ($debutCible == 'L' or $debutCible == 'l' or $debutCible == 'i' )
		AND $laPlateforme == "Mac" )
		$mdp = crypt( $line[ 'mdp' ] );
	else
		$mdp = $line[ 'mdp' ];
	$laLigne = sprintf( "%s:%s\n", $line[ 'login' ], $mdp );
    	if(!fwrite( $handle, $laLigne ) ) die( 'erreur écriture ' . $leFichier );
	}
fclose( $handle );
?>