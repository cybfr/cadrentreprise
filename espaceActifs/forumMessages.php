<?php
function formatteMessage( $leMessage )
	{
	$l = explode( "<lien>", $leMessage );
	$messageFinal = "";
	foreach( $l as $ll )
		{
		if( $messageFinal != "" )
			{
			//	recherche de </lien>
			$i = strpos( $ll, "</lien>" );
			$messageFinal .= '<a href="'
				. substr( $ll, 0, $i ) . '">'
				. substr( $ll, 0, $i ) . '</a>'
				. substr( $ll, $i + 7 );
			}
		else
			$messageFinal = $ll;
		}
	return nl2br( $messageFinal);
	}

if( !isset( $_COOKIE['CPEid'] ) )
	{	// cookie pas défini : on va vers l'authentification
		//	avec l'url cible en paramètre (dans cette url cible, l'ancre
		//	est délimitée par '.m.' et les param au delà du prmier par .p.
	$lUri = $_SERVER[ 'REQUEST_URI'];
	$i = strpos( $lUri, "/espacesActifs" );
	$lUrl = 'Location: ../identification1.php?url='
		. urlencode( $lUri );
	header( $lUrl );
	exit;
	}

$titrePage = "forum, messages";
$sncfLibelles = array('Accueil',"Forum","Fil");
$sncfLiens = array( 'ACTAccueil.php','forumIndex.php' );
require "includes/ACTenTetes.php";
//require "includes/librairie.php";
require "../includes/mySql.php";

$leModerateur = 'croy';
if( isset( $_GET['id'] ) )
	{
	$lIdFil = $_GET['id'];
	//	élimination de ".m.ancre" si présent (appel depuis RSS avec authentification faite) 
	$i = strpos( $lIdFil, ".m." );
	if( $i ) $lIdFil = substr( $lIdFil, 0, $i );
	}
?>
	<div style="margin-right:10px;">
<!-- Contenu -->
		<div id="global">
<?php
$query = "SELECT F.sujet,F.domaine,F.statut,"
			. "M.auteur,M.enAvant,date_format(M.date,'%d/%m/%y %H:%i') as MDate,M.texte,M.id,M.idMessageRepondu,"
			. "concat( A.prenom, ' ', A.nom ) as nom,A.telephoneFixe,A.telephoneMobile,A.id as idAdherent"
	. " FROM f01Messages as M, f01Fils as F, tblMdp as P, tblAdherents as A"
	. " WHERE F.id=" . $lIdFil . " AND F.id=M.idFil AND F.actif=1 AND M.actif=1"
		. " AND M.auteur = P.login AND P.idAdherent = A.id" 
	. " ORDER BY M.date";
//echo '<br>...' . $query;
$result = mysql_query($query);	// or die("erreur 3");
if( !$result )
	{
    $message  = 'Requête invalide : ' . mysql_error() . "\n";
    $message .= 'Requête complète : ' . $query;
    die($message);
	}
$nbrMessages = 0;
$lIdAdherentEnCours = -1;
while( ($line = mysql_fetch_assoc($result)) )
	{
	if( $nbrMessages == 0 )
		echo '<h1>Forum CPE - fil de discussion (' . $line['domaine'] . ')</h1>';
	$t[] = array($line['sujet'],$line['statut'],$line['nom'],
		$line['MDate'],$line['texte'],$line['id'],$line['idMessageRepondu'],
		$line['enAvant'],$rang,$line['prenom'] . ' ' . $line['nom'],$line['telephoneFixe'],$line['telephoneMobile'],
		$line['idAdherent']);
	$nbrMessages ++;
//echo '<br>...' . $line['id'];
	}
//echo '<br>';exit;
//	constantes rangs dans tableaux $t[]
$rangSujet=0;$rangStatut=1;$rangAuteur=2;$rangDate=3;$rangTexte=4;
$rangId=5;$rangIdMessageRepondu=6;$rangEnAvant=7;$rangRang=8;$rangPrenomNom=9;
$rangFixe=10;$rangMobile=11;$rangIdAdherent=12;
mysql_free_result( $result );
//echo '<pre>'; print_r($t); '</pre>';
//	à ce stade, $t est trié par date de création croissante ce qui n'est pas
//	nécessairement l'odre d'affichage
//	ordre et niveau d'affichage -->$ordre[] :
//		$ordre[][0] = rang dans $t du message correspondant
//		$ordre[][1] = ordre d'affichage du message correspondant
//		$ordre[][2] = niveau d'affichage du message correspondant
//
//		1. rangs de $t --> $ordre[][0] (0, 1, 2...)
for( $rang=0; $rang < $nbrMessages; $rang++ )
	$ordre[ $rang ] = array( $rang, 0, 0 );

