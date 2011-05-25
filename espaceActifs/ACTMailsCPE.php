<?php
require '../includes/librairie.php';
require '../includes/librairieMail.php';
require 'includes/librairie.php';
require '../includes/mySql.php';

//	paramètres définissant mails types
$mailsTypesLabels = array( 
	'Relance Salon', 
	'Relance Opération Terrain',
	'Relance Autre'
	);

$mailsTypesObjets = array(
	'Notre récente rencontre',
	'Notre récente rencontre',
	'Recrutement' );
	
$mailsTypesContenus = array( 
	'#civilite#,' . "\n\n" . 'Nous tenons à vous remercier pour votre aimable accueil lors du salon #salon# le #dateRencontre# et lors de notre récent entretien téléphonique.'
		. "\n\n" . 'Comme nous vous l\'avons indiqué "CADRES POUR L\'ENTREPRISE" est une association, vivier de cadres expérimentés - tous métiers, tous secteurs d\'activités - disponibles et offrant des compétences adaptées pour des missions, CDD ou CDI.'
		. "\n" . 'Sur notre site http://cadrentreprise.asso.fr vous trouverez la liste actualisée et détaillée de ces compétences classées par fonctions.'
		. "\n\n" . 'En cliquant sur le profil susceptible de vous intéresser, vous obtiendrez les coordonnées du cadre recherché que vous pourrez alors contacter directement.'
		. "\n\n" . 'Nous vous proposons également de nous contacter directement pour toute recherche de compétences en nous adressant un courriel. Pour cela il vous suffit de cliquer sur "contact".'
		. "\n\n" . 'Ces mises en relation se font sans aucune contrepartie financière. Nous sommes une association de bénévoles, animés par la volonté de faire se rencontrer les entreprises et nos adhérents.'
		. "\n\n" . 'Nous sommes heureux de joindre à ce message la plaquette de notre association.'
		. "\n\n" . 'Nous restons à votre écoute et vous adressons, #civilite#, nos plus cordiales salutations.'
		. "\n\n" . '#nomAdherent#'
		. "\n\n" . 'Cadres Pour l\'Entreprise'
		. "\n" . '6, rue Albert de Lapparent'
		. "\n" . '75007 Paris'
		. "\n" . 'tél : 01 45 67 33 38'
		. "\n" . 'web : www.cadrentreprise.asso.fr',
	'#civilite#,' . "\n\n" . 'Nous tenons à vous remercier pour votre aimable accueil lors de notre passage en vos locaux le #dateRencontre# et lors de notre récent entretien téléphonique.'
		. "\n\n" . 'Comme nous vous l\'avons indiqué "CADRES POUR L\'ENTREPRISE" est une association, vivier de cadres expérimentés - tous métiers, tous secteurs d\'activités - disponibles et offrant des compétences adaptées pour des missions, CDD ou CDI.'
		. "\n" . 'Sur notre site http://cadrentreprise.asso.fr vous trouverez la liste actualisée et détaillée de ces compétences classées par fonctions.'
		. "\n\n" . 'En cliquant sur le profil susceptible de vous intéresser, vous obtiendrez les coordonnées du cadre recherché que vous pourrez alors contacter directement.'
		. "\n\n" . 'Nous vous proposons également de nous contacter directement pour toute recherche de compétences en nous adressant un courriel. Pour cela il vous suffit de cliquer sur "contact".'
		. "\n\n" . 'Ces mises en relation se font sans aucune contrepartie financière. Nous sommes une association de bénévoles, animés par la volonté de faire se rencontrer les entreprises et nos adhérents.'
		. "\n\n" . 'Nous sommes heureux de joindre à ce message la plaquette de notre association.'
		. "\n\n" . 'Nous restons à votre écoute et vous adressons, #civilite#, nos plus cordiales salutations.'
		. "\n\n" . '#nomAdherent#'
		. "\n\n" . 'Cadres Pour l\'Entreprise'
		. "\n" . '6, rue Albert de Lapparent'
		. "\n" . '75007 Paris'
		. "\n" . 'tél : 01 45 67 33 38'
		. "\n" . 'web : www.cadrentreprise.asso.fr',
	'#civilite#,' . "\n\n" . '#prescripteur# m\'a aimablement écouté #circonstances# et m\'a recommandé de vous contacter.'
		. "\n\n" . 'Garder un lien direct avec les entreprises est une des spécificités de l’Association Cadres pour l\’Entreprise.'
		. "\n\n" . 'Vous trouverez en pièce jointe une présentation des avantages que nous vous apportons en matière de recrutement rapide de cadres expérimentés.'
		. "\n\n" . 'Vous avez un accès simple et direct aux compétences des adhérents sur le site de l’association à l\'adresse http://cadrentreprise.asso.fr.'
		. "\n\n" . 'En vous remerciant de l\’accueil que vous réserverez à ce courrier, je vous prie d\’agréer, #civilite# l’expression de ma considération distinguée.'
		. "\n\n" . '#nomAdherent#'
		. "\n\n" . 'Cadres Pour l\'Entreprise'
		. "\n" . '6, rue Albert de Lapparent'
		. "\n" . '75007 Paris'
		. "\n" . 'tél : 01 45 67 33 38'
		. "\n" . 'web : www.cadrentreprise.asso.fr'
	);

