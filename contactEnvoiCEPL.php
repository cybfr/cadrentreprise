<?php
$cryptinstall="./crypt/cryptographp.fct.php";
include $cryptinstall;  

require 'includes/librairieMail.php';
require 'includes/librairie.php';

define( "ERR_NOM", 101 );
define( "ERR_ENTREPRISE_COURT", 102 );
define( "ERR_INTITULE_COURT", 103 );
define( "ERR_DESCRIPTION_COURT", 104 );

$dest = 'commission.emploi@cadrentreprise.asso.fr';
//echo '<br><b><font color=red>Adresse cible!!!!!</font></b>';
//$dest = "webmestre@cadrentreprise.asso.fr";

$m = new Mail; // create the mail
	{
	$laFonction =stripslashes($_POST['fonction'] );
	$laCivilite = $_POST['civilite'];
	$leNom = stripslashes($_POST['nom'] );
	$lePrenom = stripslashes($_POST['prenom'] );
	$leMail = stripslashes($_POST['email'] );
	$leTel = stripslashes($_POST['tel'] ); 
	$lEntreprise = stripslashes($_POST['entreprise'] );
	$leNumeroRue = stripslashes($_POST['numeroRue'] );
	$laRue = stripslashes($_POST['rue'] );
	$leCP = stripslashes($_POST['CP'] ); 
	$laVille = stripslashes($_POST['ville'] );
	$lIntitule = stripslashes($_POST['intitule'] );
	$laDescription = stripslashes($_POST['description'] );
	//	contrôle captcha
	if( !chk_crypt( $_POST['code'] ) )
		{
		$m->errNum = ERR_CAPTCHA;
		$res = false;
		}
	else
		$res = true;
//echo '<br><b><font color=red>Ctrle captcha!!!!!</font></b>';
//$res=true;

	if( $res )
		{
		if( strlen( $leNom ) < 1 )
			{
			$res = false;
			$m->errNum = ERR_NOM;
			}
		elseif( !$m->CheckAdresses( $leMail ) )
			{
			$res = false;
			$m->errNum = ERR_ADRESSE_INVALIDE;
			}
		else if( strlen( $lEntreprise ) < 3 )
			{
			$res = false;
			$m->errNum = ERR_ENTREPRISE_COURT;
			}
		elseif( strlen( $lIntitule ) < 10 )
			{
			$res = false;
			$m->errNum = ERR_INTITULE_COURT;
			}
		else if( strlen( $laDescription ) < 10 )
			{
			$res = false;
			$m->errNum = ERR_DESCRIPTION_COURT;
			}
		}

	if( $res )
		{
		$dossier = './offresCE/';
		$extension = $nomStockageFichierJoint = '';
		if( strlen( $_FILES['pjurl']['name'] ) > 0 )
			{
			//	extension --> $extension
			if( ($i=strrpos( $_FILES['pjurl']['name'], '.' ) ) )
				$extension = substr( $_FILES['pjurl']['name'], $i );
			$nomStockageFichierJoint1 = tempnam( $dossier, 'off_' );
			$nomStockageFichierJoint = basename( $nomStockageFichierJoint1 ) . $extension;
			}


		if( !isset( $nomStockageFichierJoint ) ) $nomStockageFichierJoint = '';
		//	enregistrement
		require( 'includes/mySql.php' );
		$query = "INSERT into tblOffres (fonction,civilite,nom,prenom,eMail,tel,"
			. "entreprise,numeroRue,rue,CP,ville,"
			. "intitule,description,dateSent,fichierJoint)"
			. " values( '"
				. mysql_escape_string($laFonction) . "','"
				. $_POST['civilite'] . "','"
				. mysql_escape_string($leNom) . "','"
				. mysql_escape_string($lePrenom) . "','"
				. mysql_escape_string($leMail) . "','"
				. mysql_escape_string($leTel)  . "','"
				. mysql_escape_string($lEntreprise) . "','"
				. mysql_escape_string($leNumeroRue) . "','"
				. mysql_escape_string($laRue) . "','"
				. mysql_escape_string($leCP) . "','" 
				. mysql_escape_string($laVille) . "','"
				. mysql_escape_string($lIntitule) . "','"
				. mysql_escape_string($laDescription) . "',"
				. "CURDATE(),'"
				. mysql_escape_string( $nomStockageFichierJoint ) . "')";
		$res = mysql_query( $query ) or die( mysql_error() );
		if( $res )
			{
			$query = "INSERT into tblOffresCE (date,fichier,domaine,titre,suspendue)"
				. " values("
				. "CURDATE(),'"
				. $nomStockageFichierJoint . "',"
				. 1200000 . ",'"										// domaine "divers"
				. mysql_escape_string(  $lIntitule ) . "',"
				. 1														//	suspendue
			.  ")";
			$result = mysql_query( $query ) or die('<br>...'.$query.'<br>...'.mysql_error());
			if( isset( $nomStockageFichierJoint ) AND $nomStockageFichierJoint != '' )
				{
				$fichierJoint = $dossier . $nomStockageFichierJoint;
				move_uploaded_file( $_FILES['pjurl']['tmp_name'], $fichierJoint );
				$b = @unlink( $dossier . basename( $nomStockageFichierJoint1 ) );
				}
			$query = "SELECT id FROM tblOffres ORDER BY id DESC LIMIT 1";
			$res = mysql_query( $query );
			$line = mysql_fetch_array( $res );	// pb si deux requêtes simultanées!!!!
			$lId = $line[ 'id' ];

			$email = stripslashes( $_POST['email'] );
			$subject = "Offre d'emploi";	//stripslashes( $_POST['subject'] );
			$msg = "Message envoyé depuis site web CPE (" . date('d-m-y H:i:s') . "): \n";
			$msg .= '#' . $lId
					. '#' . $laFonction
					. '#' . $laCivilite
					. '#' . $lePrenom
					. '#' . $leNom
					. '#' . $leTel
					. "\n" . '#' . $lEntreprise
					. '#' . $leNumeroRue
					. '#' . $laRue
					. '#' . $leCP
					. '#' . $laVille
					. "\n" . '#' . $lIntitule
					. '#' . $laDescription;

			$res = true;
			$m->errNum = 0;
		
			$m->Subject( "$subject" );
		
			$res = $m->From( "$email" );
			$m->To( $dest );
			}
		}
	if( $res )
		{ 
		$m->Body( $msg );
	//	if( strlen(  $_FILES['pjurl']['name'] ) )
		if( isset(  $fichierJoint ) )
			{
			if( $_FILES['pjurl']['size'] > $_POST['MAX_FILE_SIZE']
				|| $_FILES['pjurl']['size'] == 0 )
				{
				$res = false;
				$m->errNum = ERR_TAILLE_PJ;
				}
			else	
	//			$m->Attach( $_FILES['pjurl']['tmp_name'],  $_FILES['pjurl']['name'], "application/octet-stream" );
				$m->Attach( $fichierJoint,  $_FILES['pjurl']['name'], "application/octet-stream" );
			}
		}

	if( $res )
		{
		$res = $m->Send();
		if( !$res )
			{	//	dans ce cas : mettre datesent à null
			$query = "UPDATE tblOffres SET dateSent=null"
				. " WHERE id=" . $lId;
			mysql_query( $query );
			}
		}
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
			&nbsp;>&nbsp;
<?php
//	echo 	"<a href=\"contactSaisieCEPL.php?destinataire=" . $_POST['destinataire'] . "\">Saisie</a>";
	echo 	"<a href=\"contactSaisieCEPL.php\">Saisie</a>";
	echo 	"&nbsp;>&nbsp;";

	if( $res )
		{
		echo "confirmation envoi</div>";
		echo '<p style="font-weight:bold;font-size:1.2em;color:red;">Votre message a été envoyé.</p>';
		echo '<p>Nous le traiterons dans les meilleurs délais</p>';
		}
	else
		{
		echo "erreur</div>";
		echo '<p style="font-weight:bold;font-size:1.2em;color:red;">Votre message n\'a pas été envoyé</p>';
		echo '<p>Veuillez retourner à la saisie et corriger l\'erreur indiquée ci-dessous</p>';
		switch( $m->errNum )
			{
			case ERR_FONCTION_MAIL :		//	erreur fonction email
				echo "<p><b>Le service est actuellement indisponible. Merci de réessayer dans quelques temps.</b></p>";
				echo "<p>Si l'erreur persiste : adressez un courriel à webmestrer@cadrentreprise.asso.fr.</p>";
				break;
			case ERR_NOM :		//	nom invalide
				echo "<p><b>Votre nom (" . $m->errMsg . ") doit être saisi.</b></p>";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis saisissez votre nom.</li></ul>";
				break;
			case ERR_ADRESSE_INVALIDE :		//	adresse invalide
				echo "<p><b>Votre adresse mail (" . $m->errMsg . ") est invalide.</b></p>";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis saisissez une adresse email valide.</li></ul>";
				break;
			case ERR_ENTREPRISE_COURT :		//	nom entreprise trop court
				echo "<p><b>Le nom de l(entreprise doit comporter au moins 3 caractères.</b></p>";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis saisissez un nom d'entreprise de 3 caractères au moins.</li></ul>";
				break;
			case ERR_INTITULE_COURT :		//	intitule offre trop court
				echo "<p><b>L'intitulé de l'offre doit comporter au moins 10 caractères.</b></p>";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis saisissez un intitulé de 10 caractères au moins.</li></ul>";
				break;
			case ERR_DESCRIPTION_COURT :		//	description offre trop court
				echo "<p><b>La description de l'offre doit comporter au moins 10 caractères.</b></p>";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis saisissez une description de 10 caractères au moins.</li></ul>";
				break;
			case ERR_TAILLE_PJ :		//	pièce jointe trop grosse
				echo "<p><b>Votre pièce jointe dépasse la taille maximum autorisée ("
					. $_POST['MAX_FILE_SIZE'] . " octets).</b></p>";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis choisissez une pièce jointe de taille adaptée.</li></ul>";
				break;
			case ERR_CAPTCHA :		//	captcha non conforme
				echo "<p><b>Code saisi non conforme.</b>";
				echo "<ul><li>Cliquez le bouton Retour saisie</li>";
				echo "<li>puis recopiez le code obligatoire (mesure antispam)</li></ul>";
				break;
			default :
				echo "<p><b>Erreur inconnue " . $m->errNum . "</b></p>";
				break;
			}
		}
	}

