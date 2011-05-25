<?php
// En-tête -->
echo "\n" . '<!-- phpdigExclude -->' . "\n";
echo '<div id="header">';
echo	'<img src="images/logo100.gif" alt="logo CPE">';
echo	'<p>Cadres pour l\'Entreprise</p>';
echo '</div>';
// Menu accès rapide -->
echo '<ul id="menuhaut">';
echo	'<li><a href="index.php" accesskey="1">Retour à l\'accueil</a> - </li>';
echo	'<li><a href="#" accesskey="2" onClick="popitup'
	. "('contact.php','Contact')\">Contact - </li>";
echo	'<li><a href="identification1.php?dest=prives" accesskey="3">';
if( !isset( $_COOKIE['CPEid'] ) )
	echo 'Espaces privés';
else
	{
	$lesTokens = explode( "\\", $_COOKIE['CPEid'] );
	switch( $lesTokens[1] )
		{
		case 'actif' :
			echo 'Espace actifs';
			break;
		case 'ancien' :
			echo 'Espace anciens';
			break;
		default;
			echo 'Espaces privés';
		}
	}
echo 	'</a></li>';
echo '</ul>';
// Menu de navigation générale -->
//echo '<div id="teteDePage">';
echo 	'<div id="menu">';
echo		'<ul>';
echo			'<li><a href="index.php" accesskey="a" style="color:grey;">Accueil</a></li>';
echo			'<li><a href="K2%20actualites.php" accesskey="b">Actualités</a></li>';
echo			'<li><a href="K4%20cadres.php" accesskey="c">Vous êtes un cadre</a></li>';
echo			'<li><a href="K3%20entreprises.php" accesskey="d">Vous êtes une entreprise</a></li>';
echo		'</ul>';
// Formulaire de recherche -->
echo		'<p>Recherche</p>';
echo		'<form action="search/search.php" method="post">';
echo			'<div>';
echo				'<input type="text"  accesskey="r" name="query_string" class="champ" value="mot-clé" >';
echo				'<br><input type="submit" value=" ok " style="margin: 10px 0 0 20px;" >';
//echo				'<input type="hidden" name="option" value="exact" >';
if( isset( $sncfLibelles ) )
	{
	$i = 0;
	foreach( $sncfLibelles as $ii => $leLibelle )
		{
		echo '<input type="hidden" name="sncf[' . $leLibelle . ']" value="';
		if( $sncfLiens[$i] != '' )
			echo $sncfLiens[$i] . '" > ';
		else
			{
			if( $i == count( $sncfLibelles ) - 1 )
				{
				$lesSegs = explode( "/", $_SERVER['PHP_SELF'] );
				$leFichier = $lesSegs[ count( $lesSegs ) - 1 ];
				if( isset( $_GET['retour'] ) )
					{
					$leFichier .= '?retour=' . $_GET['retour'];
					if( isset( $_GET[ 'idRubrique' ] ) )
						$leFichier .= '&idRubrique=' . $_GET['idRubrique'];
					}
				echo $leFichier . '" > ';
				}
			else
				echo '" > ';
			}
		$i++;
		}
	}
echo			'</div>';
echo		'</form>';
// flèches précisant section en cours
if( false )
{
echo 		'<div style="position:absolute; top:';
$leTop = 3.3 + $lEtage*3.6;
echo 			$leTop . 'em; left:1em;">';
echo			'<img src="images/pointillesHorizontaux.gif">';
echo 		'</div>';
echo 		'<div style="position:absolute; top:0.3em; left:14.1em; text-align:right;">';
echo 			'<img src="images/pointilles' . $lEtage . '.gif">';
echo 		'</div>';
}
echo 	'</div>';
//	chemin de fer
echo 	'<div id="cdeFer">&nbsp;';
if( isset( $sncfLibelles ) )
	{
	$i = 0;
	foreach( $sncfLibelles as $ii => $leLibelle )
		{
		if( $sncfLiens[$i] != '' )
			echo ' > <a href="' . $sncfLiens[$i] . '" > ' . $leLibelle . '</a>';
		else
			echo ' > ' . $leLibelle;
		$i++;
		}
	}
echo 	'</div>';
if( isset( $nomPage ) AND $_SERVER['HTTP_HOST'] == 'cadrentreprise.free.fr' )
	{
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