$mailsTypesCci = array(
	'philippe.ricour@cadrentreprise.asso.fr',
	'francois.lindet@cadrentreprise.asso.fr',
	'webmaster@cadrentreprise.asso.fr'
	);
//	les pj doivent être dans espaceActifs/bibliotheque ......................
$mailsTypesPiecesJointes = array(
	array( 'tractEntreprises.pdf'  ),
	array( 'tractEntreprises.pdf' ),
	array( )
	);

$login = getLogin();
if( $login == 'croy' )
	{	//	pour mise au point
	$mailsTypesLabels[] = 'message test';
	$mailsTypesObjets[] = 'Objet message test';
	$mailsTypesContenus[] = 'Contenu message test #dateRencontre#';
	$mailsTypesCci[] = 'pourmeslistes@orange.fr';
	$mailsTypesPiecesJointes[] = array( 'tractEntreprises.pdf', 'tractEntreprises.pdf' );
	}
						$query = "SELECT concat(A.prenom, ' ', A.nom) as np, email"
							. " FROM tblAdherents AS A, tblMdp AS M"
							. " WHERE login='" . $login . "'"
								. " AND M.idAdherent = A.id";
						$result = mysql_query( $query ) or die( '<br>...'.$query.'<br>...'.mysql_error());
						$l = mysql_fetch_assoc( $result );
						$nomEmetteur = $l[ 'np' ];
						$emailEmetteur = $l[ 'email' ];
						
$typeMail = $civilite = 0;
$adrCible = $salon = $dateRencontre = $prescripteur = $circonstances = '';
if( isset( $_POST[ 'typeMail' ] ) )
	{
	$typeMail = $_POST[ 'typeMail' ];
	$civilite = $_POST[ 'civilite' ];
	$adrCible = $_POST[ 'adrCible' ];
	if( isset( $_POST[ 'salon' ] ) ) $salon = $_POST[ 'salon' ];
	if( isset( $_POST[ 'dateRencontre' ] ) ) $dateRencontre = $_POST[ 'dateRencontre' ];
	else $dateRencontre = 0;
	if( isset( $_POST[ 'prescripteur' ] ) )
		$prescripteur = $_POST[ 'prescripteur' ];
	else $prescripteur = '';
	if( isset( $_POST[ 'circonstances' ] ) ) $circonstances = $_POST[ 'circonstances' ]; else $circonstances = '';
	}
elseif( isset( $_GET[ 'typeMail' ] ) )
	{
	$typeMail = $_GET[ 'typeMail' ];
	$civilite = $_GET[ 'civilite' ];
	$adrCible = $_GET[ 'adrCible' ];
	$salon = $_GET[ 'salon' ];
	if( isset( $_GET[ 'dateRencontre' ] ) )
		$dateRencontre = $_GET[ 'dateRencontre' ];
	if( isset( $_GET[ 'prescripteur' ] ) )
		$prescripteur = $_GET[ 'prescripteur' ];
	if( isset( $_GET[ 'circonstances' ] ) )
		$circonstances = $_GET[ 'circonstances' ];
	}
else
	{
	$typeMail = 0;
	$civilite = 0;
	$adrCible = '';
	$salon = '';
	$dateRencontre = $prescripteur = $circonstances = '';
	}
if( !isset( $salon ) ) $salon = '';
else $salon = stripcslashes( $salon );
$prescripteur = stripcslashes( $prescripteur );
$circonstances = stripcslashes( $circonstances );

