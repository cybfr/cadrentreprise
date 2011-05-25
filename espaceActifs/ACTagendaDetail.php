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

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN" "http://www.w3.org/YT/xhtml1/DTD/xhtml1-strict.dtd">';
echo	'<html xmlns="HTTP://WWW.W3.ORG/1999/XHTML" xml:lang="FR" lang="FR">';
echo		'<head>';
echo			'<title>CPE - détail événement</title>';

echo			'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
echo			'<link rel="stylesheet" type="text/css" HREF="css/ACTstyle.css">';
echo			'<style>';
echo				'em {color:red; font-style:normal; text-decoration:bold;}';
echo			'</style>';
echo		'</head>';
echo		'<body id="global2" style="padding-top:0.5em;" onLoad="self.focus()">';
echo			'<div id="header2">';
echo				'<img src="../images/logo50.gif" alt="logo CPE" />';
echo				'<p>Cadres pour l\'Entreprise</p>';
echo			'</div>';

require '../includes/mySql.php';

if( false )
	{
$query = "select E.titre,E.texte,E.lieu,date_format(E.dateDebut,'%d/%m/%Y %H:%i') AS dateDebut,"
	. "date_format(E.dateFin,'%d/%m/%Y %H:%i') AS dateFin,A.nom,A.prenom,A.eMail,A.telephoneMobile,G.titre AS GTitre"
	. " FROM tblEvts AS E, tblGroupes as G, tblAdherents as A"
	. " WHERE E.id=" . $_GET['evt']
		. " AND E.type=G.id"
		. " AND (G.animateur1=A.id OR G.animateur2=A.id OR G.animateur3=A.id OR G.animateur4=A.id)";
$result = mysql_query($query) or die('<br>...'.$query.'<br>...' . mysql_error());
$nbrAnimateurs = mysql_num_rows( $result );
if( $nbrAnimateurs == 0 )
	{
	$query = "select E.titre,E.texte,E.lieu,date_format(E.dateDebut,'%d/%m/%Y %H:%i') AS dateDebut,"
		. " date_format(E.dateFin,'%d/%m/%Y %H:%i') AS dateFin,G.titre AS GTitre"
		. " FROM tblEvts AS E, tblGroupes as G"
		. " WHERE E.id=" . $_GET['evt']
			. " AND G.id=E.type";
	$result = mysql_query($query) or die('<br>...'.$query.'<br>...' . mysql_error());
	}
}
$query = "SELECT *,date_format(dateDebut,'%d/%m/%Y %H:%i') AS maDateDebut,"
	. "date_format(dateFin,'%d/%m/%Y %H:%i') AS maDateFin"
	. " FROM tblEvts"
	. " WHERE id=" . $_GET[ 'evt' ];
$result = mysql_query($query) or die('<br>...'.$query.'<br>...' . mysql_error());
$line = mysql_fetch_assoc($result);
echo '<div style="margin-top:30px;">';
echo 	'<table border="0" width="500">';
$leTitre = $line['titre'];
echo 		'<tr><td width="15%">titre</td><td>' . $leTitre . '</td></tr>';
echo 		'<tr><td>activité</td><td>' . $line['titre'] . '</td></tr>';
$laDateDebut = str_replace( ' 00:00', '', $line['maDateDebut'] );
echo 		'<tr><td>date début</td><td>' . $laDateDebut . '</td></tr>';
if( $line['dateFin'] != '' )
	{
	$laDateFin = str_replace( ' 00:00', '', $line['maDateFin'] );
	echo 		'<tr><td>date fin</td><td>' . $laDateFin . '</td></tr>';
	}
/**
* remplace les tags CPE
*/
function developpeTags( $source )
	{
	$segments = explode( '#', $source );
	$objet = '';
	for( $i=0; $i<count($segments); $i++ )
		{
		if( $i%2 == 0 )
			$objet .= $segments[ $i ];
		else
			{
			$l = explode( ':', $segments[$i] );
			switch( $l[ 0 ] )
				{
				case 'adh' :
					$query = "SELECT * FROM tblAdherents WHERE id=" . $l[1];
				echo '<br>'.$query;
					$result = mysql_query($query) or die('<br>...'.$query.'<br>...' . mysql_error());
					$lRes = mysql_fetch_assoc( $result );
					$prenomNom = $lRes ['prenom' ] . ' ' . $lRes ['nom' ];
					$fixe = $lRes ['telephoneFixe' ];
					$mobile = $lRes ['telephoneMobile' ];
					$eMail = $lRes ['eMail' ];
					$lUrl = 'ACTFicheAdherent.php?prenomNom=' . urlencode($prenomNom)
						. '&fixe=' . urlencode($fixe) . '&mobile=' . urlencode($mobile)
						. '&email=' . urlencode($eMail) . '&idAdherent=' . $l[ 1 ] . '&screenHeight=-1050';
					$objet .= '<a href="' . $lUrl . '">'
						. $prenomNom . '</a>';
					break;
				default :
					$objet .= $segments[$i];
				}
			}
		}
	return $objet;
	}
