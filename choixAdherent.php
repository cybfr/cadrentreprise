<?php
//	Description des paramètres :
//
//	Premier appel (depuis script autre) :
//		'urlRetour'		(obligatoire) url à laquelle on doit revenir après choix d'une personne
//		autres			(optionnels) tous autres param (ne pas utiliser noms des param pour appels récursifs)
//		exemple : http://.....choixAdherent.php?urlRetour=index.php&jour:09/10/2007
//	Autres param pour appels (récursifs)
//		'urlRetour'		même param au premierappel
//		'paramsAutres'	param autres du premier appel ( &nom1=valeur1&nom2=valeur2...)
//		'idOuNom'		l'id ou la partie de nom saisie dans le formulaire
//		'idSel'			id de la persone sélectionnée dans le popup
//	Paramètres en retour :
//		'lIdAdherent'	id de la personne sélectionnée
//		plus tous les param "autres" en entrée au premier appel

//require '../includes/librairie.php';
require 'includes/librairie.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 STRICT//EN" "http://www.w3.org/YT/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>CPE - choix d'une personne</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="css/stylePrint.css" media="print" />
		<meta name="robots" content="noindex,nofollow">
		<script language="JavaScript">		<!--		function recharger()
			{
			lesParams = "?idOuNom=" + document.leF.idOuNom.value
				+ "&urlRetour=" + document.leF.urlRetour.value
				+ "&paramsAutres=" + document.leF.paramsAutres.value;
			box = document.leF.idSel;
			if( box )
				{				lIdSel = box.options[box.selectedIndex].value;
				lesParams = lesParams
					+ "&idSel=" + lIdSel;
				}
			window.location="choixAdherent.php"
				+ lesParams;
			}		//-->		</script>
		<style type="text/css">
			.main {width:200px; border:1px solid black;}
			.main img {border:0px solid black;}
		</style>
	</head>
	<body>
<?php
if( !isset( $_GET['urlRetour'] ) )
	{
	echo "appel illégal";
	exit;
	}

//	urlRetour --> $urlRetour
//	autres paramètres reçus au premier appel --> $paramsAutres
$urlRetour = $_GET['urlRetour'];

//if( isset( $_GET['paramsAutres' ] ) )
//	$paramsAutres = $_GET['paramsAutres' ];
//else
	{
	$rang = 0;
	$paramReserves = array( 'urlRetour', 'idSel', 'idOuNom' );
	foreach( $_REQUEST as $key => $value )
		{
		if( !in_array( $key, $paramReserves )  )
			{
			if( $rang == 0 )
				$paramsAutres = '&';
			else
				$paramsAutres .= '&';
			if( !is_array( $value ) )
				$paramsAutres .= $key . '=' . $value;
			else
				{
				$ii = 0;
				foreach($value as $k => $v )
					{
					if( $ii > 0 ) $param .= '&';
					//$paramsAutres .= $key . '[' . $k . ']=' . $v;
					$paramsAutres .= $key . '[' . $k . ']';
					$ii++;
					}
				}
			$rang++;
			}
		}
	}
//$paramAutres = urlencode( $paramAutres );
//echo '<br>$paramsAutres...' . $paramsAutres;
if( isset( $_GET['idOuNom'] ) )
	{
	$lIdOuNom = $_GET['idOuNom'];
	require "includes/mySql.php";
	if( is_numeric( $lIdOuNom ) )
		{
		$query = "SELECT id,nom,prenom FROM tblAdherents";
		$query .= " WHERE id =" . $lIdOuNom . "";
		$query .= " ORDER BY nom";
		}
	else
		{
		$query = "SELECT id,nom,prenom FROM tblAdherents";
		$query .= " WHERE nom like '%" . $lIdOuNom . "%'";
		$query .= " ORDER BY nom";
		}
	$result = mysql_query($query);	// or die("erreur 3");
	if( !$result )
		{
	    $message  = 'Requête invalide : ' . mysql_error() . "\n";
	    $message .= 'Requête complète : ' . $query;
	    die($message);
		}
	$nbrAdherents = mysql_num_rows($result);
	while( ($line = mysql_fetch_assoc($result)) )
		{
		$leTitre[] = Array( 'id'=>$line[ 'id' ],
			'nom' => stripcslashes( $line[ 'prenom' ] ) . ' ' . stripcslashes( $line[ 'nom' ] ) );
		}
	}
