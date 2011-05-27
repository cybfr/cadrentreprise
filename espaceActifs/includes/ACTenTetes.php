<?php
// if( !isset( $_COOKIE['CPEid'] ) )
if(false)         // W3C validation item
	{	// cookie pas défini : on va vers l'authentification
		//	avec l'url cible en paramètre (dans cette url cible, l'ancre
		//	est délimitée par '.m.' et les param au delà du prmier par .p.
	$lUri = $_SERVER[ 'REQUEST_URI'];
	$lUrl = 'Location: ../identification1.php?url='
		. urlencode( $lUri );
	header( $lUrl );
	exit;
	}

//	$niveau1 : si définie ==> ajout d'un niveau dans les arborescences
if( isset( $niveau1 ) )
	$prefixe = "../";
else
	$prefixe = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" >
	<head>
		<title>Espace Actifs - <?php echo $titrePage ?>'</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo $prefixe ?>css/ACTstyle.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $prefixe ?>css/ACTstylePrint.css" media="print" />
	<script type="text/javascript" src="<?php echo $prefixe ?>../script.js"></script>
	<link rel="stylesheet" href="/css/jquery.ui.all.css" />
	<script src="/js/jquery-1.5.1.min.js" type="text/javascript"></script>
	<script src="/js/jquery-ui-1.8.13.custom.min.js" type="text/javascript"></script>
	<script src="/js/jquery.ui.autocomplete.html.js" type="text/javascript"></script>

		<style type="text/css"> 
	.ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }
	em {color:red; font-style:normal; text-decoration:bold;}
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
			<script type="text/javascript">
			<!--
			function recharger()
				{	//	rechargement suite à changement id ou nom
				if( document.leF.idOuNom.value != '' )
					lesParams = '?idOuNom=' + document.leF.idOuNom.value
				else
					lesParams = '?prenom=' + document.leF.prenom.value;
				window.location="ACTadherents.php"
					+ lesParams;
				}
			function recharger2()
				{	//	rechargement suite à choix dans popup
				lesParams = '?idOuNom=' + document.leF.noms.value;
				window.location="ACTadherents.php"
					+ lesParams;
				}
			//-->
			</script>
	
<?php  if( isset( $tagSupplementaire ) ) echo $tagSupplementaire; ?>
	</head>
	<body>
<!-- phpdigExclude -->
<?php
require_once $prefixe . '../includes/librairie.php';
require_once $prefixe . 'includes/librairie.php';
// En-tête -->
echo '<div id="header">';
echo	'<img src="' . $prefixe . '../images/logo100.gif" alt="logo CPE" />';
echo 	'<div style="float:right;">';
$login = getLogin();
if( $login === false
	AND ( !isset( $autoriseActifM1 ) ) )	//	pour autoriser accès aux logins avec statut==-1
	{
	echo '<br />Accès refusé par ACTenTetes<br />';
	exit;
	}
echo 	$login;
echo	'</div>';
echo	'<p>CPE - Espace Adhérents Actifs</p>';
echo '</div>';

$lesTokens = explode( "\\", recupCookie( ) );
$autorisation = $lesTokens[1];
$autorisation = 'actif';
// Menu accès rapide -->
echo '<ul id="menuhaut">';
//if( in_array( $login, array( 'croy','pgrenon','flindet','pricour' ) ) )
	echo	'<li><a href="' . $prefixe . 'ACTMailsCPE.php">Mails CPE</a></li>';
echo	'<li><a href="#" accesskey="1" onclick="popitup'
	. '(\'' . $prefixe . 'ACTContact.php\',\'Contact\')">Contact</a></li>';
echo	'<li><a href="' . $prefixe . 'ACTAssistance.php" accesskey="2">Assistance</a></li>';
echo	'<li><a href="' . $prefixe . '../deconnexion.php" accesskey="2">Déconnexion</a></li>';
echo '</ul>';

