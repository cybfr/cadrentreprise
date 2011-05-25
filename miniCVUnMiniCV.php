<?php
require "includes/mySql.php";
$lIdRubrique = $_GET['idRubrique'];
if( $_GET['retour'] == "admin/RubriqueChoix.php" )
	{
	$nomTableR = "tblRubriquesCVProchain";
	$nomTable = "tblMiniCVProchain";
	}
else
	{
	$nomTableR = "tblRubriquesCV";
	$nomTable = "tblMiniCV";
	}
$query = "SELECT * from " . $nomTableR 
	. " WHERE idRubrique='" . $lIdRubrique . "'";
$result = mysql_query($query);	// or die("erreur 3");
$line = mysql_fetch_assoc($result);

$leTitre = urldecode( $line['titre'] );	
$leSousTitre = urldecode( $line['sousTitre'] );	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN">
<html XMLS="HTTP://WWW.W3.ORG/1999/XHTML" XML:LANG="FR" LANG="FR">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="noindex,nofollow">
		<link rel="stylesheet" type="text/css" href="css/style.css">
<?php		
// pour forcer phpdig à indexer après prise en compte du $_GET : ne marche pas ????
echo '<div style="visibility:hidden;"></div>';

echo	'<title>CPE - Compétences :&nbsp;'
			. $leTitre;
?>
		</title>
		<style type="text/css">
		td
			{background-color:#efefef;border:5px ridge #a0a0ff;}
		td a
			{text-decoration:none;}
		.titre
			{text-align:center;font-family:arial;font-size:1.3em;font-style:italic;font-weight:bold;padding-bottom:0.3em;}
		.sousTitre
			{text-align:center;text-transform:uppercase;font-size:0.9m;font-style:normal;padding-bottom:0.3em;}
		.pointsForts
			{padding: 0.8em 0 1em 0.8em;text-align:left;font-size:0.9em;list-style-type:circle;list-style-position:outside;}
		.pointsForts ul
			{margin:0px;padding-left:10px;}
		.complements
			{padding-left:20px;padding-top:2px;font-size:0.9em;text-align:left;font-style:italic;}
		.telephone
			{float:left;padding-top:1em;padding-left:20px;}
		.reference
			{float:right;padding-top:1em;padding-right:20px;}
		</style>
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>
<!-- en-têtes -->
<?php
echo '<div style="visibility:hidden;"></div>';
if( $_GET[ 'retour' ] == 'index.php' )
	$lEtage = 0;
else
	$lEtage = 3;
$nomTable = "tblMiniCV";
if( $_GET['retour'] == "K3 ecoute.php" )
	{
	$sncfLibelles = array( 'Entreprise', 'structure à l\'écoute', 'nos compétences',
		str_replace( '<br>', ' ', $leTitre ),
		$_GET['titreProjet'] );
	$sncfLiens = array( 'K3 entreprises.php', 'K3 ecoute.php' );
	}
elseif( $_GET['retour'] == "K3 entreprises.php" )
	{
	$sncfLibelles = array( 'Entreprise', 'nos compétences',
		str_replace( '<br>', ' ', $leTitre ),
		$_GET['titreProjet'] );
	$sncfLiens = array( 'K3 entreprises.php' );
	}
elseif( $_GET['retour'] == "admin/RubriqueChoix.php" )
	{
	$sncfLibelles = array( 'Saisie', 'nos compétences',
		str_replace( '<br>', ' ', $leTitre ),
		$_GET['titreProjet'] );
	$sncfLiens = array( 'admin/RubriqueChoix.php' );
	$nomTable = "tblMiniCVProchain";
	}
elseif( $_GET['retour'] == "espaceActifs/ACTdonnees.php" )
	{
	$sncfLibelles = array( 'espace actifs vos données',
		str_replace( '<br>', ' ', $leTitre ) );
	$sncfLiens = array( 'espaceActifs/ACTdonnees.php' );
	}
else
	{
	$sncfLibelles = array( 'Accueil', 'nos compétences',
		str_replace( '<br>', ' ', $leTitre ),
		$_GET['titreProjet'] );
	$sncfLiens = array( 'index.php' );
	}
$sncfLiens = array_merge( $sncfLiens, array( 
	'miniCVRubriques.php?retour=' . $_GET[ 'retour' ],
	'miniCVminiCV.php?retour=' . $_GET[ 'retour' ]
		//. '&titre=' . rawurlencode( $leTitre )
		//. '&sousTitre=' . rawurlencode( $leSousTitre )
		. '&idRubrique=' . $_GET['idRubrique'] ) );

$nomPage = 'projetFlash/' . $_GET['ref'];

require "includes/enTetes.php";
?>
<!-- Contenu -->
		<div id="global">
<?php
echo 		"<h1>" . $leTitre . "</h1>";
echo		'<h2>' . $leSousTitre . '</h2>';
//echo		'<h3>' . stripcslashes( $_GET['titreProjet'] ) . '</h3>';

$nomTable = "tblMiniCV";
$query = "SELECT *"
	. " FROM " . $nomTable
	. " WHERE derniereEdition is null"
		. " AND id='" . $_GET['ref'] . "' "
	. "ORDER BY ordreAffichage";
$result = mysql_query($query);	// or die("erreur 3");
$nbrFiches = mysql_num_rows( $result );
$rangCol = 0;
$queryString = 'retour=' . rawurlencode( $_GET['retour'] )
	//. '&titre=' . rawurlencode( $leTitre )
	//. '&sousTitre=' . rawurlencode( $leSousTitre )
	. '&idRubrique=' . $_GET[ 'idRubrique' ];
require_once "includes/unProjetFlash.php";
$line = mysql_fetch_assoc($result);
//echo '<r>...'.$line['titre'].'...'.$nbrFiches;
//echo '<br>...'.$query;
echo '<table style="margin: 10px 20px 10px 10px; padding: 5px;">';
	affichageHTMLunProjetFlash( $line, 0, $queryString );
echo '</td></tr></table>';

echo		'<p>&nbsp;</p><p>Pour prendre contact :</p>';
echo		'<ul>';
if( $_GET['telephone'] != '' )
	{
	echo		'<li style="padding-top:20px;">'
					. 'appelez directement la personne concernée au '
					. '<b>' . $_GET['telephone'] . '</b></li>';
	echo		'<li style="padding-top:20px;">'
					. 'ou bien ';
	}
else
	echo		'<li style="padding-top:20px;">';
echo				'<a href="#" onClick="javascript:window.open(\'contactSaisie.php?'
						. 'destinataire=CEmpl&subject=contact pour projet de référence ' . $_GET['ref']
						. '\',\'Contact\',\'width=600,height=580, scrollbars=yes\')">'
					. '<b>contactez CPE</b></a> en précisant la référence de ce dossier (<b>'
						. $_GET['ref'] . '</b>)</li>';
echo		'</ul>';
echo		'<div id="btnRetour">';
if( $_GET['retour'] == "espaceActifs/ACTdonnees.php" )
	echo			'<a href="' . $_GET['retour'] . '">';
else
	{
	$queryString = 'retour=' . rawurlencode( $_GET['retour'] )
		. '&idRubrique=' . $_GET[ 'idRubrique' ];
	echo 			'<a href="miniCVminiCV.php?'
						. $queryString . '">';
	}
?>
					<img src="images/btnRetour.gif">
				</a>
			</div>
		</div>
	</BODY>
</HTML>
