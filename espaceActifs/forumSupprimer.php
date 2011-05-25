<!-- en-têtes -->
<?php
$titrePage = "forum, supprimer message";
$sncfLibelles = array('Accueil',"Forum","Fil");
$sncfLiens = array( 'ACTAccueil.php','forumIndex.php' );
require "includes/ACTenTetes.php";
require "../includes/mySql.php";

$leType = $_GET['type'];
$lIdFil = $_GET['idFil'];
$lIdMessage = $_GET[ 'idMessage' ];
?>
<!-- Contenu -->
		<div id="global">
<?php
	echo '<h1>Forum Futuroscope - supprimer (type '
		. $leType . ' fil '
		. $lIdFil . ' message ' . $lIdMessage . ')</h1>';
if( !isset( $_GET[ 'laConfirmation' ] ) )
	{
?>
	<h2>Confirmation</h2>
	<form name="leF" action="forumSupprimer.php" method="get">
<?php
echo	'<input type="hidden" name="type" value="' . $leType . '">';
echo	'<input type="hidden" name="idFil" value="' . $lIdFil . '">';
echo	'<input type="hidden" name="idMessage" value="' . $lIdMessage . '">';
?>
	<table>
		<tr><td>confirmez la suppression
<?php
if( $leType == "fil" )
	echo " du fil id " . $lIdFil;
else
	echo " du message id " . $lIdMessage . ' dans le fil id ' . $lIdFil;
?>
 			</td>
			<td>
				<select name="laConfirmation">
					<option value="oui" selected="true">oui</option>
					<option value="non">non</option>
				</select>
			</td>
		</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<div class="formBouton" style="padding-top:50px;">
						<input type="image" src="../images/btnValider.gif">
					</div>
				</td>
			</tr>
	</table>
<?php
	}
else
	{
	$laConfirmation = $_GET['laConfirmation'];
	if( $laConfirmation != "oui" )
		echo '<p>Suppression annulée</p>';
	else
		{
		if( $leType == 'fil' )
			{
			$query = 'UPDATE f01Fils SET actif=0,date=date'
				. ' WHERE id=' . $lIdFil;
			}
		else
			{
			$query = 'UPDATE f01Messages SET actif=0,date=date'
				. ' WHERE idMessageRepondu is not null AND id=' . $lIdMessage;
			}
		$result = mysql_query($query);	// or die("erreur 3");
		if( $result )
			echo '<p>Suppression prise en compte</p>';
		else
			{
		    $message  = 'Requête invalide : ' . mysql_error() . "\n";
		    $message .= '<br>Requête complète : ' . $query;
		    echo $message;
			}
		}

	echo '<div id="btnRetour">';
	echo '<a href="forumMessages.php'
			. '?id=' . $lIdFil . '">';
	echo	'<img src="../images/btnRetour.gif" border="0">';
	echo '</a></div>';
	}
?>
		</div>
	</body>
</html>