else
	{
	$nbrAdherents = 0;
	$lIdOuNom = "";
	}

if( isset( $_GET[ 'idSel' ] ) )
	$lIdSel = $_GET[ 'idSel' ];
else
	$lIdSel = "";
?>
	<body>
		<div id="global" style="margin:0px;padding:0px 20px 0px 20px;">
		<h1>choix d'une personne</h1>
			<form name="leF" action="choixAdherent.php" method="get">
<?php
echo			'<input type="hidden" name="urlRetour" value="' . $urlRetour . '">';
echo			'<input type="hidden" name="paramsAutres" value="' . $paramsAutres . '">';
?>
				<table>
					<tr>
						<td width="20%" style="padding-left:20px;">
							id ou partie du nom
						</td>
						<td width="20%">
<?php
echo 						'<input type="input" name="idOuNom" size="20" maxlength="35" value="'
								. $lIdOuNom . '" onChange="javascript:recharger();">';
echo 					'</td><td width="30%">';
echo 						'<input type="button" value="Rechercher" onClick="javascript:recharger();">';
echo					'</td></tr>';
echo 				'<tr height="20"><td colspan="3"></tr>';
echo 				'<tr>';
if( $nbrAdherents == 0 )
	{
	echo				'<td colspan="3"  style="padding-left:20px;">';
	echo 					'Aucune personne pour cet id ou ce nom';
	echo					'<br />Pour poursuivre, veuillez sélectionner une personne.';
	echo			'</td><td>&nbsp;';
	}
elseif( $nbrAdherents > 1 )
	{
	echo 			'<td style="padding-left:20px;">';
	echo				$nbrAdherents . ' Personne(s) trouvée(s) :';
	echo 			'</td><td>';
	echo				'<select id="idSel" style="width:200px;"  onChange="javascript:recharger();">';
	$i = $idxIdSel = 0;
	foreach( $leTitre as $laValeur )
		{
		echo 				'<option value="' . $laValeur['id'];
		if( $i == 0 )
			{
			echo				'" selected>' . $laValeur['nom'] . '</option>';
			if( $lIdSel == "" ) $lIdSel = $laValeur['id'];
			}
		else
			{
			if( $lIdSel == $laValeur['id'] )
				{
				$idxIdSel = $i;
				echo				'" selected>' . $laValeur['nom'] . '</option>';
				}
			else
				echo				'">' . $laValeur['nom'] . '</option>';
			}
		$i++;
		}
	echo				'</select></td></tr><tr><td>&nbsp;</td><td>';
	echo 				'Vous pouvez sélectionner una autre Personne.';
	}
else
	$idxIdSel = 0;
echo				'</td></tr>';
if( $nbrAdherents >= 1 )
	{
	echo 		'<tr><td>';
	echo			'<input type="hidden" name="leTitre" value="' . $leTitre[0]  . '">';
	echo			'<b>Personne sélectionnée</b>';
	echo		'</td><td>';
	$lIdSel = $leTitre[ $idxIdSel ]['id'];
	echo			'<b>' . $lIdSel . '-' . $leTitre[ $idxIdSel ]['nom'] . '</b>';
	}
echo				'</td></tr>';
echo		'</table>';
echo		'<div class="formBouton">';
echo			'<a href="' . $urlRetour . '?' . $paramsAutres . '">';
echo				'<img src="images/btnAnnuler.gif" border="0">';
echo			'</a>';
if( $nbrAdherents >= 1 )
	{
	echo			'<a href="' . $urlRetour . '?lIdAdherent=' . $lIdSel . '&action[modifier]' . '&amp;' . $paramsAutres . '">';
	echo				'<img src="images/btnValider.gif" border="0">';
	echo			'</a>';
	echo		'</div>';
	}
?>
		</form>
	</body>
</html>