<?php
$cryptinstall="./crypt/cryptographp.fct.php";
require $cryptinstall;  
error_log('entrée dans contactEnvoi.php');
require 'includes/librairieMail.php';
require 'includes/librairie.php';

	{
	if( isset( $_POST['destinataire'] ) )
		{
		switch( $_POST['destinataire'] )
			{
			case "I" :
				$dest = "info@cadrentreprise.asso.fr";
				break;
			case "CEmpl" :
				$dest = array( "commission.emploi@cadrentreprise.asso.fr" );
				break;
			case "CEntr" :
				$dest = "?";
				break;
			case "W" :
				$dest = "webmestre@cadrentreprise.asso.fr";
				break;
			default :
				$dest = $_POST['destinataire'];
			}
		}
	else
		$dest = "?";
	$email = stripslashes( $_POST[ 'email' ] );
	$subject = stripslashes( $_POST['subject'] );
	$msg = "Message envoyé depuis site web CPE (" . date('d-m-y H:i:s') . "): \n\n";
	$msg .= stripslashes( $_POST['msg'] );
	
	$m = new Mail; // create the mail
	$res = true;
	$m->errNum = 0;
	//	contrôle captcha

	if( !chk_crypt( $_POST['code'] ) )
		{
		$res = false;
		$m->errNum = ERR_CAPTCHA;
		}
	if( $res )
		{
		$m->Subject( $subject );
	
		$res = $m->From( $email );
		//$m->To( $dest );
		}
	if( $res )
		{
		if( isset( $_POST[ 'cci' ] ) )
			$m->Cc( $_POST[ 'cci' ] );
//echo '<br>...cci '.count($_POST[ 'cci' ]);
		}
	if( $res )
		{ 
		$m->Body( $msg );
		if( isset( $_POST[ 'piecesJointesN' ] ) )
			{
			$lesFN = explode( ';', $_POST[ 'piecesJointesN' ] );
			foreach( $lesFN as $leFN )
				$m->Attach( 'espaceActifs/bibliotheque/' . $leFN,  $leFN, "application/octet-stream" );
			}
		elseif( isset( $_FILES['pjurl'] ) AND strlen(  $_FILES['pjurl']['name'] ) )
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
					$m->To( $dest );
					$res = $m->Send();
			}
		}
	
	if( $res )
		$_SESSION[ 'statutMail' ] = 'ok';
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN" "http://www.w3.org/YT/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="HTTP://WWW.W3.ORG/1999/XHTML" xml:lang="FR" lang="FR">
	<head>
		<title>CPE - Cadres pour l'Entreprise - envoi contact</title>
		<meta name="robots" content="noindex,nofollow">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" HREF="css/style.css">
	</head>
	<body id="global2" style="padding-top:2em;">
		<div id="header2">
			<img src="images/logo50.gif" alt="logo CPE" />
			<p>Cadres pour l'Entreprise</p>
		</div>
		<div id="cdeFer">
			<a href="contact.php">Contact</a>
			&nbsp;&gt;&nbsp; </div>
<?php
	echo 	"<a href=\"contactSaisie.php?destinataire=" . $_POST['destinataire'] . "\">Saisie</a>";
	echo 	"&nbsp;>&nbsp;";
	if( $res )
		{
		echo "confirmation envoi</div>";
		echo '<p style="font-weight:bold;font-size:1.2em;color:red;">Votre message a été envoyé.</p>';
		echo '<p>Nous le traiterons dans les meilleurs délais</p>';
if( isset( $_POST[ 'ro' ] ) )
	{
	require 'includes/mySql.php';
	$param = explode( '/', $_POST[ 'ro' ] );
	$query = "INSERT INTO tblMailsCPE"
		. " VALUES( '" . $param[0] . "',NOW()," . $param[1] . ",'" . $param[2] . "')";
	$res = mysql_query( $query ) or die( '<br>...'.$query.'<br>...'.mysql_error());
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
	//	mySql : journalisation de l'envoi
	//require "includes/mySql.php";

	//$insert = "insert into tblMails (objet, source, destination, statut) values (";
	//$insert .= "'" . $m->msubject . "',";
	//$insert .= "'" . $m->from . "',";
	//$insert .= "'";
	//for( $i=0; $i< sizeof( $m->sendto ); $i++ )
	//	$insert .= $m->sendto[$i] . " ";
	//$insert = substr( $insert, 0, strlen($insert)-2);
	//$insert .= "'," . $m->errNum . ")";
	//$result = mysql_query($insert) or die("erreur : " . mysql_error() );

	}

?>
	<a href="javascript:close('contact')">
		<img src="images/btnRetour.gif" border="0" />
	</a>
<?php
	if( !$res )
		{
		$lesParams = 'destinataire=' . $_POST['destinataire']
			. '&email=' . $email
			. '&subject=' . rawurlencode($subject)
			. '&msg=' . rawurlencode( $_POST['msg'] );
		if( isset( $_POST[ 'ro' ] ) )
			$lesParams .= '&ro=' . $_POST[ 'ro' ];
		if( isset( $_POST[ 'piecesJointesN' ] ) )
			$lesParams .= '&piecesJointesN=' . $_POST[ 'piecesJointesN' ];

		echo 	'<a href="contactSaisie.php?'
					. htmlentities( $lesParams )
					. '" style="padding-left:100px">';
		echo 	'<img src="images/btnRetourSaisie.gif" border="0" />';
		echo "</a>";
		}
?>
	</body>
</html>

