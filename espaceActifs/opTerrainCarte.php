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
$titrePage = "Opérations Terrain";
$sncfLibelles = array( 'Accueil', 'Opération Terrain' );
$sncfLiens = array( 'ACTAccueil.php' );

//	A LA PLACE de include ACCTEnTetes.php --------------------------------------------

//	$niveau1 : si définie ==> ajout d'un niveau dans les arborescences
if( isset( $niveau1 ) )
	$prefixe = "../";
else
	$prefixe = "";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<style type="text/css">
			html { height: 100% }
			body { height: 100%; margin: 0px; padding: 0px }
div#wrapper { position: relative; }
			#map_canvas { width:1000px;height:600px; }
div#legend { background:#EEE;margin:5px;padding:20px;font-weight:bold; position: absolute; top: 0px; right: 0%; }
		</style>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true">
		</script>
		<script type="text/javascript">
			var geocoder;
			var map;
			var markerCentral;

			function initialize()
				{
				var results;
				geocoder = new google.maps.Geocoder();
				var latlng;
				var address = "135 rue d'Alésia, Paris";
				geocoder.geocode( { 'address': address}, function(results, status) 
					{
					latlng = results[0].geometry.location;
					var myOptions =
						{
						zoom: 15,
						center: latlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP
						};
					map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

creationMarqueur( map, address, 'rendez-vous déjeuner', '', 'orange', 'A' );

creationMarqueur( map, '1 rue Sarrette, Paris', 'IBM', 'Mr Sarkozy DRH', 'purple', 'A' );
creationMarqueur( map, '20 rue Sarrette, Paris', 'General Motors', 'Mme Bruni chargée du recrutement<br>M Ben Ali DRH', 'purple', 'B' );
creationMarqueur( map, '40 rue Sarrette, Paris', 'Ford', 'M Ben Ali DRH', 'purple', 'C' );
creationMarqueur( map, '42 rue Sarrette, Paris', 'Renault', 'M Ben Ali DRH', 'purple', 'D' );
creationMarqueur( map, '70 rue Sarrette, Paris', 'PSA', 'M Ben Ali DRH', 'purple', 'E' );
creationMarqueur( map, 'Hopital Sainte Anne, Paris', 'Hopitaux de Paris', 'M Landru DRH', 'purple', 'F' );
creationMarqueur( map, '300 avenue du Maine, Paris', 'Ferrari', 'il Commendatore DRH', 'darkgreen', 'Z' );
					});
				}

function creationMarqueur( laMap, adresse, titre, info, couleur, lettre )
//	info	:	texte HTML
//	couleur :	blue, brown, darkgreen, green, orange, paleblue, pink, purple, red ou yellow 
//	lettre	:	A à Z
	{
	geocoder.geocode( { 'address': adresse}, function(results, status) 
		{
		var icone = 'markers/' + couleur + '_Marker' + lettre + '.png';
		var marker = new google.maps.Marker(
			{
			map: laMap,
			position: results[0].geometry.location,
			title: titre,
			icon: icone
			});

		var infoTexte = '<div id="content">'+
		    				'<div id="siteNotice">'+
		    				'</div>'+
		    				'<h1 id="firstHeading" class="firstHeading">' + titre + '</h1>'+
		    				'<div id="bodyContent">'+
		    					'<p><b>' + adresse + '</b></p>'+
								'<p>' + info + '</p>'
						    '</div>'+
		    			'</div>';
		var infowindow = new google.maps.InfoWindow({
    		content: infoTexte
			});
		google.maps.event.addListener( marker, 'click', function()
			{
			infowindow.open( laMap, marker );
			});
		});
	}
			function codeAddress() 
				{
				var address = document.getElementById( "address" ).value;
				geocoder.geocode( { 'address': address}, function(results, status) 
					{
					if (status == google.maps.GeocoderStatus.OK)
						{
						map.setCenter( results[0].geometry.location );
						var marker = new google.maps.Marker(
							{
							map: map,
							position: results[0].geometry.location
							});
						}
					else
						{
						alert("Geocode was not successful for the following reason: " + status);
						}
					});
				}
		</script>
		<title>Espace Actifs - 
<?php
echo 		$titrePage . '</title>';
echo	'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
echo	'<link rel="stylesheet" type="text/css" href="'
			. $prefixe . 'css/ACTstyle.css" />';
echo	'<link rel="stylesheet" type="text/css" href="'
			. $prefixe . 'css/ACTstylePrint.css" media="print" />';
echo	'<script type="text/javascript" src="'
			. $prefixe . '../script.js"></script>';
if( isset( $tagSupplementaire ) ) echo $tagSupplementaire;
?>
	</head>
	<body onload="initialize()">
<!-- phpdigExclude -->
<?php
require_once $prefixe . '../includes/librairie.php';
require_once $prefixe . 'includes/librairie.php';
// En-tête -->
echo '<div id="header">';
echo	'<img src="' . $prefixe . '../images/logo100.gif" alt="logo CPE">';
echo 	'<div style="float:right;">';
$login = getLogin();
if( $login === false
	AND ( !isset( $autoriseActifM1 ) ) )	//	pour autoriser accès aux logins avec statut==-1
	{
	echo '<br>Accès refusé par ACTenTetes<br>';
	exit;
	}
echo 	$login;
echo	'</div>';
echo	'<p>CPE - Espace Adhérents Actifs</p>';
echo '</div>';

$lesTokens = explode( "\\", recupCookie( ) );
$autorisation = $lesTokens[1];
// Menu accès rapide -->
echo '<ul id="menuhaut">';
//if( in_array( $login, array( 'croy','pgrenon','flindet','pricour' ) ) )
	echo	'<li><a href="' . $prefixe . 'ACTMailsCPE.php">Mails CPE - <li>';
echo	'<li><a href="#" accesskey="1" onClick="popitup'
	. '(\'' . $prefixe . 'ACTContact.php\',\'Contact\')">Contact - </li>';
echo	'<li><a href="' . $prefixe . 'ACTAssistance.php" accesskey="2">Assistance - </li>';
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
	onclick="window.open(this.href);return(false);"><script type="text/javascript">
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
	<div id="global">
		<h1>Opérations Terrain CPE</h1>

<div id="wrapper">
	<div id="map_canvas"></div>
	<div id="legend"> binôme Valérie Lemercier et Coluche </div>
</div>
<!--		<div>
			<input id="address" type="textbox" value="135 rue Alésia,Paris">
			<input type="button" value="Encode" onclick="codeAddress()">
		</div>-->
	</body>
</html>