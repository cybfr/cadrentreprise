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
$cryptinstall="../crypt/cryptographp.fct.php";
include $cryptinstall;  

require_once "../includes/librairie.php";
require_once "includes/librairie.php";
require_once '../includes/librairieMail.php';

switch( $_POST['destinataire'] )
	{
	case "P" :
		$dest = "patricegrenon@wanadoo.fr";
		break;
	case "CEmpl" :
		$dest = "commission.emploi@cadrentreprise.asso.fr";
		break;
	case "W" :
		$dest = "webmestre@cadrentreprise.asso.fr";		//"webmaster@cadrentreprise.asso.fr";
		break;
	default :
		{
		if( substr( $_POST['destinataire'],0,6) == 'pseudo' )
			{
			require "../includes/mySql.php";
			$dest = getEMailFromPseudo( substr( $_POST['destinataire'], 6 ) );
			}
		else if( $_POST['destinataire'] == 'L' )
			$dest = $_POST['adresses'];
		else
			$dest = "?";
		}
	}
$email = StripSlashes($_POST['email']);
$subject = StripSlashes($_POST['subject']);
$lesTokens = explode( "\\", recupCookie( ) );
$msg = "Message envoyé depuis site web CPE (espace actifs, "
	. "login " . $lesTokens[ 0 ]
	. " " . date('d-m-y H:i:s') . "): \n\n"
	. StripSlashes($_POST['msg']);
$m = new Mail; // create the mail
$res = true;
$m->errNum = 0;
$m->Subject( "$subject" );
$res = $m->From( "$email" );
$m->To( $dest );
//	contrôle captcha
if( !chk_crypt( $_POST['code'] ) )
	{
	$res = false;
	$m->errNum = ERR_CAPTCHA;
	}
if( $res )
	{ 
	$m->Body( $msg );
	if( strlen(  $_FILES['pjurl']['name'] ) )
		{
		if( $_FILES['pjurl']['size'] > $_POST['MAX_FILE_SIZE']
			|| $_FILES['pjurl']['size'] == 0 )
			{
			$res = false;
			$m->errNum = ERR_TAILLE_PJ;
			}
		else	
			$m->Attach( $_FILES['pjurl']['tmp_name'],  $_FILES['pjurl']['name'], "application/octet-stream" );
		}
	}