//		2. calcul itératif en partant de la racine de $ordre[][1] et $ordre[][2]
function ordreSousUnMessage( $rangDuMessage, $ordreEnCours, $niveauEnCours, $rangIdMessageRepondu )
	{
global $t, $ordre, $nbrMessages;

//echo '<br>...' . $rangDuMessage . '-->' . $ordreEnCours;
	//	on positionne l'ordre de ce message
	$ordre[ $rangDuMessage ][1] = $ordreEnCours;
	$ordreEnCours++;
	$ordre[ $rangDuMessage ][2] = $niveauEnCours;
	$niveauEnCours++;
	$lId = $t[ $rangDuMessage ][5];	// $rangId <<<<<<<<<<<<<<<
	//	on recherche et traite les successeurs de ce message au niveau suivant
	for( $rang=$rangDuMessage; $rang < $nbrMessages; $rang++ )
		{
//echo '<br>   ...' . $rang . '     ' . $t[ $rang ][$rangIdMessageRepondu];
		if( $t[ $rang ][$rangIdMessageRepondu] == $lId )
			$ordreEnCours =
				ordreSousUnMessage( $rang, $ordreEnCours, $niveauEnCours, $rangIdMessageRepondu );
		}
	return $ordreEnCours;
	}

ordreSousUnMessage( 0, 0, 0, $rangIdMessageRepondu );
//echo '<pre>' ; print_r( $ordre ) ; echo '</pre>';exit;
//	tri de $ordre
function compare( $a, $b )
	{
	if( $a[0] == 0 )
		return -1;
	else if( $b[0] == 0 )
		return +1;
	else
		{
		if( $a[1] > $b[1] )
			return +1;
		elseif( $a[1] == $b[1] )
			return 0;
		else
			return -1;
		}
	}
usort( $ordre, "compare" );
//echo '<pre>' ; print_r( $ordre ) ; echo '</pre>';
//	email expéditeur --> $lEMailExpediteur
$lEMailExpediteur = getEMailFromPseudo( $login );

