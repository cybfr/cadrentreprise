<?php
//	affichage HTML d'un projetflash
function affichageHTMLunProjetFlash( $line, $rangCol, $queryString, $avecLien = true )
	{
	switch( $line[ 'telephone' ] )
		{
		case 'mob' : $leTelephone = $line[ 'telephoneMobile' ]; break;
		case 'fix' : $leTelephone = $line[ 'telephoneFixe' ]; break;
		default : $leTelephone = '';
		}
	if( $rangCol == 0 ) echo '<tr>';
	echo '<td><div style="width:9.6cm;height:5.1cm;overflow:auto;">';
	if( $avecLien )
		echo	'<a href="miniCVUnMiniCV.php?' . $queryString
			. '&titreProjet=' . urlencode( $line[ 'titre' ] )
			. '&telephone=' . $leTelephone
			. '&ref=' . $line[ 'id']
 			. '">';
	echo 	'<div class="titre">' . nl2br(stripslashes($line[ 'titre' ])) . '</div>';
	echo 	'<div class="sousTitre">' . nl2br(stripslashes($line[ 'sousTitre' ])) . '</div>';
	echo 	'<div class="pointsForts"><ul>';
	$lesPtsForts = explode( "\n", $line[ 'pointsForts' ] );
	$rangAlinea = 0;
	foreach( $lesPtsForts as $lePtFort )
		{
		if( $lePtFort <> "" )
			{
if( false )
	{	// pour déboguage : affichage des 3 derniers caractères
	$i=strlen($lePtFort);
	$mess = "";
	for( $j=$i-2; $j<$i; $j++ )
		{
		$leC = substr($lePtFort,$j,1);
		$mess .= '-' . $leC . '/' . ord( $leC );
		}
	echo '<br>...' . $mess . '...';
	}
			//	suppression caractère retour chariot en fin de pt fort
			$lgn = strlen( $lePtFort );
			if( ord( substr( $lePtFort, $lgn-1, 1 ) ) == 13 )
			$lePtFort = substr( $lePtFort, 0, $lgn - 1 );
			if( substr( $lePtFort, 0, 1 ) == '-' )
				{	//	alinéa de niveau 2
				if( $rangAlinea == 0 )
					{
					echo '<ul style="list-style:none;">';
					$rangAlinea++;
					}
				echo '<li>' . $lePtFort . '</li>';
				}
			else
				{
				if( $rangAlinea == 1 )
					{
					echo '</ul>';
					$rangAlinea = 0;
					}
				echo '<li>' . stripcslashes($lePtFort) . '</li>';
				}
			}
		}
	echo 		'</ul></div>';
	echo 	'<div class="complements">' . nl2br( $line['complements'] ) . '</div>';
	//echo 	'<div class="telephone">tél. <b>' . $leTelephone . '</b></div>'; 
	//echo 	'<div class="reference">réf. CPE <b>' . $line['id'] . '</b></div>'; 
	if( $avecLien )
		echo '</a>';
	echo '</div></td>';

	if( $rangCol == 1 ) echo '</tr>';
	}
?>