if( $res )
	{
	if( strlen( $subject ) < 10 )
		{
		$res = false;
		$m->errNum = ERR_OBJET_COURT;
		}
	else if( strlen( $_POST['msg'] ) < 10 )
		{
		$res = false;
		$m->errNum = ERR_CORPS_COURT;
		}
	else
		{
		$res = $m->From( $email );
		$nbrDest = count( $dest );
		if( isset( $_POST[ 'nbrMaxParBloc' ] ) )
			{
			$nbrMaxParEnvoi = $_POST[ 'nbrMaxParBloc' ];
			$numBloc = $_POST[ 'numBloc' ];
			$listeDest = '';
			for( $iDest=($numBloc-1)*$nbrMaxParEnvoi;
				$iDest<$numBloc*$nbrMaxParEnvoi AND $iDest<$nbrDest;
				$iDest++ )
				$listeDest .= $dest[ $iDest ] . ',';
			$listeDest = substr( $listeDest, 0, -1 );
			}
		else
			$listeDest = $dest;
		$m->To( $listeDest );
		$m->Subject( $subject );
		$res = $m->Send();
//error_log('...envoi mails $res '.$res.'...à : '.$listeDest);
		if( isset( $_POST[ 'nbrMaxParBloc' ] ) AND $res )
			{
			$res = false;
			$m->errNum = ERR_ENVOI_BLOC;
			}
		}
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN" "http://www.w3.org/YT/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="HTTP://WWW.W3.ORG/1999/XHTML" xml:lang="FR" lang="FR">
<head>
	<title>CPE - Cadres pour l'Entreprise - Contact</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" HREF="css/ACTstyle.css">
</head>
<body id="global2" style="padding-top:2em;">
	<div id="header2">
		<img src="../images/logo50.gif" alt="logo CPE" />
		<p>Cadres pour l'Entreprise</p>
	</div>
	<div id="cdeFer">
<?php
		echo "<a href=\"ACTcontact.php?destinataire=" . $_POST['destinataire'] . "\">Contact</a>";
		echo "&nbsp;>&nbsp;";
if( $res )
	{
	echo "confirmation envoi</div>";
	echo '<p style="font-weight:bold;font-size:1.2em;color:red;">Votre message a été envoyé.</p>';
	echo '<p>Nous le traiterons dans les meilleurs délais</p>';
	}
else
	{
	if( $m->errNum == ERR_ENVOI_BLOC )
		{
		echo '</div>';
		if( $numBloc * $nbrMaxParEnvoi >= $nbrDest )
			{
			echo '<p style="font-weight:bold;font-size:1.2em;color:green;">Votre message a été envoyé au dernier bloc de ' . $nbrMaxParEnvoi . ' destinataires.</p>';
			$res = true;
			}
		else
			{
			echo '<p style="font-weight:bold;font-size:1.2em;color:orange;">Votre message a été envoyé au bloc n° ' . $numBloc . ' de ' . $nbrMaxParEnvoi . ' destinataires.</p>';
			echo '<p>Pour envoyer le bloc suivant:<ul>'
				. '<li>cliquez "Retour Saisie",</li><li>attendez cinq minutes,</li><li>recopiez le code demandé</li><li>cliquez "Valider".</li></ul></p>';
			}
		}
	else
		{
		echo "erreur</div>";
		echo '<p style="font-weight:bold;font-size:1.2em;color:red;">Votre message n\'a pas été envoyé</p>';
		echo '<p>Veuillez retourner à la saisie et corriger l\'erreur indiquée ci-dessous</p>';
		switch( $m->errNum )
			{
			case ERR_FONCTION_MAIL :		//	erreur fonction email
				echo "<p>Le service est actuellement indisponible. Merci de réessayer dans quelques temps.</p>";
				echo "<p>Si l'erreur persiste : adressez un courriel à webmestrer@cadrentreprise.asso.fr.</p>";
				break;
			case ERR_ADRESSE_INVALIDE :		//	adresse invalide
				echo "<p>L'adresse expéditeur (" . $m->errMsg . ") est invalide.</p>";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis saisissez une adresse email valide.</li></ul>";
				break;
			case ERR_OBJET_COURT :		//	texte objet du message trop court
				echo "<p>L'objet de votre message doit comporter au moins 10 caractères.</p>";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis saisissez un objet de 10 caractères au moins.</li></ul>";
				break;
			case ERR_CORPS_COURT :		//	texte corps du message trop court
				echo "<p>Votre message doit comporter au moins 10 caractères.</p>";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis saisissez un message de 10 caractères au moins.</li></ul>";
				break;
			case ERR_TAILLE_PJ :		//	pièce jointe trop grosse
				echo "<p>Votre pièce jointe dépasse la taille maximum autorisée ("
					. $_POST['MAX_FILE_SIZE'] . " octets).</p>";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis choisissez une pièce jointe de taille adaptée.</li></ul>";
				break;
			case ERR_CAPTCHA :		//	captcha non conforme
				echo "<p>Code saisi non conforme.";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis recopiez le code obligatoire (mesure antispam)</li></ul>";
				break;
			default :
				echo "<p>Erreur inconnue " . $m->errNum . "</p>";
				break;
			}
		}
	}
//	mySql : journalisation de l'envoi
//require "../includes/mySql.php";

//$insert = "insert into tblMails (objet, source, destination, statut) values (";
//$insert .= "'" . $m->msubject . "',";
//$insert .= "'" . $m->from . "',";
//$insert .= "'";
//for( $i=0; $i< sizeof( $m->sendto ); $i++ )
//	$insert .= $m->sendto[$i] . " ";
//$insert = substr( $insert, 0, strlen($insert)-2);
//$insert .= "'," . $m->errNum . ")";
//$result = mysql_query($insert) or die("erreur : " . mysql_error() );
?>
	<a href="javascript:close()">
		<img src="../images/btnRetour.gif" border="0" />
	</a>
<?php
	if( !$res )
		{
		$lesParams = 'destinataire=' . $_POST['destinataire']
			. '&email=' . $email
			. '&subject=' . rawurlencode($subject)
			. '&msg=' . rawurlencode( $_POST['msg'] );
		echo 	'<a href="ACTContact.php?'
					. htmlentities( $lesParams )
					. '" style="padding-left:100px">';
		echo 	'<img src="../images/btnRetourSaisie.gif" border="0" />';
		echo "</a>";
		}
?>
	</body>
</html>
