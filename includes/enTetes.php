<!-- En-tête -->
<!-- phpdigExclude -->
<div id="header">
<img src="images/logo100.gif" alt="logo CPE" />
<p>Cadres pour l'Entreprise</p>
</div>
<!-- Menu accès rapide -->
<ul id="menuhaut">
<li><a href="index.php" accesskey="1">Retour à l'accueil</a> - </li>
<li><a href="#" accesskey="2" onclick="popitup('contact.php','Contact')">Contact</a> - </li>
<li><a href="identification1.php?dest=prives" accesskey="3">
<?php
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
?>
</a></li>
</ul>
<!-- Menu de navigation générale -->
<div id="menu">
<ul>
<li><a href="index.php" accesskey="a" style="color:grey;">Accueil</a></li>
<li><a href="K2%20actualites.php" accesskey="b">Actualités</a></li>
<li><a href="K4%20cadres.php" accesskey="c">Vous êtes un cadre</a></li>
<li><a href="K3%20entreprises.php" accesskey="d">Vous êtes une entreprise</a></li>
</ul>
<!-- Formulaire de recherche -->
<p>Recherche</p>
<form action="search/search.php" method="post">
<div>
<input type="text"  accesskey="r" name="query_string" class="champ" value="mot-clé" />
<br /><input type="submit" value=" ok " style="margin: 10px 0 0 20px;" />
<input type="hidden" name="option" value="exact" />
<?php 

if( isset( $sncfLibelles ) )	{
	$i = 0;
	foreach( $sncfLibelles as $ii => $leLibelle )
		{
		echo '<input type="hidden" name="sncf[' . $leLibelle . ']" value="';
		if( $sncfLiens[$i] != '' )
			echo $sncfLiens[$i] . '" /> ';
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
						$leFichier .= '&amp;idRubrique=' . $_GET['idRubrique'];
					}
				echo $leFichier . '" /> ';
				}
			else
				echo '" /> ';
			}
		$i++;
		}
	}
?>
</div>
</form>
<?php 
// flèches précisant section en cours
if( false )
{
echo 		'<div style="position:absolute; top:';
$leTop = 3.3 + $lEtage*3.6;
echo 			$leTop . 'em; left:1em;">';
echo			'<img src="images/pointillesHorizontaux.gif" />';
echo 		'</div>';
echo 		'<div style="position:absolute; top:0.3em; left:14.1em; text-align:right;">';
echo 			'<img src="images/pointilles' . $lEtage . '.gif" />';
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
	onclick="window.open(this.href);return(false);">
	<script type="text/javascript">
	<!--
	var a_vars = Array();
	var pagename= <?php echo $nomPage ?>;
	var phpmyvisitesSite = 41478;
	var phpmyvisitesURL = "http://st.free.fr/phpmyvisites.php";
	//-->
	</script>
	<object>
	<script  type="text/javascript" src="http://st.free.fr/phpmyvisites.js">
	</script>
	<noscript> <p>phpMyVisites | Open source web analytics
	<img src="http://st.free.fr/phpmyvisites.php" alt="Statistics" />
	</p></noscript>
	</object>
	</a>
	</div>
	<!-- /phpmyvisites --> 
<?php
	}
echo "\n" . '<!-- phpdigInclude -->' . "\n";
?>