function zonesVariables( $texteSource, $colorer, $nomEmetteur )
	{	
	$tokens = explode( '#', $texteSource );
	$texteObjet = '';
	foreach( $tokens as $k=>$v )
		{
		if( $k % 2 == 1 )
			{	//	impair --> c'est une valeur à substituer
			if( isset( $_POST[ $v ] ) )
				$v = $_POST[ $v ];
			else
				{
				switch( $v ) 
					{
					case 'nomAdherent' :
						$v = $nomEmetteur;
						break;
					default :
						$v = '???' . $v . '???';
						break;
					}
				}
			}
		if( $colorer AND $k % 2 == 1 )
			$texteObjet .= '<span style="color:red;">' . $v . '</span>';
		else
			$texteObjet .= $v;
		}
	return $texteObjet;
	}
$sujet = $mailsTypesObjets[ $typeMail ];
$message = zonesVariables( $mailsTypesContenus[ $typeMail ], !isset( $_POST[ 'action' ] ), $nomEmetteur );
	
if( !isset( $_POST[ 'action' ] ) )
	{	//	formulaire
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN" "http://www.w3.org/YT/xhtml1/DTD/xhtml1-strict.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">';
	echo '<head>';
	echo '<title>CPE Actifs Mails CPE</title>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo '<!-- <script language="javascript" src="../check.js" type="text/javascript"></script> -->';
	echo '</head>';

	require 'includes/ACTenTetes.php';

	echo	'<div id="global">';
	echo	'<h1>Envoi d\'un mail CPE</h1>';
	//	Formulaire choix mail type et paramètres
	echo		'<form name="leF" action="ACTMailsCPE.php" method="post">';
	echo			'<table border="0">';
	echo				'<tr><td><table>';
	echo					'<tr>';
	echo						'<td width=35%" style="text-align:right">';
	echo							'Courriel type à envoyer';
	echo						'</td>';
	echo						'<td width="65%" style="text-align:left">';
	echo							'<select name="typeMail" onchange="this.form.submit()">';
	foreach( $mailsTypesLabels as $k=>$v )
		{
		echo							'<option value="' . $k . '"';
		if( $typeMail == $k )
			echo							' selected="selected"';
		echo								'>' . $v . '</option>';
		}
	echo							'</select>';
	echo						'</td>';
	echo					'</tr><tr><td>&nbsp;</td></tr>';
	echo					'</tr><tr>';
	echo						'<td width="35%" style="text-align:right">';
	echo							'civilité destinataire';
	echo						'</td>';
	echo						'<td width="65%">';
	echo							'<select name="civilite" id="civilité" onchange="this.form.submit()">';
	$libs = array( 'Messieurs', 'Madame', 'Mademoiselle', 'Monsieur' );
	foreach( $libs as $k=>$v )
		{
		echo							'<option value="' . $v . '"';
		if( $v == $civilite )
			echo							' selected="selected"';
		echo								' >' . $v . '</option>';
		}
	echo							'</select></td>';
	echo					'</tr><tr>';
	echo						'<td style="text-align:right">adresse mail destinataire</td>';
	echo						'<td><input type="text" id="adrCible" name="adrCible" value="' . $adrCible . '"  onchange="this.form.submit()"></td>';
	switch( $typeMail )
		{
		case 0 :		//	relance salon
			echo			'</tr><tr>';
			echo				'<td style="text-align:right">salon</td>';
			echo				'<td><input type="text" id="salon" name="salon" value="' . $salon . '"  onchange="this.form.submit()"></td>';
			echo			'</tr><tr>';
			echo				'<td style="text-align:right">date rencontre salon</td>';
			echo				'<td><input type="text" id="dateRencontre" name="dateRencontre" value="' . $dateRencontre
				.					'"  onchange="this.form.submit()"></td>';
			echo			'</tr><tr><td>&nbsp;</td></tr>';
			break;
		case 1 :		//	relance opération terrain
			echo			'</tr><tr>';
			echo				'<td style="text-align:right">date rencontre terrain</td>';
			echo				'<td><input type="text" id="dateRencontre" name="dateRencontre" value="' . $dateRencontre
				.					'" onchange="this.form.submit()"></td>';
			echo			'</tr><tr><td>&nbsp;</td></tr>';
			break;
		case 2 :
			echo			'</tr><tr>';
			echo				'<td style="text-align:right">prescripteur</td>';
			echo				'<td><input type="text" id="prescripteur" name="prescripteur" value="' . $prescripteur
				.					'" onchange="this.form.submit()"></td>';
			echo			'</tr><tr>';
			echo				'<td style="text-align:right">circonstances</td>';
			echo				'<td><input type="text" id="circonstances" name="circonstances" value="' . $circonstances
				.					'" onchange="this.form.submit()"></td></tr>';
		default :
			echo			'</tr>';
			break;
		}
	echo			'</table></td><td id="message">';
	echo				'<span style="color:grey;font-style:italic">Ci-dessous le message en préparation.';
	echo					'<br>Les parties que vous saisissez sont en rouge (elles ne le pas dans le message final).';
	echo					'<br>Ajustez son contenu avant envoi.<br><br></span>';
	if( isset( $_POST[ 'adrCible' ] ) AND $_POST[ 'adrCible' ] != '' )
		$lAdresse = $_POST[ 'adrCible' ];
	else
		$lAdresse = '???destinataire???';
	echo				'destinataire : <span style="color:red;">' . $lAdresse . '</span>';
	echo				'<br /><br />objet : <span style="color:red;">' . nl2br( $sujet ) . '</span>';
	echo				'<br /><br />texte : ' . stripcslashes( nl2br( $message ) );
	echo			'</td></tr>';
	echo		'</table>';
	
	echo	'<div id="formBouton" style="margin-left:50px;margin-top:2em;">';
	echo	'<p>Ces informations vont être insérées dans le courriel type choisi.</p>';
	echo	'<p>Cliquez sur "Envoyer mail" et vérifez soigneusement le texte du message préparé avant d\'envoyer celui-ci.</p>';
	echo	'<input type="image" src="../images/btnEnvoiMail.png" name="action[Envoyer]">';
	echo	'</div>';
		
	echo 	'</form>';

	echo '<div id="btnRetour">';
	echo	'<a href="ACTAccueil.php?">';
	echo		'<img src="../images/btnRetour.gif" border="0">';
	echo	'</a>';
	echo '</div>';
	}