?>
	<a href="javascript:close('contact')">
		<img src="images/btnRetour.gif" border="0" />
	</a>
<?php
	if( !$res )
		{
		$lesParams = 'fonction=' . rawurlencode($_POST['fonction'])
			. '&civilite=' . rawurlencode($_POST['civilite'])
			. '&nom=' . rawurlencode($_POST['nom'])
			. '&prenom=' . rawurlencode($_POST['prenom'])
			. '&tel=' . rawurlencode($_POST['tel'])
			. '&entreprise=' . rawurlencode($_POST['entreprise'])
			. '&numeroRue=' . rawurlencode($_POST['numeroRue'])
			. '&rue=' . rawurlencode($_POST['rue'])
			. '&CP=' . rawurlencode($_POST['CP'])
			. '&ville=' . rawurlencode($_POST['ville'])
			. '&intitule=' . rawurlencode($_POST['intitule'])
			. '&description=' . rawurlencode($_POST['description'])
			. '&email=' . rawurlencode($_POST['email']);
		echo 	'<a href="contactSaisieCEPL.php?'
					. htmlentities( $lesParams )
					. '" style="padding-left:100px">';
		echo 	'<img src="images/btnRetourSaisie.gif" border="0" />';
		echo "</a>";
		}
?>
	</body>
</html>

