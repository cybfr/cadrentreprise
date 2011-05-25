<!-- en-têtes -->
<?php
$titrePage = "forum, répondre";
$sncfLibelles = array('Accueil',"Forum","Fil");
$sncfLiens = array( 'ACTAccueil.php','forumIndex.php' );
require "includes/ACTenTetes.php";
require "../includes/mySql.php";

$lIdFil = $_GET['idFil'];
$lIdMessage = $_GET[ 'idMessage' ];
?>
<!-- Contenu -->
		<div id="global">
<?php
	echo '<h1>Forum Futuroscope - répondre (fil '
		. $lIdFil . ' message ' . $lIdMessage . ')</h1>';
if( !isset( $_GET[ 'leTexte' ] ) )
	{
?>
	<h2>Saisie du message</h2>
	<form name="leF" action="forumRepondre.php" method="get">
<?php
echo	'<input type="hidden" name="idFil" value="' . $_GET['idFil'] . '">';
echo	'<input type="hidden" name="idMessage" value="' . $_GET['idMessage'] . '">';
?>
	<table style="text-align:right;">
		<tr><td>texte du message </td>
			<td>
				<textarea rows="4" name="leTexte" cols="70" title="saisissez le commentaire"></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<div class="formBouton" style="padding-top:50px;text-align:left;">
					<input type="image" src="../images/btnValider.gif">
				</div>
			</td>
		</tr>
	</table>
<?php
	}
else
	{
	$query = "INSERT INTO f01Messages (idFil,idMessageRepondu,auteur,texte) values("
		. $lIdFil . ","
		. $lIdMessage . ","
		. "'" . $login . "',"
		. "'" . getEscapedString( 'leTexte' ) . "'"
		. " )";
	$result = mysql_query($query);	// or die("erreur 3");
	if( $result )
		echo '<h2>Réponse prise en compte</h2>';
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
	}
?>
	</body>
</html>