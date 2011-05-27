<?php
require "../includes/mySql.php";
// require_once "includes/ACTenTetes2.php";
//	affichage HTML d'un projetflash
function affichageHTMLunProjetFlash( $line, $rangCol, $queryString, $avecLien = true ){
	$ProjetFlash =	'<div class="titre">' . nl2br(htmlspecialchars(stripslashes($line['titre']))) . '</div>';
	$ProjetFlash .=	'<div class="sousTitre">' . nl2br(htmlspecialchars(stripslashes($line['sousTitre']))) . '</div>';
	$ProjetFlash .=	'<div class="pointsForts"><ul>';
	$lesPtsForts = explode( "\n", $line[ 'pointsForts' ] );
	foreach( $lesPtsForts as $lePtFort ){
	if( $lePtFort <> "" ){
		$ProjetFlash .=	'<li>' . htmlspecialchars(stripcslashes(rtrim($lePtFort))) . '</li>';}
	}
	$ProjetFlash .=	'</ul></div>';
	$ProjetFlash .=	'<div class="complements">' . nl2br(htmlspecialchars($line['complements'])) . '</div>';
	return($ProjetFlash);
}
?>
<?php
$idAdherent = $_GET['idAdherent'];
$prenomNom = "François-Régis Vuillemin";
$statut = "ACTIF";
$email = "cpe@miradou.com";
$mobile = "06 74 41 74 16";
$fixe = "09 51 76 00 03";

$query = "SELECT * FROM tblAdherents WHERE `id` = $idAdherent";
$result = mysql_query($query) or die('<br>...'.$query.'<br>...'.mysql_error());
if( mysql_num_rows( $result ) == 0 ){die("No adherent with id = $idAdherent");}
$row = mysql_fetch_assoc( $result );
$prenomNom = $row['prenom']."&nbsp<b>".$row['nom']."</b>"; 
$statut = $row['statut'];
$email = $row['eMail'];
$mobile = $row['telephoneMobile'];
$fixe = $row['telephoneFixe'];
$adresse = $row['numeroRue']."&nbsp".$row['rue']."&nbsp".$row['CP']."&nbsp".$row['ville'];
if(file_exists("../photosId/id".$idAdherent.".png")) $photoId = '<img src="../photosId/id'.$idAdherent.'.png" />';

$disStatut = '';
if( isset($statut) )
	{
	$disStatut .= ' (membre ';
	switch( $statut )
		{
		case 'BENEVOLE' :
			$disStatut .= 'bénévol';
			break;
		case 'ACTIF' :
			$disStatut .= 'actif)';
			break;
		case 'INTER' :
			$disStatut .= 'actif récent)';
			break;
		default :
			$disStatut .= '???)';
			break;
		}
	}
$query = "SELECT * FROM tblMiniCV"
	. " WHERE idAdherent=" . $idAdherent;
$result = mysql_query($query) or die('<br>...'.$query.'<br>...'.mysl_error());
if( ( $nbr = mysql_num_rows( $result ) ) == 0 )
	$ProjetFlash =  '';
else
	{
	$ProjetFlash =  '';
	$ProjetFlash .=  '<div style="margin-left:10px;">';
	while( $l = mysql_fetch_assoc( $result ) )
		{
			$ProjetFlash .= affichageHTMLunProjetFlash( $l, 0, '', false )."<hr />";
		}
	$ProjetFlash .= "</div>";
	}
?>
<!-- Contenu -->
<?php 	
// echo '<div style="width: 40%; border: 1px solid #aaa; color: #555; -webkit-border-radius: 10px;">';
echo '
	<div style="float:right; padding: 10px;">'.$photoId.'</div>
	<div style="margin-left:0px;padding-top:20px;"><ul style="list-style-type: none; margin: 0; margin-left: 1em; padding: 0;">
	<span style="font-size:120%; margin-left: -0.8em;">'.$prenomNom.$disStatut.'</span>
	<li>'.$adresse.'</li>
	<li>' . $email . '</li>';
if( $mobile != '' )	echo '<li>'.$mobile.'</li>';
	else			echo '<li>'.$fixe.'</li>';
echo '</ul>';
echo $ProjetFlash;
?>
				</div>