//
foreach( $ordre as $val )
	{
	//
	$rang = $val[0];
	$leMessage = $t[ $rang ];
	$niveau = $val[2];
	if( $rang == 0 )
		{	// en-tête du fil
		echo '<div style="float:right;text-align:right;padding-top:4px;">';
		echo 	"statut " . $leMessage[$rangStatut];
		echo	"<br>date " . $leMessage[$rangDate];
		echo '</div>';
		echo '<div class="enTeteMessage">';
		echo 	'Titre : <b><div style="display:inline;font-size:1.2em;color:white;">' . $leMessage[$rangSujet] . '</div>';
		echo 	'</b><br>Par : '
					. '<a href="#" onClick="javascript:popitup(\'ACTFicheAdherent.php'
						. '?prenomNom=' . urlencode($leMessage[$rangPrenomNom])
						. '&fixe=' . $leMessage[$rangFixe]
						. '&mobile=' . $leMessage[$rangMobile]
						. '&email=' . $lEMailExpediteur 
						. '&idAdherent=' . $leMessage[$rangIdAdherent]
						. "','Fiche')\">" . $leMessage[$rangPrenomNom] . '</a>';
//echo '(' . $leMessage[$rangId] . ')';		// pour debug
		echo '</div>';
		echo '<div class="texteMessage">';
		echo	formatteMessage( $leMessage[$rangTexte] );
		echo '</div>';
		echo '<div class="boutonReponseGauche">';			// float:left
		if( $leMessage[ $rangStatut ] == 'CLOS' )
			echo "&nbsp;";
		else
			{
			echo	'<a href="forumRepondre.php?idFil=' . $lIdFil
						. '&idMessage=' . $leMessage[$rangId] . '"'
						. ' title="Pour répondre à ce message">';
			echo		'Répondre';
			echo 	'</a>';
			}
		echo '</div>';
		echo '<div class="boutonDroite">';
		echo 	'<div class="iconesIntermediaires ">';
			$leSujet = '[Re ]' . $leMessage[$rangSujet];
			echo	'<a href="#" style="border:none;" onClick="javascript:window.open(\'ACTContact.php'
						. '?subject=' . $leSujet
						. '&dest=pseudo' . $leMessage[$rangAuteur]
						. '&email=' . $lEMailExpediteur 
						. '\',\'Contact\',\'width=650,height=530\')">';
			echo 		'<img src="../images/icoMail.png" '
							. 'title="Pour envoyer un courriel à l\'émetteur de ce message">';
			echo 	'</a>';
		echo 	'</div>';
		if( $login == $leModerateur )
			{	//	suppression du fil
			echo	'<a href="forumSupprimer.php?type=message'
						. '&idFil=' . $lIdFil
						. '&idMessage=' . $leMessage[$rangId] . '">';
			echo		'<image src="../images/btnSupprimer.gif" border="0" height="20px">';
			echo 	'</a>';
			}
		else
			echo '&nbsp;';
		echo '</div>';
		}
	else
		{
		echo '<div id="m' . $leMessage[$rangId] . '" style="clear:right;margin-left:' . 20*$niveau . 'px;">';
			echo '<div class="numeroMessage">';
			echo	$rang;
			echo '</div>';
			echo '<div style="float:right;margin-top:0px;padding:2px;text-align:right;">';
			echo	"date " . $leMessage[$rangDate];
			echo '</div>';
			if( $leMessage[$rangEnAvant] == 1 )
				echo '<div class="enTeteMessageMisEnAvant">';
			else
				echo '<div class="enTeteMessage">';
			echo 	'</b>Par : '
					. '<a href="#" onClick="javascript:popitup(\'ACTFicheAdherent.php'
						. '?prenomNom=' . urlencode($leMessage[$rangPrenomNom])
						. '&fixe=' . $leMessage[$rangFixe]
						. '&mobile=' . $leMessage[$rangMobile]
						. '&email=' . $lEMailExpediteur 
						. '&idAdherent=' . $leMessage[$rangIdAdherent]
						. "','Fiche')\">" . $leMessage[$rangPrenomNom] . '</a>';
			echo '</div>';
			if( $leMessage[$rangEnAvant] == 1 )
				echo '<div class="texteMessageMisEnAvant">';
			else
				echo '<div class="texteMessage">';
			echo	formatteMessage( $leMessage[$rangTexte] );
			echo '</div>';
			if( $leMessage[$rangEnAvant] == 1 )
				echo '<div class="boutonReponseGaucheMisEnAvant">';
			else
				echo '<div class="boutonReponseGauche">';
			if( $leMessage[ $rangStatut ] == 'CLOS' )
				echo "&nbsp;";
			else
				{
				echo	'<a href="forumRepondre.php?idFil=' . $lIdFil
									. '&idMessage=' . $leMessage[$rangId] . '"'
				 					. ' title="Pour répondre à ce message">';
				echo		'Répondre';
				echo 	'</a>';
				}
			echo '</div>';

			echo '<div class="boutonDroite">';
			echo '<div class="iconesIntermediaires ">';
			$leSujet = '[Re ]' . $leMessage[$rangSujet];
			echo	'<a href="#" style="border:none;" onClick="javascript:window.open(\'ACTContact.php'
						. '?subject=' . $leSujet
						. '&dest=pseudo' . $leMessage[$rangAuteur]
						. '&email=' . $lEMailExpediteur 
						. '\',\'Contact\',\'width=650,height=530\')">';
			echo 		'<img src="../images/icoMail.png"'
							. 'title="Pour envoyer un courriel à l\'émetteur de ce message">';
			echo 	'</a>';
			if( $login == $t[0][$rangAuteur] OR $login == $leModerateur )
				{	//	icône "en avant"
				echo	'<a style="margin-left:10px;border:none;" href="forumEnAvant.php'
							. '?idFil=' . $lIdFil
							. '&idMessage=' . $leMessage[$rangId]
							. '&enAvant=' . $leMessage[$rangEnAvant] . '">';
				echo 		'<img src="../images/icoEnAvant.png" '
								. 'title="Pour attirer l\'attention sur ce message">';
				echo 	'</a>';
				}
			echo '</div>';
			if( $login == $leModerateur )
				{	//	bouton suppression du fil
				echo	'<a href="forumSupprimer.php?type=message'
							. '&idFil=' . $lIdFil
							. '&idMessage=' . $leMessage[$rangId] . '">';
				echo		'<image src="../images/btnSupprimer.gif" border="0" height="20px">';
				echo 	'</a>';
				}
			else
				echo '&nbsp;';
			echo '</div>';
		echo '</div>';
		}
	$rang++;
	}
echo '</div>';
echo '<div class="formButton" style="margin-top:20px;margin-left:17em;">';
echo	'</a>';
echo	'<a href="forumIndex.php?id=' . $lIdFil . '">';
echo		'<image src="../images/btnRetour.gif" border="0" >';
echo	'</a></div>';

?>
<br><br>
		</div>
	</body>
</html>