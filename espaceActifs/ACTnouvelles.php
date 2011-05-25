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
$titrePage = "nouvelles";
$sncfLibelles = array( 'Accueil', 'Nouvelles' );
$sncfLiens = array( 'ACTAccueil.php' );
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
<script language="JavaScript">
<!--
	var newwindow = '';
	
	function popitupReponse( destinataire, dateMessage )
		{
		if( destinataire == '?' )
			{
			alert( "Réponse impossible car nous ne connaissons pas l'adresse courriel de cet adhérent" );
			}
		else
			{
			lUrl = 'ACTContact.php?dest=L&adresses=' + destinataire
				+ '&subject=Re: CPE-espace actifs>nouvelles du ' + dateMessage;
			if (!newwindow.closed && newwindow.location)
				{
				newwindow.location.href = lUrl;
				}
			else
				{
				newwindow=window.open( lUrl,'Contact','top=0,left=0,width=650,height=530,scrollbars=yes');

				if (!newwindow.opener) newwindow.opener = self;
				}
			if (window.focus) { newwindow.focus() }
			}
		return false;
		}
//-->
</script>
<div id="global">
	<h1>Nouvelles</h1>

<?php
require( '../includes/mySql.php' );
$query = "SELECT A.nom,A.prenom,A.email,date_format(M.dateMessage,'%d/%m/%y') as laDate,M.texte"
	. " FROM tblMessages as M,tblAdherents as A"
	. " WHERE M.idAdherent=A.id"
	. " ORDER BY dateMessage DESC";
$res = mysql_query( $query ) or die( '<br>...'.$query.'<br>...'.mysql_error() );
//echo '<br>...'.mysql_num_rows($res).'...'.$query;

while( $l=mysql_fetch_assoc( $res ) )
	{
	$leNom = $l[ 'prenom' ] . ' ' . $l[ 'nom' ];
	
	echo '<div style="float:right;padding-right:50px;">';
	echo	'<a href="#" onClick="popitupReponse(\'' . $l[ 'email' ] . '\', \'' . $l[ 'laDate' ] . '\' )">';
	echo		'répondre à ce message';
	echo	'</a>';
	echo '</div>';
	echo '<h2><a name="070111">' . $l[ 'laDate' ] . ' ' . $leNom . '</a></h2>';
	echo '<div style="padding-left:3em;">';
	echo	$l[ 'texte' ];
	//echo	'<br>';
	echo	'<pre>' . $leNom . '</pre>';
	echo	'<br>';
	echo '</div>';
	}
