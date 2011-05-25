<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN" "http://www.w3.org/YT/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="HTTP://WWW.W3.ORG/1999/XHTML" xml:lang="FR" lang="FR">
	<head>
		<title>CPE - Cadres pour l'entreprise - identification</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" HREF="css/style.css">
	</head>
	<body id="global2" style="padding-top:2em;">
		<div id="header2">
			<img src="../images/logo50.gif" alt="logo CPE" />
			<p>Cadres pour l'Entreprise
				<span style="float:right;">
				</span>
			</p>
		</div>
		<div id="cdeFer">
<?php
echo '<div style="visibility:hidden;"></div>';
			echo 'Accès Espaces Privés';
?>
		</div>
		<p>&nbsp;</p>
<?php
require_once "includes/mySql.php";
$leLogin = $_GET[ 'login' ];

function ValidEmail( $addresse )
	{
	if( ereg( ".*<(.+)>", $addresse, $regs ) )
		$addresse = $regs[1];

	if( !ereg( "^[^@  ]+@([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9\-]{2}|net|com|gov|mil|org|edu|int)\$",$addresse ) )
		return false;
	return true;	}

if( !isset( $_GET['confirmation'] ) )
	{	// confirmation
	echo '<h2>Vous demandez le renouvellement de votre mot de passe</h2>';
	echo '<p>Veuillez confirmer cette demande en cliquant "Valider" ci-dessous</p>';
	echo '<form name="leF" action="identification4.php" method="get" name="form">';
	echo	'<input type="hidden" name="login" value="' . $leLogin . '">';
	echo	'<input type="hidden" name="confirmation" value="OK">';
	echo	'<input type="image" value="Envoyer" src="images/btnValider.gif">';
	echo '</form>';
	echo '<a href="index.php">';
	echo	'<img src="images/btnAnnuler.gif">';
	echo '</a>';
	}
else
	{
	//	récup adresse courriel
	$query = "SELECT eMail FROM tblMdp, tblAdherents"
		. " WHERE login='" . $leLogin . "'"
			. " AND tblMdp.idAdherent = tblAdherents.id";
	$result = mysql_query( $query );
	
	if( $result === false OR mysql_num_rows( $result) != 1 )
		{
		echo '<h2>Erreur identifiant</h2>';
		exit;
		}
	$line = mysql_fetch_array( $result );
	$lEMail = validEmail( $line['eMail'] );
	if( $lEMail === false )
		{
		echo "adresse courriel invalide.";
		echo "Veuillez contacter le secrétariat.";
		}
	else
		{
		$lEMail = $line[ 'eMail' ];
		//	régénération Mdp
		require_once "includes/genereNouveauMdP.php";
		$query = "UPDATE tblMdp"
			. " SET mdp='" . $leMdp . "'"
			. " WHERE login='" . $leLogin . "'";
		$result = mysql_query( $query );
		//	régénération du fichier .htPasswd
		require_once( "includes/genereHtPasswd.php" );
		//	envoi mail
		$leMess = 'Pour répondre à votre demande, votre mot de passe d\'accès aux sites privés CPE a été modifié.';
		$leMess .= '<p>Mot de passe : ' . $leMdp . '</p>';
		$leMess .= '<p>Votre identifiant est inchangé.</p>';
		
		$leMess .= '<h2>Sécurité...Sécurité...Sécurité...Sécurité...</h2>';
		$leMess .= '<p>Ce nom d\'utilisateur et ce mot de passe vous sont attribués à titre personnel.</p>';
		$leMess .= '<p>Pour assurer la confidentialité des données, il est nécessaire de respecter scrupuleusement les précautions suivantes :</p>';
		$leMess .= '<ul>';
		$leMess .= '<li><b>Ne communiquez à personne votre mot de passe</b>';
		$leMess .= '<p style="margin-top:0px;margin-bottom:0px;">Si vous pensez que quelqu\'un dispose de votre mot de passe, demandez immédiatement son renouvellement (cliquez "espaces publics", saisissez votre identifiant puis cliquez "mot de passe oublié").</p>';
		$leMess .= '</li>';
		$leMess .= '<li>Ne sauvegardez pas le mot de passe lorsque le navigateur vous le propose.</li>';
		$leMess .= '<li>Lorsque vous avez terminé une session de travail :';
		$leMess .= '<ol><li>cliquez sur "Déconnexion" (en haut à droite)</li><li>quittez votre navigateur (Fichier > Quitter)</li></ol></li>';
		$leMess .= '<li>Evitez d\'utiliser un micro ordinateur accessible par plusieurs personnes. Si vous ne pouvez faire autrement, appliquez tout particulièrement les précautions indiquées ci-dessus.</li>';
		$leMess .= '</ul>';		
		$leMess .= '<p style="margin-top:2em;">Pour toute question, adressez-vous au webmestre CPE (de préférence par courriel)</p>';
	
		$leHeader = "Content-Type: text/html; charset=utf-8\n";
		$res = mail( $lEMail, 'CPE - votre demande', $leMess, $leHeader );
		if( !$res )
			{	
			echo '<h2>courriel de confirmation pas envoyé</h2>';
			echo "<p>Merci de réessayer dans quelques instants</p>";
			echo '<p>Après plusieurs essais infructueux, veuillez prévenir le Webmestre.</p>';
			}
		else
{
			echo '<h2>Mot de passe modifié, courriel de confirmation envoyé</h2>';
if( $_SERVER['HTTP_HOST'] == 'cadrentreprise.free.fr' )
	{
	$nomPage = "RenouveltMdp/" . $leLogin;
?>
	<div style="margin:0px;padding:0px;height:1px;">
	<!-- phpmyvisites -->
	<a href="http://st.free.fr/" title="phpMyVisites | Open source web analytics" 
	onclick="window.open(this.href);return(false);"><script type="text/javascript">
	<!--
	var a_vars = Array();
	<?php
	echo "var pagename='" . $nomPage . "'\n";
	?>
	var phpmyvisitesSite = 41478;
	var phpmyvisitesURL = "http://st.free.fr/phpmyvisites.php";
	//-->
	</script>
	<script language="javascript" src="http://st.free.fr/phpmyvisites.js" type="text/javascript"></script>
	<object><noscript><p>phpMyVisites | Open source web analytics
	<img src="http://st.free.fr/phpmyvisites.php" alt="Statistics" style="border:0" />
	</p></noscript></object></a>
	</div>
	<!-- /phpmyvisites --> 
<?php
	}
}
		}

	echo '<a href="index.php">';
	echo	'<img src="../images/btnRetour.gif">';
	echo '</a>';
	}
?>
	</body>
</html>
