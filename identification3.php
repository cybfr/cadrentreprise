<?php
require 'includes/librairie.php';

switch( $_GET['espace'] )
	{
	case 'ancien' :
		header( 'location:espaceAnciens/ANCAccueil.php' );
		break;
	case 'actif' :
		header( 'location:espaceActifs/ACTAccueil.php' );
		break;
	default :
		echo '?????';
		exit( 0 );
	}
$lesTokens = explode( "\\", recupCookie( ) );
$valeur = $lesTokens[0]. "\\" . $_GET['espace'];
			initCookie( $valeur );
?>