if( !isset( $autoriseActifM1 ) OR $autorisation != 'actif-1' ) 
	{
	// Menu de navigation générale -->
	//echo '<div id="teteDePage">';
	echo 	'<div id="menu">';
	echo		'<ul>';
	echo			'<li><a href="' . $prefixe . 'ACTAccueil.php" accesskey="a">Accueil</a></li>';
	echo			'<li><a href="' . $prefixe . 'OffresCEF1.php" accesskey="o">Offres CPE</a></li>';
	echo			'<li><a href="' . $prefixe . 'ACTagenda.php" accesskey="b">Votre agenda</a></li>';
	echo			'<li><a href="' . $prefixe . 'ACTactivites.php" accesskey="c">Vos activités</a></li>';
	echo			'<li><a href="' . $prefixe . 'ACTbibliotheque.php" accesskey="d">Vos documents utiles</a></li>';
	echo			'<li><a href="' . $prefixe . 'ACTassociations.php" accesskey="e">Pour vos recherches</a></li>';
	echo			'<li><a href="' . $prefixe . 'ACTnouvelles.php" accesskey="f">Nouvelles</a></li>';
	echo			'<li><a href="' . $prefixe . 'ACTdonnees.php" accesskey="g">Vos données personnelles</a></li>';
	echo			'<li><a href="' . $prefixe . 'ACTreseauCPE.php" accesskey="h">Votre réseau CPE</a></li>';
	echo			'<li><a href="' . $prefixe . 'rencontres/index.php" accesskey="i">Nos rencontres</a></li>';
	echo			'<li><a href="' . $prefixe . 'ACTadherents.php" accesskey="i">Contacter un adhérent</a></li>';
	//echo			'<li><a href="' . $prefixe . 'forumIndex.php" accesskey="i" style="text-shadow:white 2px 2px;color:#555555;">Forums</a></li>';
	echo		'</ul>';
	// flèches précisant section en cours
	if( false)
		{
		echo 		'<div style="position:absolute; top:';
		$leTop = 3.3 + $lEtage*3.6;
		echo 	$leTop . 'em; left:1em;">';
		echo			'<img src="' . $prefixe . '../images/pointillesHorizontaux.gif">';
		echo 		'</div>';
		echo 		'<div style="position:absolute; top:0.3em; left:14.1em; text-align:right;">';
		echo 			'<img src="' . $prefixe . '../images/pointilles' . $lEtage . '.gif">';
		echo 		'</div>';
		}
	echo 	'</div>';
	}
//	chemin de fer
echo 	'<div id="cdeFer">&nbsp;';
if( isset( $sncfLibelles ) )
	{
	$i = 0;
	foreach( $sncfLibelles as $leLibelle )
		{
if( $i > 0 ) echo ' > ';
		if( $sncfLiens[$i] != '' )
			echo '<a href="' .  $sncfLiens[$i] . '">' . $leLibelle . '</a>';
		else
			{
			echo $leLibelle;
			}
		$i++;
		}
	}
echo 	'</div>';
if( isset( $nomPage ) AND $_SERVER['HTTP_HOST'] == 'cadrentreprise.free.fr' )
	{
	$nomPage .= $login;			//	différence avec enTetes publiques ---------------
?>
	<div style="margin:0px;padding:0px;height:1px;">
	<!-- phpmyvisites -->
	<a href="http://st.free.fr/" title="phpMyVisites | Open source web analytics" 
	onclick="window.open(this.href);return(false);">
	<script type="text/javascript">
	<!--
	var a_vars = Array();
	<?php
	echo "var pagename='" . $nomPage . "'\n";
	?>
	var phpmyvisitesSite = 41478;
	var phpmyvisitesURL = "http://st.free.fr/phpmyvisites.php";
	//-->
	</script>
	<script language="javascript" src="http://st.free.fr/phpmyvisites.js" type="text/javascript"></script>
	<object><noscript><p>phpMyVisites | Open source web analytics
	<img src="http://st.free.fr/phpmyvisites.php" alt="Statistics" style="border:0" />
	</p></noscript></object></a>
	</div>
	<!-- /phpmyvisites --> 
<?php
	}
echo "\n" . '<!-- phpdigInclude -->' . "\n";
?>