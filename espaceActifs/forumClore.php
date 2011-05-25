<!-- en-têtes -->
<?php
$titrePage = "forum, clore un fil";
$sncfLibelles = array('Accueil',"Forum","Fil");
$sncfLiens = array( 'ACTAccueil.php','forumIndex.php' );
require "includes/ACTenTetes.php";
require "../includes/mySql.php";

$lId = $_GET['id'];
$lIdFil = $lId - ord(substr($login,2,1)) + ord(substr($login,1,1));
?>
<!-- Contenu -->
		<div id="global">
<?php
	echo '<h1>Forum CPE - clore ('
		. $lIdFil . ')</h1>';
if( !isset( $_GET[ 'laConfirmation' ] ) )
	{
?>
	<h2>Confirmation</h2>
	<form name="leF" action="forumClore.php" method="get">
<?php
echo	'<input type="hidden" name="id" value="' . $lId . '">';
?>
	<table style="text-align:right;">
		<tr><td>confirmez la clôture
<?php
echo " du fil id " . $lIdFil;
?>
 			</td>
			<td>
				<select name="laConfirmation">
					<option value="oui" selected="true">oui</option>
					<option value="non">non</option>
				</select>
			</td>
		</tr>
	</table>
	<br><br>
	<div class="formBouton">
		<input type="image" src="../images/btnValider.gif">
	</div>
<?php
	}
else
	{
	$laConfirmation = $_GET['laConfirmation'];
	if( $laConfirmation != "oui" )
		echo '<p>Clôture annulée</p>';
	else
		{
		$query = 'UPDATE f01Fils SET statut="clos",date=date'
			. ' WHERE id=' . $lIdFil;
		$result = mysql_query($query);	// or die("erreur 3");
		if( $result )
			echo '<h2>Clôture prise en compte</h2>';
		else
			{
		    $message  = 'Requête invalide : ' . mysql_error() . "\n";
		    $message .= '<br>Requête complète : ' . $query;
		    echo $message;
			}
		}
	}
	echo '</div>';
	echo '<div id="btnRetour">';
	echo '<a href="forumIndex.php'
			. '?id=' . $lIdFil . '">';
	echo	'<img src="../images/btnRetour.gif" border="0">';
	echo '</a></div>';
?>
	</body>
</html>