else
	{	// envoi mail
	//	validation formulaire
	function valideDate( &$laDate )
		{
		$res = decodeDate( $laDate );
		if( $res == false )
			return 'date invalide';
		elseif( false )
			{	//	la date doit être passée et vieille de 30 jours au plus
			$laD = explode( '/', $laDate );
			$date2 = mktime( 0, 0, 0, $laD[1], $laD[0], $laD[2] );
			$nbrJoursDiff = floor( ( time() - $date2 ) / ( 60*60*24 ) );
			if( $nbrJoursDiff < 0 OR $nbrJoursDiff > 30 )
				$res = false;
			}
		
		if( $res == false )
			return 'la date n\'est pas saisie ou a plus de 30 jours';
		else
			{
			$laDate = $res;
			return '';
			}
		}

	function valideSalon( $leSalon )
		{
		if( strlen( $leSalon ) < 8 )
			return 'salon invalide : 8 caractères au moins';
		else
			return true;
		}

	function decodeDate( $laDate )
		{
		if( $laDate == "" )
			return "null";
		else
			{
			$laDate = str_replace( array( '.', '-' ), '/', $laDate );
			$lesD = explode( '/', $laDate );
			if( count( $lesD ) == 2 )
				$lesD = array_merge( array( '01' ), $lesD );
			elseif( count( $lesD ) < 2 )
				return false;

			foreach( $lesD as $v )
				{
				if( !ctype_digit( $v ) )
					return false;
				}
			$j=$lesD[0];$m=$lesD[1];$a=$lesD[2];
			if( !checkdate( $m, $j, $a ) ) return false;
			if( count( $lesD ) == 3 )
				return $lesD[0] . '/' . $lesD[1] . '/' . $lesD[2];
			else
				return false;
			}
		}

	$errMessage = array();
	$address = $_POST[ 'adrCible' ];
	if( ereg( ".*<(.+)>", $address, $regs ) )
		$address = $regs[1];
	if( !ereg( "^[^@  ]+@([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9\-]{2}|net|com|gov|mil|org|edu|int)\$",$address) )
		$errMessage[] = 'Adresse cible invalide';
	switch( $typeMail )
		{
		case 0 :
			$r = valideSalon( $_POST[ 'salon' ] );
			if( !$r )
				$errMessage[] = $r;
			$r = valideDate( $_POST[ 'dateRencontre' ]);
			if( $r != '' )
				$errMessage[] = $r;
			break;
		case 1 :
			$r = valideDate( $_POST[ 'dateRencontre' ] );
			if( $r != '' )
				$errMessage[] = $r;
			break;
		case 2 :
			$r = valideDate( $_POST[ 'dateRencontre' ] );
			if( $r != '' )
				$errMessage[] = $r;
			break;
		default :
			$errMessage[] = 'type message ????';
			break;
		}
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN" "http://www.w3.org/YT/xhtml1/DTD/xhtml1-strict.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">';
	echo '<head>';
	echo	'<title>CPE Actifs Mails CPE</title>';
	echo	'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo	'<link rel="stylesheet" type="text/css" href="../css/ACTstyle.css" />';
	echo	'<link rel="stylesheet" type="text/css" href="../css/ACTstylePrint.css" media="print" />';
	echo	'<script language="javascript" src="../script.js" type="text/javascript"></script>';
	echo '</head>';
	if( count( $errMessage ) > 0 )
		{
	require 'includes/ACTenTetes.php';
	echo	'<div id="global">';
		echo '<h1>Erreur de saisie</h1>';
		foreach( $errMessage as $v )
			echo '<br>' . $v;
		}
	else
		{
		//	pièces jointes
		$pj = $mailsTypesPiecesJointes[ $typeMail ];
		$pjNoms = '';
		if( count( $pj ) > 0 )
			{
			foreach( $pj as $v )
				$pjNoms .= $v . ';';
			}
		$pjNoms = substr( $pjNoms, 0, -1 );
		$parametres = getLogin() . '/' . $typeMail . '/' . $_POST[ 'adrCible' ] . ';';
		switch( $typeMail )
			{
			case 0 :
				$parametres .= $_POST[ 'salon' ] . ';' . str_replace( '/', '-', $_POST[ 'dateRencontre' ] );
				break;
			case 1 :
				$parametres .= str_replace( '/', '-', $_POST[ 'dateRencontre' ] );
				break;
			case 2 :
				$parametres .= str_replace( '/', '-', $_POST[ 'dateRencontre' ] );
				break;
			default :
				$parametres .= '????';
				break;
			}
		$lUrl = '../contactSaisie.php?admin&ro=' . urlencode( $parametres );
		$lUrl .= '&email=' . urlencode( 'info@cadrentreprise.asso.fr' )   //	expéditeur
			. '&subject=' . urlencode($sujet)
			. '&msg=' . urlencode($message)
			. '&destinataire=' . urlencode( $_POST[ 'adrCible' ] );
		if( $pjNoms != '' )
			$lUrl .= '&piecesJointesN=' . urlencode( $pjNoms );
		if( $mailsTypesCci[ $typeMail ] != '' )
			$lUrl .= '&cci=' . urlencode( $mailsTypesCci[ $typeMail ] . ',' . $emailEmetteur );

		echo '<body onload="popitup( \'' . $lUrl . '\', \'Contact\' );">';
		
		echo '<h1>Attention</h1>';
		echo '<p>Si une nouvelle fenêtre avec le texte du courriel à envoyer ne s\'affiche pas, un message d\'erreur du type :';
		echo '<ul><li>"...a empéché ce site d\'ouvrir une fenêtre popup." (Firefox)</li>';
		echo '<li>ou bien "Une fenêtre publicitaire a été bloquée..." (Explorer)</li></ul></p<p> doit se trouver en haut de la présente fenêtre.</p>';
		echo '<p>Il vous faut autoriser le site CPE à ouvrir des "popups"</p>';
		echo '<p>Cliquez sur "Options" (Firefox) à droite du message d\'erreur  ou sur le message (Explorer) puis sélectionnez "Autoriser les popups pour cadrentreprise.free.fr"</p>';
		}
	echo '<div id="btnRetour">';
	echo	'<a href="ACTMailsCPE.php?typeMail=' . $typeMail . '&civilite=' . $civilite
		.		'&adrCible=' . $adrCible . '&salon=' . $salon . '&dateRencontre=' . $dateRencontre
		.		'">';
	echo		'<img src="../images/btnRetour.gif" border="0">';
	echo	'</a>';
	echo '</div>';
	}
?>
		</div>
	</body>
</html>