echo 		'<tr><td>texte</td><td>' . nl2br( developpeTags( $line['texte'] )) . '</td></tr>';
echo 		'<tr><td>lieu</td><td>' . $line['lieu'] . '</td></tr>';

$query = "SELECT A.id,A.nom,A.prenom,A.telephoneFixe,A.telephoneMobile,A.eMail,P.typeParticipation FROM tblParticipations AS P,tblAdherents AS A"
	. " WHERE idEvt=" . $_GET[ 'evt' ] . " AND P.idAdherent=A.id"
	. " ORDER BY typeParticipation, nom, prenom";
$result = mysql_query($query) or die('<br>...'.$query.'<br>...' . mysql_error());
$rang = 0;
$typeEnCours = '';
$tabMailsA = $tabMailsAetP = array();
while( ($line = mysql_fetch_assoc($result) ) )
	{
	if( $typeEnCours != $line[ 'typeParticipation' ] )
		{
		$typeEnCours = $line[ 'typeParticipation' ];
		echo '<tr><td colspan="2"><strong>' . ($typeEnCours=='animateur'?'Animateur(s) :':'Participant(s)') . '</td></tr>';
		}
	echo '<tr><td>&nbsp;</td><td>';
	$prenomNom = $line ['prenom' ] . ' ' . $line ['nom' ];
	$fixe = $line ['telephoneFixe' ];
	$mobile = $line ['telephoneMobile' ];
	$eMail = $line ['eMail' ];
	if( isset( $eMail ) )
	{
	if( $typeEnCours == 'animateur' )
		$tabMailsA[] = $eMail;
	$tabMailsAetP[] = $eMail;
	}
	$lUrl = 'ACTFicheAdherent.php?prenomNom=' . urlencode($prenomNom)
		. '&fixe=' . urlencode($fixe) . '&mobile=' . urlencode($mobile)
		. '&email=' . urlencode($eMail) . '&idAdherent=' . $line[ 'id' ] . '&screenHeight=-1050';
	echo '<a href="' . $lUrl . '">' . $prenomNom . '</a>';
	echo '</td></tr>';
	$rang++;
	}
echo 			'</td></tr></table>';
//	envoi mail aux animateurs
echo '<div style="text-align:right;margin-top:40px;">';
if( count( $tabMailsA ) > 0 )
	{
	echo '<a href="#" onClick="javascript:window.open(\'ACTContact.php?dest=L&adresses=';
	$rangMail= 0;
	foreach( $tabMailsA as $leMail )
		{
		if( $rangMail > 0 )
			echo ';';
		echo $leMail;
		$rangMail++;
		}
	echo '&subject=CPE-' . urlencode($leTitre) . ' (' . $laDateDebut . ')';
	echo '\',\'Contact\',\'alwaysRaised=1,width=580,height=540, scrollbars=yes\')">';
	echo	'envoi courriel aux animateurs';
	echo '</a><br>';
	}
//	envoi mail aux animateurs et participants
if( count( $tabMailsAetP ) > 0 )
	{
	echo '<a href="#" onClick="javascript:window.open(\'ACTContact.php?dest=L&adresses=';
	$rangMail= 0;
	foreach( $tabMailsAetP as $leMail )
		{
		if( $rangMail > 0 )
			echo ';';
		echo $leMail;
		$rangMail++;
		}
	echo '&subject=CPE-' . urlencode($leTitre) . ' (' . $laDateDebut . ')';
	echo '\',\'Contact\',\'alwaysRaised=1,width=580,height=540, scrollbars=yes\')">';
	echo	'envoyer courriel aux animateurs et participants';
	echo '</a>';
	}
echo '</div>';
?>
<!-- Contenu -->
	</div>
	</body>
</html>