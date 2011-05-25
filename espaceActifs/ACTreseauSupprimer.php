<!-- en-têtes -->
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
$titrePage = "réseau, supprimer";
$sncfLibelles = array( 'Accueil', 'Réseau CPE', "Supprimer" );
$sncfLiens = array( 'ACTAccueil.php', 'ACTreseauCPE.php' );
require "includes/ACTenTetes.php";
require "../includes/mySql.php";
?>
<!-- Contenu -->
		<div id="global">
			<h1>Suppression de contacts de votre réseau CPE</h1>
<?php
$leTableauAction = $_GET[ 'action' ];
if( isset( $leTableauAction[ 'Supprimer' ] ) )
	$lAction = 'Supprimer';

if( $lAction != 'Supprimer' )
	{
?>
			<form name="leF" action="ACTreseauSupprimer.php" method="get">
<?php echo		'<input type="hidden" name="idReseau" value="' . $_GET['idReseau'] . '">'; ?>
				<table border="0">
					<col width="5%"><col width="35%"><col width="35%">
					<tr><td>&nbsp;</td><td colspan="2">
						<h2>choix des contacts à retirer de votre réseau CPE</h2>
					</td></tr>
					<tr>
						<td>&nbsp;</td><td><table border="0"><tr><th>&nbsp;</th><th>id</th><th>nom</th></tr>
<?php
$query = "SELECT R.idCible, A.id, A.nom, A.prenom"
	. " FROM tblAdherents A, tblReseauCPE R"
	. " WHERE R.idReseau = " . $_GET['idReseau']
		. " AND A.id=R.idCible"
	. " ORDER BY nom, prenom";
$result = mysql_query($query) or die('<br>...'.$query.'.<br>...'.mysql_error());
while( $line = mysql_fetch_array( $result ) )
	{
	//echo						'<option value="' . $line['idCible'] . '">' . $line['prenom'] . ' ' . $line['nom'] . '</option>';
	echo '<tr>';
	echo	'<td><input type="checkbox" name="' . $line[ 'idCible' ] . '"></td>';
	echo	'<td>' . $line['id'] . '</td>';
	echo	'<td>' . $line['prenom'] . ' ' . $line['nom'] . '</td>';
	echo '</tr>';
	}
echo '</table></td>';
?>
					</tr>
					<tr height="20"><td colspan="3"></tr>
<script>
	function selectAll( statut )
		{
		var x=document.leF;
		for( var i=0; i<x.length; i++ )
			{
			if( x.elements[i].getAttribute("type") == 'checkbox' )
				x.elements[i].checked = statut;
			}
		}
</script>
					<tr><td>&nbsp;</td><td colspn="2"><p>Sélectionnez les contacts à retirer de votre réseau en cochant les cases correspondantes.</p>
						<p>Puis cliquez Supprimer</p></td>
					</tr>
					<tr><td>&nbsp;</td><td colspan="2">
						<a onclick="javascript:selectAll(true);return false;" style="text-decoration:underline">tout sélectionner</a>&nbsp;&nbsp;&nbsp;
						<a onclick="javascript:selectAll(false);return false;" style="text-decoration:underline">tout désélectionner</a>
					</td></tr>
				</table>
				<div class="formBouton" style="padding-top:20px;margin-left:20px;">
					<input type="image" src="../images/btnSupprimer.gif" name="action[Supprimer]" >
				</div>
			</form>
<?php
	}
else
	{	//	suppression du réseau
	// Connexion et sélection de la base
	require "../includes/mySql.php";
	$nbrSupprimes = 0;
	foreach( $_GET as $k=>$v )
		{
		if( !is_numeric( $k ) ) continue;
		//	colonnes à sélectionner --> $lesColonnes
		$query = "DELETE FROM tblReseauCPE"
			. " WHERE idReseau=" . $_GET['idReseau']
				. " AND idCible=" . $k;
		$result = mysql_query( $query ) or die('<br>...'.$query.'<br>...'.mysql_error());
		if( $result )
			$nbrSupprimes += mysql_affected_rows( );
		else
			break;
		}
	echo '<h3>' . $nbrSupprimes . ' contacts supprimés.</h3>';
	}
?>
		</div>
		<div id="btnRetour">
			<a href="ACTreseauCPE.php?">
				<img src="../images/btnRetour.gif" border="0">
			</a>
		</div>
	</body>
</html>