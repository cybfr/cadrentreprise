<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN">
<html XMLS="HTTP://WWW.W3.ORG/1999/XHTML" XML:LANG="FR" LANG="FR">
	<head>
		<title>CPE - Cadres pour l'Entreprise - rubriques projets flash</title>
<meta name="description" content="Cadres pour l'Entreprise : profils de cadres confirmés">
		<meta name="keywords" content="CPE,cadres,cadre,entreprises,entreprise,profils,Paris,Ile de France,experience,experimente,senior,competences,reussite,mission,recherche,chomage,emploi">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>
<!-- en-têtes -->
<?php
echo '<div style="visibility:hidden;"></div>';

$nomTable = "projetRubriques";

$nomTable = "tblRubriquesCV";
if( $_GET['retour'] == "K3 ecoute.php" )
	{
	$sncfLibelles = array( 'Entreprise', 'structure à l\'écoute', 'nos compétences' );
	$sncfLiens = array( 'K3 entreprises.php', 'K3 ecoute.php' );
	}
elseif( $_GET['retour'] == "K3 entreprises.php" )
	{
	$sncfLibelles = array( 'Entreprise', 'nos compétences' );
	$sncfLiens = array( 'K3 entreprises.php' );
	}
elseif( $_GET['retour'] == "admin/RubriqueChoix.php" )
	{
	$sncfLibelles = array( 'Saisie', 'nos compétences' );
	$sncfLiens = array( 'admin/RubriqueChoix.php' );
	$nomTable = "tblRubriquesCVProchain";
	}
else
	{
	$sncfLibelles = array( 'Accueil', 'nos compétences' );
	$sncfLiens = array( 'index.php' );
	}
require "includes/enTetes.php";

?>
<!-- Contenu -->
		<div id="global">
			<h1>Vivier de compétences</h1>
			<table><tr valign="top"><td width="35%">
				<p>Des hommes et des femmes immédiatement opérationnels dans tous les secteurs de l'entreprise</p>
				</td><td>
<?php
	//	le tableau $libelles contient les libelles attachés à chaque groupe de miniCV
	//	le tableau $ids contient les id des rubriques
require "includes/mySql.php";

$query = "SELECT idRubrique, titre, sousTitre from " . $nomTable
	. " WHERE derniereEdition is null ORDER BY ordreAffichage";
$result = mysql_query($query);	// or die("erreur 3");
$i = 0;
while( ($line = mysql_fetch_assoc($result)) )
		{
		if( ($i++ % 2) == 0)
			echo 	'<p class="paraEncadres">';
		else
			echo 	'<p class="paraEncadres" style="background-color:#dfdfff">';
		echo 		'<a href="miniCVminiCV.php?';
			$queryString = 'retour=' . rawurlencode( $_GET['retour'] )
				//. '&titre=' . rawurlencode( stripcslashes( $line[ 'titre' ] ) )
				//. '&sousTitre=' . rawurlencode( stripcslashes( $line[ 'sousTitre' ] ) )
				. '&idRubrique=' . $line[ 'idRubrique' ];
		echo 			$queryString . '">';
		echo 			'<b>' . stripcslashes( $line[ 'titre' ] ) . '</b>';
		if( $line[ 'sousTitre' ] != '' )
			echo			' : ' . stripcslashes( $line[ 'sousTitre' ] );
		echo 	"</a></p>";
		}
echo 			'</td></tr></table>';
echo			'<div id="btnRetour">';
echo 				'<a href="' . ( $_GET['retour'] )
						. '"><img src="images/btnRetour.gif"></a>';
echo			'</div>';
?>
			<!--<p id="piedDePage"></p>-->
		</div>
	</body>
</html>
