<!-- en-têtes -->
<?php
$titrePage = "forum, mise en avant message";
$sncfLibelles = array('Accueil',"Forum","Fil");
$sncfLiens = array( 'ACTAccueil.php','forumIndex.php' );
require_once "includes/ACTenTetes.php";
require_once "includes/librairie.php";
require_once "../includes/mySql.php";

$lIdFil = $_GET[ 'idFil' ];
$lIdMessage = $_GET[ 'idMessage' ];
$lEnAvant = $_GET[ 'enAvant' ];
?>
<!-- Contenu -->
		<div id="global">
<?php
	echo '<h1>Forum Futuroscope - inversion mise en avant ';

	$query = "UPDATE f01Messages"
		. " SET enAvant=" . ($lEnAvant==1?0:1)
		. ",date=date"
		. " WHERE id=". $lIdMessage;
	$result = mysql_query($query);	// or die("erreur 3");
	if( $result )
		{
require_once "forumGenereRSS.php";
		echo '<h2>Inversion prise en compte : le message';
		if( $lEnAvant == 1 )
			echo ' n\'est maintenant plus';
		else
			echo ' est maintenant';
		echo ' mis en avant</h2>';
		}
	else
		{
	    $message  = 'Requête invalide : ' . mysql_error() . "\n";
	    $message .= '<br>Requête complète : ' . $query;
	    echo $message;
		}

	echo '</div>';
	echo '<div id="btnRetour">';
	echo 	'<a href="forumMessages.php'
				. '?id=' . $lIdFil . '">';
	echo		'<img src="../images/btnRetour.gif" border="0">';
	echo '</a></div>';
?>
	</body>
</html>