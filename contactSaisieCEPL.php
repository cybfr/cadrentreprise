<?php
$cryptinstall ="./crypt/cryptographp.fct.php";
include $cryptinstall;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN" "http://www.w3.org/YT/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="HTTP://WWW.W3.ORG/1999/XHTML" xml:lang="FR" lang="FR">
	<head>
		<title>CPE - saisie contact Offre d'emploi</title>
		<meta name="robots" content="noindex,nofollow">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" HREF="css/style.css">
		<style>
			em {color:red; font-style:normal; text-decoration:bold;}
		</style>
	</head>
	<body id="global2" style="padding-top:0.5em;">
		<div id="header2">
			<img src="images/logo50.gif" alt="logo CPE" />
			<p>Cadres pour l'Entreprise</p>
		</div>
		<div id="cdeFer">
			<a href="contact.php">Contact Offre</a>
			&nbsp;>&nbsp;Saisie
		</div>

<!-- Contenu -->
		<form  id="mail" action="contactEnvoiCEPL.php" method="post"
			enctype="multipart/form-data" name="form">
<?php
			echo '<table border="0" cellspacing="0" cellpadding="0">';
			echo 	'<colgroup width="110px"><colgroup width="145px">';
			//echo 	'<tr><td colspan="2" style="border:none;">&nbsp;</td></tr>';
			echo	'<tr><td colspan="2"><div style="font-size:0.8em;color:green;">'
						. 'Vous souhaitez nous communiquer une offre d\'emploi, nous vous en remercions.'
						. '<br>Pour nous permettre de traiter votre offre dans les meilleurs délais, veuillez nous préciser les informations suivantes.</div>'
						. '</td></tr>';
			echo '<td><tr><td colspan="2" style="background-color:#66ee66;">Vos coordonnées</td></tr>';
			//	fonction
			echo 	'<tr><td style="text-align:right;padding-right:5px;">Fonction</td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET['fonction'] ) )
				$laFonction = stripslashes( $_GET['fonction'] );
			else
				$laFonction = "";
			echo			'<input type="text" value="' . $laFonction;
			echo 				'" name="fonction" title='
									. '"saisissez votre fonction" '
									. 'size="40">';
			echo 	'</td></tr>';
			// civilité
			echo 	'<tr><td style="text-align:right;padding-right:5px;">Civilité<em>*</em></td>';
			echo 		'<td style="border:none;">';
			$civilites = array( "Madame", "Mademoiselle", "Monsieur" );
			$civil = array( "Mme", "Mlle", "M" );
			if( isset( $_GET['civilite'] ) )
				$laCivilite = stripslashes( $_GET['civilite'] );
			else
				$laCivilite = "Mme";
			foreach( $civilites as $k=>$v )
				{
				echo		'<input type="radio" value="' . $civil[$k];
				echo 			'" name="civilite" title="choisissez Mme, Mlle ou M" ';
				if( $laCivilite == $civil[$k] )
					echo ' checked="true"';
				echo				'>' . $civilites[$k];
				}
			echo 	'</td></tr>';
			//	Prénom
			echo 	'<tr><td style="text-align:right;padding-right:5px;">Prénom</td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET['prenom'] ) )
				$lePrenom = stripslashes( $_GET['prenom'] );
			else
				$lePrenom = "";
			echo			'<input type="text" value="' . $lePrenom;
			echo 				'" name="prenom" title='
									. '"saisissez votre prénom" '
									. 'size="40">';
			echo 	'</td></tr>';
			//	Nom
			echo 	'<tr><td style="text-align:right;padding-right:5px;">Nom<em>*</em></td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET['nom'] ) )
				$leNom = stripslashes( $_GET['nom'] );
			else
				$leNom = "";
			echo			'<input type="text" value="' . $leNom;
			echo 				'" name="nom" title='
									. '"saisissez votre nom" '
									. 'size="40">';
			echo 	'</td></tr>';
			echo 	'<tr><td style="text-align:right;padding-right:5px;">Téléphone</td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET['tel'] ) )
				$leTel = stripslashes( $_GET['tel'] );
			else
				$leTel = "";
			echo			'<input type="text" value="' . $leTel;
			echo 				'" name="tel" title='
									. '"saisissez un numéro de téléphone" '
									. 'size="40">';
			echo 	'</td></tr>';
			echo 	'<tr><td style="text-align:right;padding-right:5px;">email<em>*</em></td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET['email'] ) )
				$lEMail = stripslashes( $_GET['email'] );
			else
				$lEMail = "";
			echo 			'<input type="text" size="40" name="email" value="' . $lEMail . '" title="saisissez votre adresse e-mail" size="35">';
			echo 	'</td></tr>';
			//
			echo '<td><tr><td colspan="2" style="background-color:#66ee66;">Votre Entreprise, Administration...</td></tr>';
			//	Entreprise
			echo 	'<tr><td style="text-align:right;padding-right:5px;">Entreprise<em>*<br>(au moins 3 car.)</em></td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET['entreprise'] ) )
				$lEntreprise = stripslashes( $_GET['entreprise'] );
			else
				$lEntreprise = "";
			echo			'<input type="text" value="' . $lEntreprise;
			echo 				'" name="entreprise" title='
									. '"saisissez le nom de votre entreprise" '
									. 'size="40">';
			echo 	'</td></tr>';
			echo 	'<tr><td style="text-align:right;padding-right:5px;">numéro rue</td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET['numeroRue'] ) )
				$leNumeroRue = stripslashes( $_GET['numeroRue'] );
			else
				$leNumeroRue = "";
			echo			'<input type="text" value="' . $leNumeroRue;
			echo 				'" name="numeroRue" title='
									. '"saisissez le numéro dans la rue" '
									. 'size="40">';
			echo 	'</td></tr>';
			echo 	'<tr><td style="text-align:right;padding-right:5px;">voie (rue, bvrd...)</td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET['rue'] ) )
				$laRue = stripslashes( $_GET['rue'] );
			else
				$laRue = "";
			echo			'<input type="text" value="' . $laRue;
			echo 				'" name="rue" title='
									. '"saisissez la rue (bvrd, place...)" '
									. 'size="40">';
			echo 	'</td></tr>';
			echo 	'<tr><td style="text-align:right;padding-right:5px;">Code Postal</td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET['CP'] ) )
				$leCP = stripslashes( $_GET['CP'] );
			else
				$leCP = "";
			echo			'<input type="text" value="' . $leCP;
			echo 				'" name="CP" title='
									. '"saisissez le code postal" '
									. 'size="40">';
			echo 	'</td></tr>';
			echo 	'<tr><td style="text-align:right;padding-right:5px;">ville</td>';
			echo 		'<td style="border:none;">';
			if( isset( $_GET['ville'] ) )
				$laVille = stripslashes( $_GET['ville'] );
			else
				$laVille = "";
			echo			'<input type="text" value="' . $laVille;
			echo 				'" name="ville" title='
									. '"saisissez la ville" '
									. 'size="40">';
			echo 	'</td></tr>';
			//
			echo '<td><tr><td colspan="2" style="background-color:#66ee66;">L\'offre d\'emploi</td></tr>';
			//	intitulé
			echo 	'<tr><td style="text-align:right;padding-right:5px;">Intitulé<em>*<br>(au moins 10 caractères)</em></td>';
			echo 	'<td style="border:none;">';
			if( isset( $_GET['intitule'] ) )
				$lIntitule = stripslashes( $_GET['intitule'] );
			else
				$lIntitule = "";
			echo			'<input type="text" value="' . $lIntitule;
			echo 				'" name="intitule" title='
									. '"saisissez l\'intitulé du poste proposé" '
									. 'size="40">';
			echo 	'</td></tr>';
			//	description
			echo 	'<tr><td style="text-align:right;padding-right:5px;">Description<em>*<br>(au moins 10 caractères)</em></td>';
			echo 	'<td style="border:none;">';
			if( isset( $_GET['description'] ) )
				$laDescription = stripslashes( $_GET['description'] );
			else
				$laDescription = "";
			echo		'<textarea rows="12" name="description" cols="40" title="'
							. 'saisissez la description du poste proposé">';
			echo		$laDescription;
			echo		'</textarea>';
			echo 	'</td></tr>';

			echo 	'<tr><td style="text-align:right;padding-right:5px;">Fichier à joindre au message</td>';
			echo 		'<td style="border:none;">';
			echo			'<input type="hidden" name="MAX_FILE_SIZE" value="400000" />';
			echo			'<input type="file" src="images/btnParcourir.gif" '
								. 'size="40" name="pjurl" maxlength="400000" '
								. 'title="choisissez (optionnel) un fichier à joindre au message" />';
			echo 	'</td></tr>';
// antispam
			echo '<td><tr><td colspan="2" style="background-color:#66ee66;">Protection contre les spams</td></tr>';
			echo 	'<tr><td style="text-align:right;padding-right:5px;">Recopiez le code ci-contre<em>*</em></td>';
			echo 		'<td style="border:none;"><table><tr><td style="border:none;padding-top:5px;">'; dsp_crypt(0,1) . '</td>';
			echo 		'<td style="border:none;"><input type="text" name="code"></td></tr></table>'; 
			echo 	'</td></tr>';
			echo '</table>';
?>
			<div style="margin:20px 0 0px 0px;clear:both;">
				<a href="javascript:close('contact')">
					<img src="images/btnAnnuler.gif" border="0">
				</a>
				<input type="image" value="Envoyer" src="images/btnValider.gif">
			</div>
		</form>
	</div>
	</body>
</html>