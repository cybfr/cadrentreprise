<!-- en-têtes -->
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
$titrePage = "forums, fils";
$sncfLibelles = array( 'Accueil','Forums' );
$sncfLiens = array( 'ACTAccueil.php' );
$nomPage = "Forum/";
$leModerateur = 'croy';

require "includes/ACTenTetes.php";
require "../includes/mySql.php";
?>
<!-- Contenu -->
<div id="global">
	<h1>Forum CPE - Liste des fils de discussion</h1>
<div id="forum">
	<table cellspacing="0" cellpadding="0">
		<tr class="lgnEntetesForum" style="border-top:1px solid orange;text-align:center;"><td colspan="5">Fil</td><td colspan="2">dernier message</td><td>&nbsp;</td></tr>
		<tr class="lgnEntetesForum">
			<td>statut</td>
			<td>domaine</td>
			<td>sujet</td>
			<td>date</td>
			<td>Auteur</td>
			<td>date</td>
			<td>Auteur</td>
			<td>nbre</td>
		</tr>
<?php
$query = "SELECT idFil,statut,domaine,date_format(M.date,'%d/%m/%y %H:%i') as MDate,"
		. "date_format(F.date,'%d/%m/%y %H:%i') as FDate,texte,sujet,M.auteur AS MAuteur,F.auteur AS FAuteur"
	. " FROM f01Fils as F, f01Messages as M"
	. " WHERE idFil=F.id AND F.actif=1 AND M.actif=1"
	. " ORDER BY idFil DESC,M.id DESC";
$result = mysql_query($query);	// or die("erreur 3");
if( !$result )
	{
    $message  = 'Requête invalide : ' . mysql_error() . "\n";
    $message .= 'Requête complète : ' . $query;
    die($message);
	}
$lesColsPasAffichees = array( "idG", "id", "nom","prenom","derniereEdition" );
$rang = 0;
$lIdAdherentEnCours = -1;
$idFilEnCours = NULL;
while( ($line = mysql_fetch_assoc($result)) )
	{
	if( $line['idFil'] != $idFilEnCours )
		{
		if( $idFilEnCours != NULL )
			//	 fin traitement fil précédent
			echo '<td>' . $nbrMessages . '</td></tr>';
		$nbrMessages = 0;
		$idFilEnCours = $line['idFil'];
		//
		echo '<tr class="lgnCorpsForum"><td>';
		if( ( $login==$line[ 'FAuteur' ] OR $login == $leModerateur )
			AND $line[ 'statut' ] != 'CLOS' )
			{
			//	protection simple pour l'id du message à clore
			$lId = $line['idFil'] + ord(substr($login,2,1)) - ord(substr($login,1,1));
			echo '<a href="forumClore?id=' . $lId . '">';
			}
		echo $line['statut'];
		if( $login==$line[ 'FAuteur' ] && $line[ 'statut' ] != 'CLOS' )
			echo '</a>';
		echo '</td>';
		echo '<td>' . $line[ 'domaine' ] . '</td>';
		echo '<td><a href="forumMessages.php?id=' . $idFilEnCours . '">' . $line[ 'sujet' ] . '</a></td>';
		echo '<td>' . $line[ 'FDate' ] . '</td>';
		echo '<td>' . $line[ 'FAuteur' ] . '</td>';
		echo '<td>' . $line[ 'MDate' ]. '</td>';
		echo '<td>' . $line[ 'MAuteur' ] . '</td>';
		//
		
		}
	$nbrMessages++;
	}
echo '<td>' . $nbrMessages . '</td></tr>';
?>
	</table>
	<div style="margin-top:20px;padding:5px;border:2px solid green;">
		<p>Ce forum vous permet de participer aux discussions ouvertes.</p>
		<p>Son emploi est simple : il est expliqué dans une discussion intitulée
		<a href="forumMessages.php?id=1">Explications sur leFonctionnement du forum</a>
	</div>
</div>
<div class="formBouton" style="padding-top:20px;margin-left:17em;">
	<a href="forumCreerFil.php">
		<image src="../images/btnNouveauFil.png" border="0" >
	</a>
	<a href="ACTAccueil.php">
		<img src="../images/btnRetour.gif" border="0">
	</a>
</div>
</body>
</html>