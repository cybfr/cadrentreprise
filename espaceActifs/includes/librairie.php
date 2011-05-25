<?php
function getLogin()
	{
	if( !isset( $_COOKIE['CPEid'] ) )
		return false;
	else
		{
		$lesTokens = explode( "\\", recupCookie( ) );
		if( $lesTokens[1] != 'actif'
			AND $lesTokens[1] != 'actif-1')
			return false;
		else
			return $lesTokens[ 0 ];
		}
	}

function getEscapedString( $nomParametre )
	{
	if( get_magic_quotes_gpc() )
		return $_GET[ $nomParametre ];
	else
		return mysql_escape_string( $_GET[ $nomParametre ] );
	}

function getPathRacine()
	{
	if( $_SERVER[ 'SERVER_NAME' ] == 'cadrentreprise.free.fr' )
		//	serveur free
		$lePath = 'cadrentreprise.free.fr/';
	else
		{	// serveur local
		$lePath = $_SERVER[ 'SCRIPT_FILENAME' ];	//	le
		if( substr( $lePath, 0, 1 ) == '/' )
			{
			$laPlateforme = 'Mac';		// ou Linux
			$lesSegments = explode( '/', $lePath );
			$lePath = 'localhost/~' . $lesSegments[ 2 ] . '/web1/';
			}
		else
			{
			$laPlateforme = 'PC';
			$lePath = "C:/wamp/www/web1/";
			}
		}
	return $lePath;
	}
?>