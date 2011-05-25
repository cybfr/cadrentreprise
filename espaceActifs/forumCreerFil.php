<!-- en-têtes -->
<?php
$titrePage = "forum, créer un fil";
$sncfLibelles = array('Accueil','Forum','Création d\'un fil');
$sncfLiens = array( 'ACTAccueil.php','forumIndex.php' );
require "includes/ACTenTetes.php";
//require "includes/librairie.php";
require_once "../includes/mySql.php";
?>
<!-- Contenu -->
<div id="global">
<?php
	echo '<h1>Forum CPE - créer un fil de discussion</h1>';
if( !isset( $_GET[ 'leTitre' ] ) )
	{
?>
	<h2>Saisie du nouveau fil</h2>
	<form name="leF" action="forumCreerFil.php" method="get">
		<table>
			<tr>
				<td>titre : </td>
				<td>
					<input name="leTitre">
				</td>
			</tr>
			<tr>
				<td>texte : </td>
				<td>
					<textarea rows="4" name="leTexte" cols="70" title="saisissez le commentaire"></textarea>
				</td>
			</tr>
			<tr>
				<td>domaine</td>
				<td>
					<select name="domaine">
						<option value="Com.Web">Commission Web</option>
						<option value="Futuroscope">Futuroscope </option>
						<option value="Générique">Générique</option>
						<option value="Salons">Salons</option>
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
	//	création du fil
	$query = "INSERT INTO f01Fils (statut,sujet,domaine,auteur) values("
		. "'OUVERT'" . ","
		. "'" . getEscapedString( 'leTitre' ) . "',"
		. "'" . getEscapedSTring( 'domaine' ) . "',"
		. "'" . $login . "'"
		. " )";
	$result = mysql_query($query);	// or die("erreur 3");
	if( !$result )
		{
	    $message  = 'Requête invalide : ' . mysql_error() . "\n";
	    $message .= '<br>Requête complète : ' . $query;
	    echo $message;
		}
	else
		{ //	id du nouveau fil --> $lIdFil
		$query = "SELECT id from f01Fils ORDER BY id DESC LIMIT 1";
		$result = mysql_query($query);	// or die("erreur 3");
		$line = mysql_fetch_assoc($result);
		$lIdFil = $line[ 'id' ];
		//	création du premier message
		$query = "INSERT INTO f01Messages (idFil,auteur,texte) values("
			. $lIdFil . ","
			. "'" . $login . "',"
			. "'" . getEscapedString( 'leTexte' ) . "'"
			. " )";
		$result = mysql_query($query);	// or die("erreur 3");
		if( $result )
			echo '<h2>Création effectuée</h2>';
		else
			{
		    $message  = 'Requête invalide : ' . mysql_error() . "\n";
		    $message .= '<br>Requête complète : ' . $query;
			echo $message;
			}
		}
	//
	echo '</div>';
	echo '<div id="btnRetour">';
	echo '<a href="forumIndex.php">';
	echo	'<img src="../images/btnRetour.gif" border="0">';
	echo '</a></div>';
	}
?>
		</body>
		</html>