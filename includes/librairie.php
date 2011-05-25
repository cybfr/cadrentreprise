<?php
function initCookie( $valeur )
	{
	$expiration = 0;	// cookie expire à fermeture navigateur
	$valeur = codeTxt( "azerty", $valeur );
	setcookie("CPEid", $valeur, $expiration );
	}

function recupCookie( )
	{
	$valeur =  $_COOKIE[ 'CPEid' ];
	return decodeTxt( "azerty", $valeur );
	}

function decodeTxt( $filtre, $str )
	{
	$filter = md5( $filtre );
	$letter = -1;
	$newstr = '';
	$str = base64_decode($str);
	$strlen = strlen($str);
	$newstr = "";
	for ( $i = 0; $i < $strlen; $i++ )
		{
		$letter++;
		if ( $letter > 31 ) $letter = 0;
		$neword = ord( $str{$i} ) - ord( $filter{$letter} );
		if ( $neword < 1 ) $neword += 256;
		$newstr .= chr($neword);
		}

	return $newstr;
	}

function codeTxt( $filtre, $str )
	{
	$filter = md5( $filtre );
	$letter = -1;
	$newpass = '';
	$strlen = strlen($str);
	$newstr = "";
	for ( $i = 0; $i < $strlen; $i++ )
		{
		$letter++;
		if ( $letter > 31 ) $letter = 0;
		$neword = ord($str{$i}) + ord($filter{$letter});
		if ( $neword > 255 ) $neword -= 256;
		$newstr .= chr($neword);
		}
	return base64_encode($newstr);
	}

//
//	fonction restreignant les colonnes mysql affichables
//
//		valeur de retour : liste des variables autorisées
//		entrée :
//			$colDemandees : array des noms des colonnes demandées
//			$prefixe : prefixe à ajouter devant chaque nom de col.
//				dans la liste retournée
//			$restriction (optionnel) : pointeur sur...
//		sortie :
//			$restriction : true si une colonne demandée au moins
//				a été retirée
function listeColonnesAutorisees( $colDemandees, $prefixe, &$restriction )
	{
	global $lesAutorisations;

	//	si ttes les colonnes sont autorisées : false --> $subset
	//	autrement : true --> subset
	if( !isset( $lesAutorisations ) )
		$subset = true;
	else
		{
		$i = strstr( $lesAutorisations, 'adhe:' );
		if( substr( $i, 5, 1 ) == 'W' )
			$subset = false;
		else
			{
			if( substr( $i, 8, 4 ) == 'tout' )
				$subset = false;
			else
				$subset = true;
			}
		}
	if( $subset == true )
		$colAutorisees = Array( 'id','prenom','nom','civilite','numeroRue',
			'rue','CP','ville','telephoneMobile','eMail','dateCreation',
			'integrerDansMailing','statut','dateDebutACTIF','dateFinACTIF','commentairesACTIF',
			'profession','formation','apec1','apec2','apec3',
			'apec4' );
	else
		$colAutorisees = '*';
	if( $prefixe == '' )
		$prefixeComplet = '';
	else
		$prefixeComplet = $prefixe . '.';
	//
	if( $colDemandees == '*' )
		{
		if( $colAutorisees == '*' )
			$lesCols = '*';
		else
			$lesCols = $colAutorisees;
		}
	else
		{
		if( $colAutorisees == '*' )
			$lesCols = $colDemandees;
		else
			$lesCols = array_intersect( $colDemandees, $colAutorisees );
		}
	//	
	if( is_array( $lesCols ) )
		{
		$lesColonnes = "";
		$rang = 0;
		foreach( $lesCols as $v )
			{
			if( $rang > 0 ) $lesColonnes .= ',';
			$lesColonnes .= $prefixeComplet . $v;
			$rang++;
			}
		//if( !is_null( $restriction ) )
			{
			if( sizeof( $lesCols ) == sizeof( $colDemandees ) )
				$restriction = false;
			else
				$restriction = true;
			}
		return $lesColonnes;
		}
	else
		{
		if( !is_null( $restriction ) ) $restriction = false;
		return $prefixeComplet . $lesCols;
		}
	}
?>