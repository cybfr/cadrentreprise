<?php
$titrePage = 'adhérents';
$sncfLibelles = array( 'Accueil', 'Adhérents CPE' );
$sncfLiens = array( 'ACTAccueil.php' );
require "includes/ACTenTetes.php";
?>
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
<?php
// Connexion et sélection de la base
require "../includes/mySql.php";

//	id adhérent correspondant au login --> $lIdAdherent
$query = "SELECT idAdherent FROM tblMdp WHERE login='" . $login . "'";
$result = mysql_query($query);	// or die("erreur 3");
if( !$result )
	{
	$message  = 'Requête invalide : ' . mysql_error() . "\n";
	$message .= 'Requête complète : ' . $query;
	die($message);
	}
$line = mysql_fetch_assoc($result);
$lIdAdherent = $line['idAdherent'];

echo '<div id="global">';
echo '<h1>Contacter un Adhérent CPE</h1>';

$nbrAdherents = 0;
if( isset( $_GET[ 'idOuNom' ] ) OR isset( $_GET[ 'prenom' ] ) )
	{	//	recherche de l'adhérent
	
	$query = "SELECT * FROM tblAdherents"
		. " WHERE Statut IN ('ACTIF', 'INTER', 'BENEVOLE' )";
	if( isset( $_GET[ 'idOuNom' ] ) )
		{
		if( ctype_digit( $_GET[ 'idOuNom' ] ) )
			$query .= " AND id=" . $_GET[ 'idOuNom' ];
		else	
			$query .= " AND  nom like '%" . $_GET[ 'idOuNom' ] . "%'";
		}
	else
		$query .= " AND prenom = '" . $_GET[ 'prenom' ] . "'";
	$res = mysql_query($query) or die( '<br>...'.$query.'<br>...'.mysql_error());
	$nbrAdherents = mysql_num_rows( $res );
	$tabIds = array();
	$tabPrenomsNoms = array();
	while( $l=mysql_fetch_assoc( $res ) )
		{
		$tabIds[] = $l[ 'id' ];
		$tabPrenomsNoms[] = $l[ 'prenom' ] . ' ' . $l[ 'nom' ];
		}
	}
if( true )
	{	//	choix adhérent
	echo '<form id="leF" action="ACTadherents.php" method="get" style="margin-top:5em;">';
	echo '<table>';
	echo	'<tr><td>id ou tout ou partie du nom de l\'adhérent</td>';
	echo		'<td><input type="text" name="idOuNom" value="' . $_GET[ 'idOuNom' ] . '" /></td></tr>';
	echo	'<tr><td colspan="2">&nbsp;&nbsp;&nbsp;ou bien</td></tr>';
	echo	'<tr><td>prénom de l\'adhérent</td>';
	echo		'<td><input type="text" name="prenom" value="' . $_GET[ 'prenom' ] . '" /></td></tr>';
	echo	'<tr><td>&nbsp;</td><td>';
	echo		'<input type="button" value="Rechercher" onclick="javascript:recharger();" /></td></tr>';
	echo	'<tr>';
	if( $nbrAdherents == 0 )
		echo '<td colspan="2">Aucun adhérent sélectionné';
	elseif( $nbrAdherents == 1 )
		{
		echo '<td colspan="2">';
		mysql_data_seek( $res, 0 );
		$l = mysql_fetch_assoc( $res );
		$lUrl = 'ACTFicheAdherent.php'
			. '?prenomNom=' . urlencode( $tabPrenomsNoms[0] )
			. '&amp;fixe=' . $l['telephoneFixe']
			. '&amp;mobile=' . $l['telephoneMobile']
			. '&amp;email=' . $l['eMail'] 
			. '&amp;idAdherent=' . $l['id']
			. '&amp;statut=' . $l[ 'statut' ];
		echo	'<a style="text-decoration:underline" onclick="popitup(\'' . $lUrl
					. '\',\'Fiche\');return false;" >';
		echo		$tabIds[0] . '-' . $tabPrenomsNoms[0] . ' sélectionné';
		echo	'</a>';
		}
	else
		{
		echo '<td>Plusieurs adhérents trouvés, choisissez en un</td>';
		echo '<td><select name="noms" onclick="recharger2()" >';
		foreach( $tabIds as $k=>$id )
			echo '<option value="' . $id . '" >' . $tabPrenomsNoms[$k] . '</option>';
		echo '</select>';
		}
	echo		'</td></tr>';
	echo '</table>';
	echo '</form>';
	}
else
	{	// ouverture fiche
	exit;
	}
?>			<div id="btnRetour">
				<a href="ACTAccueil.php?">
					<img src="../images/btnRetour.gif" alt="Retour" />
				</a>
			</div>
		</div>
	</body>
</html>