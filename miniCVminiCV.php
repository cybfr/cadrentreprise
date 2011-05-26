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

$leTitre = $line['titre'];	
$leSousTitre = $line['sousTitre'];	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="robots" content="index,nofollow" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<title>CPE - Compétences :&nbsp;<?php echo $leTitre; ?></title>
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

if( $_GET['retour'] == "K3 ecoute.php" )
	{
	$sncfLibelles = array( 'Entreprise', 'structure à l\'écoute', 'nos compétences',
		str_replace( '<br />', ' ', $leTitre ) );
	$sncfLiens = array( 'K3 entreprises.php', 'K3 ecoute.php', 'miniCVRubriques.php?retour=' . $_GET[ 'retour' ] );
	}
elseif( $_GET['retour'] == "K3 entreprises.php" )
	{
	$sncfLibelles = array( 'Entreprise', 'nos compétences',
		str_replace( '<br />', ' ', $leTitre ) );
	$sncfLiens = array( 'K3 entreprises.php', 'miniCVRubriques.php?retour=' . $_GET[ 'retour' ] );
	}
elseif( $_GET['retour'] == "admin/RubriqueChoix.php" )
	{
	$sncfLibelles = array( 'Saisie', 'nos compétences',
		str_replace( '<br />', ' ', $leTitre ) );
	$sncfLiens = array( 'admin/RubriqueChoix.php', 'miniCVRubriques.php?retour=' . $_GET[ 'retour' ] );
	}
else
	{
	$sncfLibelles = array( 'Accueil', 'nos compétences',
		str_replace( '<br />', ' ', $leTitre ) );
	$sncfLiens = array( 'index.php', 'miniCVRubriques.php?retour=' . $_GET[ 'retour' ] );
	}

$nomPage = 'projetRubrique/' . $lIdRubrique;

require "includes/enTetes.php";
?>
<!-- Contenu -->
		<div id="global">
			<div style="float:right;padding-right:40px;padding-top:10px;text-align:right;font-weight:bold;color:#225500;">
				cliquez dans une des cartes ci-dessous
				<br />pour contacter la personne correspondante.
			</div>
<?php
echo 		"<h1>" . $leTitre . "</h1>";
echo			'<h2>' . $leSousTitre . '</h2>';

echo 		'<table style="margin:10px;margin-right:20px;padding:5px">';

$query = "SELECT titre, sousTitre, pointsForts, complements, telephone, M.id, telephoneMobile, telephoneFixe"
	. " FROM " . $nomTable . " AS M, tblAdherents AS A"
	. " WHERE derniereEdition is null"
		. " AND A.id=M.idAdherent"
		. " AND idRubrique='" . $_GET['idRubrique'] . "' "
	. "ORDER BY ordreAffichage";
$result = mysql_query($query);	// or die("erreur 3");
$nbrFiches = mysql_num_rows( $result );
$rangCol = 0;
$queryString = 'retour=' . rawurlencode( $_GET['retour'] )
	//. '&titre=' . rawurlencode( $leTitre )
	//. '&sousTitre=' . rawurlencode( $leSousTitre )
	. '&amp;idRubrique=' . $_GET[ 'idRubrique' ];
require_once "includes/unProjetFlash.php";
while( ($line = mysql_fetch_assoc($result)) )
	{
	affichageHTMLunProjetFlash( $line, $rangCol, $queryString );
	if( $rangCol == 1 )
		$rangCol = 0;
	else
		$rangCol = 1;
	}
if($rangCol == 1) echo"</tr>"; // not set in affichageHTMLunProjetFlash if odd project number
echo 		"</table>";
?>
			<div id="btnRetour">
<?php
echo 			'<a href="miniCVRubriques.php?retour='
					. $_GET['retour'] . '">';
?>
					<img src="images/btnRetour.gif" alt="Retour" />
				</a>
			</div>
			<!--<p id="piedDePage"></p>-->
		</div>
	</body>
</html>