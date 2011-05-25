<?php
require '../includes/librairie.php';

if( !isset( $_COOKIE['CPEid'] ) )
	{
	echo "accès refusé";
	exit( 0 );
	}
else
	{
	$lesTokens = explode( "\\", recupCookie( ) );
	if( $lesTokens[1] != 'actif' )
		{
		echo "accès refusé";
		exit( 0 );
		}
	}
?>
