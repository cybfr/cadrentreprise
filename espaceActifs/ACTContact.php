<?php
function getEMailFromPseudo( $pseudo )
	{
	$query = "SELECT A.eMail FROM tblAdherents AS A, tblMdp AS M"
		. " WHERE login='"
			. $pseudo . "'"
			. " AND M.idAdherent = A.id";
	$result = mysql_query( $query );
	$nbr = mysql_num_rows( $result );
	if( $nbr != 1 )
		return "";
	else
		{
		$line = mysql_fetch_assoc( $result );
		return $line[ 'eMail' ];
		}
	}

// if( !isset( $_COOKIE['CPEid'] ) )
if(false)         // W3C validation item
		{	// cookie pas défini : on va vers l'authentification
		//	avec l'url cible en paramètre (dans cette url cible, l'ancre
		//	est délimitée par '.m.' et les param au delà du prmier par .p.
	$lUri = $_SERVER[ 'REQUEST_URI'];
	$lUrl = 'Location: ../identification1.php?url='
		. urlencode( $lUri );
	header( $lUrl );
	exit;
	}
$cryptinstall="../crypt/cryptographp.fct.php";
include $cryptinstall;
require_once "../includes/librairie.php";
require_once "includes/librairie.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" >
	<head>
		<title>CPE - Espace Adhérents Actifs</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/ACTstyle.css" />
		<style type="text/css">
			em {color:red; font-style:normal; text-decoration:bold;}
		</style>
	</head>
<!-- en-têtes -->
	<body id="global2" style="padding-top:10px;">
		<div id="header2">
			<img src="../images/logo50.gif" alt="logo CPE" />
<?php
echo 		'<div style="float:right;">';
$login = getLogin();
if( $login === false )
	{
	echo 		'<br>Accès refusé<br>';
	exit;
	}
echo 			$login;
echo		'</div>';
//	email réponse --> $mailReponse;
if( isset( $_GET[ 'email' ] ) )
	$mailReponse = $_GET[ 'email' ];
else
	{
	require "../includes/mySql.php";
	$mailReponse = getEMailFromPseudo( $login );
	}
?>
			<p>Cadres pour l'Entreprise</p>
		</div>
		<div id="cdeFer">
			Contact
		</div>
<!-- Contenu -->
		<form id="mail" action="ACTContactEnvoi.php" method="post" enctype="multipart/form-data">
			<table border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
				<colgroup width="110px"></colgroup><colgroup width="145px"></colgroup>
				<tr><td><p>Destinataire&nbsp;&nbsp;</p></td>
					<td>
						<div style="text-align: left">
<?php
// paramètre 'dest' :
//		P, W ou CEmpl
//		ou bien 'pseudo' concaténé avec pseudo du destinataire
//		ou bien 'L' : dans ce cas le param adresses contient la liste des adresses (séparateur ;)
$lePseudo = '';
if( isset( $_GET[ 'dest' ] ) )
	{
	$destinataire = $_GET['dest'];
	if( substr( $destinataire,0,6) == 'pseudo' )
		{
		$lePseudo = substr( $destinataire, 6 );
		$lesDestinataires = array( array( 'pseudo', $lePseudo ) );
		}
	else if( $destinataire = "L" )
		$lesDestinataires = $_GET[ 'adresses' ];
	}
else
	$destinataire = "";
if( !isset( $lesDestinataires ) )
	$lesDestinataires = array( array('P','Président'), array('CEmpl','Commission Emploi'),
		array('W','Webmestre') );

$nbrDest = sizeof( $lesDestinataires );
//echo '<br>...' . $nbrDest;
//echo '<pre>' ; print_r($lesDestinataires); echo '</pre>';
if( $nbrDest == 1 )
	{
	if( $destinataire = "L" )
		{	// liste d'adresses emails brutes
		echo '<input type="hidden" name="destinataire" value="L">';
		echo '<input type="hidden" name="adresses" value="' . $lesDestinataires . '">';
		echo $lesDestinataires;
		}
	else
		{	// pseudo
		echo '<input type="hidden" name="destinataire" value="' . $_GET['dest'] . '" />';
		echo $lesDestinataires[0][1];
		}
	}
else
	{
	echo '<select name="destinataire" size="1">';
	for( $i=0; $i < $nbrDest; $i++ )
		{
		echo '<option value="' . $lesDestinataires[$i][0] . '">'
			. $lesDestinataires[$i][1] . '</option>';
		}
	echo '</select>';
	}
?>
						</div>
					</td>
				</tr>
			<tr><td>Expéditeur<em>*</em> (adresse mail pour réponse)</td>
			<td style="border:none;">
<?php
//echo '<br>...' . $mailReponse;
			if( $mailReponse != '' )
				{
				echo '<input type="hidden" name="email" value="' . $mailReponse . '" />';
				echo $mailReponse;
				}
			else
				{
				echo '<input type="text" size="40"'
					. ' name="email" title="saisissez votre adresse e-mail" size="35">';
				}
?>
			</td></tr>

			<tr><td>Objet<em>*</em></td>
			<td style="border:none;">
				<input type="text" value="
<?php
			if( isset( $_GET[ 'subject' ] ) )
				echo htmlentities( stripcslashes( stripcslashes( $_GET[ 'subject' ] ) ),
					ENT_QUOTES, "UTF-8" );
?>
					" name="subject" title="saisissez l'objet de votre message (10 caractères au moins)"
						size="40" />
			</td></tr>
			<tr><td>Message<em>*</em></td>
			<td style="border:none;">
				<textarea rows="12" name="msg" cols="40" title="saisissez le texte de votre message (10 caractères au moins)">
<?php
			if( isset( $_GET[ 'msg' ] ) )
				echo stripcslashes( stripcslashes( $_GET[ 'msg' ] ) );
?>
				</textarea>
			</td></tr>

			<tr><td>Fichier à joindre au message (facultatif)</td>
				<td style="border:none;">
					<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
					<input type="file" src="images/btnParcourir.gif"
						size="40" name="pjurl" maxlength="100000"
						title="choisissez (optionnel) un fichier à joindre au message" />
			</td></tr>
			<tr><td>Recopiez le code ci-contre<em>*</em><br />(mesure antispam)</td>
			<td style="border: none;">
				<table><tr><td style="border: none;padding-top: 5px;">
<?php
					echo dsp_crypt(0,1);
?>
					</td>
					<td style="border: none;"><input type="text" name="code" /></td></tr>
				</table> 
			</td></tr>
			</table>
			<div style="margin:10px 0 0px 20px;clear:both;">
				<a href="javascript:close('contact')">
					<img src="../images/btnAnnuler.gif" alt="Annuler" />
				</a>
				<input type="image" value="Envoyer" src="../images/btnValider.gif" />
			</div>
		</form>
	</body>
</html>