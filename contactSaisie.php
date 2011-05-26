<?php
$cryptinstall ="./crypt/cryptographp.fct.php";
include $cryptinstall;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>CPE - saisie contact</title>
		<meta name="robots" content="noindex,nofollow" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<style type="text/css">
			em {color:red; font-style:normal; text-decoration:bold;}
		</style>
	</head>
	<body id="global2" style="padding-top:0.5em;">
		<div id="header2">
			<img src="images/logo50.gif" alt="logo CPE" />
			<p>Cadres pour l'Entreprise</p>
		</div>
		<div id="cdeFer">
			<a href="contact.php">Contact</a>
			&nbsp;&gt;&nbsp;Saisie
		</div>

		<form  id="mail" action="contactEnvoi.php" method="post"
			enctype="multipart/form-data">
<?php
if( isset( $_GET[ 'cci' ] ) )
	echo '<input type="hidden" name="cci" value="' . $_GET[ 'cci' ] . '">';
if( isset( $_GET[ 'ro' ] ) )
	echo '<input type="hidden" name="ro" value="' . $_GET[ 'ro' ] . '">';
			echo '<table border="0" cellspacing="0" cellpadding="0">';
			echo 	'<colgroup width="110px"></colgroup><colgroup width="145px"></colgroup>';
			echo 	'<tr><td colspan="2" style="border:none;">&nbsp;</td></tr>';
			echo 	'<tr><td><p>Destinataire</p></td>';
			$dest = "";
			switch( $_GET['destinataire'] )
				{
				case "I" :
					$dest = 'demande d\'informations';
					break;
				case "CEmpl" :
					$dest = "la Commission Emploi";
					break;
				case "W" :
					$dest = "le Webmestre";
					break;
				default :
					$dest = $_GET['destinataire'];
				}
			echo '<td>';
			if( $dest == '?' )
				echo '&nbsp;<input type="text" name="destinataire" size="40" />';
			else
				echo $dest . '<input type="hidden" value="' . $_GET['destinataire']
					. '" name="destinataire" />';
			echo 		"</td></tr>";

			echo 	'<tr><td>Expéditeur';
			if( !isset( $_GET[ 'ro' ] ) )
				echo '<em>*</em> (adresse mail pour réponse)';
			echo	'</td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET[ 'email' ] ) )
				{
				echo $_GET[ 'email' ];
				echo '<input type="hidden" name="email" value="'
					. $_GET[ 'email' ] . '" />';
				}
			else
				echo '<input type="text" size="40" name="email" title="saisissez votre adresse e-mail" />';
			echo 	'</td></tr>';
			//	objet
			echo 	'<tr><td>Objet';
			if( !isset( $_GET[ 'ro' ] ) )
				echo		'<em>*</em>';
			echo		'</td>';
			echo 		'<td style="border:none;">';
			echo 			'<input name="subject" title='
				.				'"saisissez l\'objet de votre message (10 caractères au moins)" '
				.				'size="40"';			
			if( isset( $_GET[ 'subject' ] ) )
				$m = htmlentities( stripcslashes( stripcslashes( $_GET[ 'subject' ] ) ), ENT_QUOTES, "UTF-8" );
			else
				$m = '';
			if( !isset( $_GET[ 'ro' ] ) )
				echo			' type="text" value="' . $m . '" />' . $m;
			else
				echo			' type="hidden" value="' . $m . '" />' . $m;

			echo 	'</td></tr>';
			//	corps du message
			echo 	'<tr><td>Message';
			if( !isset( $_GET[ 'ro' ] ) )
				echo	'<em>*</em>';
			echo	'</td>';
			echo 	'<td style="border:none;">';
			if( isset( $_GET[ 'msg' ] ) )
				$m = stripcslashes( stripcslashes( $_GET[ 'msg' ] ) );
			else
				$m = '';
			if( !isset( $_GET[ 'ro' ] ) )
				{
				echo		'<textarea rows="12" name="msg" cols="40" title="'
								. 'saisissez le texte de votre message (10 caractères au moins)">';
				echo			$m;
				echo		'</textarea>';
				}
			else
				{
				echo		'<textarea rows="12" name="msg" cols="40" readonly="readonly" title="'
								. 'saisissez le texte de votre message (10 caractères au moins)">';
				echo			$m;
				echo		'</textarea>';
				}
			echo 	'</td></tr>';
			
			echo 	'<tr><td>Fichier à joindre au message (facultatif)</td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET[ 'piecesJointesN' ] ) )
				{
				echo '<input type="hidden" name="piecesJointesN" value="' . $_GET[ 'piecesJointesN' ] . '" />';
				echo $_GET[ 'piecesJointesN' ];
				}
			else
				{
				echo			'<input type="hidden" name="MAX_FILE_SIZE" value="400000" />';
				echo			'<input type="file" src="images/btnParcourir.gif" '
									. 'size="40" name="pjurl" maxlength="400000" '
									. 'title="choisissez (optionnel) un fichier à joindre au message" />';
				}
			echo 	'</td></tr>';
			echo 	'<tr><td>Recopiez le code ci-contre<em>*</em><br />(mesure antispam)</td>';
			echo 	'<td style="border:none;"><table><tr><td style="border:none;padding-top:5px;">';
			dsp_crypt(0,1);
			echo 		'</td>';
			echo 		'<td style="border:none;"><input type="text" name="code" /></td></tr></table>'; 
			echo 	'</td></tr>';
			echo '</table>';
?>
			<div style="margin:20px 0 0px 0px;clear:both;">
				<a href="javascript:close('contact')">
					<img src="images/btnAnnuler.gif" alt="Annuler" />
				</a>
				<input type="image" value="Envoyer" src="images/btnValider.gif" alt="Valider" />
			</div>
		</form>
	</body>
</html>