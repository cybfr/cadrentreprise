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
$titrePage = "données";
$sncfLibelles = array( 'Accueil', 'Données' );
$sncfLiens = array( 'ACTAccueil.php' );
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
		<div id="global" style="margin:0px;padding:0px 20px 0px 20px;">
			<h1>Réseau CPE</h1>
<?php
require_once '../includes/librairie.php';
require_once 'includes/librairie.php';

$lIdAdherent = $_GET['lIdAdherent'];
if( !is_numeric( $lIdAdherent ) )
	{
	die( "L'id n'est pas numérique" );
	}
// Connexion et sélection de la base
require "../includes/mySql.php";
//	colonnes à sélectionner --> $lesColonnes
$lesColonnes = listeColonnesAutorisees( "*", "A", $inutile );
$query = "SELECT " . $lesColonnes . ",M.id as idG,M.derniereEdition"
	. " FROM tblAdherents A LEFT OUTER JOIN tblMiniCV M ON A.id=M.idAdherent";
$query .= " WHERE A.id = " . $lIdAdherent;
$query .= " ORDER BY nom, prenom, idG";
$result = mysql_query($query);	// or die("erreur 3");
if( !$result )
	{
    $message  = 'Requête invalide : ' . mysql_error() . "\n";
    $message .= 'Requête complète : ' . $query;
    die($message);
	}
$lesColsPasAffichees = array( "idG", "id", "nom","prenom","derniereEdition","photo" );
$rang = 0;
$lIdAdherentEnCours = -1;
while( ($line = mysql_fetch_assoc($result)) )
	{
	if( $lIdAdherentEnCours != $line[id])
		{	// changement de personne ==> affichage projets adh précédent puis entête personne
		//	photo
		echo '<div style="float:right">';
		echo 	'<img src="../photosId/id' . $line[id] . '.png" border="1">';
		echo '</div>';
		//
		echo '<h2>Personne : ' . $line[id] . '-' . $line['prenom']. ' ' . $line['nom'] . '</h2>';
		echo '<table cellspacing="5" style="padding-left:40px;">';
		$lIdAdherentEnCours = $line[id];

		foreach( $line as $key=>$value )
			{
			if( ! in_array( $key, $lesColsPasAffichees ) )
				{
				if( $value == 'null' )
					$value = '';
				else
					{
					if( substr( $key,0,4) == "date" )
						{
						$laDate = explode( "-", $value );
						$value = $laDate[1] . "/" . $laDate[0];
						}
					else if( $key == "commentairesACTIF" )
						{
						if( $_SERVER['HTTP_HOST'] != 'localhost' )
							$value = utf8_encode( nl2br( $value ) );
						else
							$value = nl2br( $value );
						}
					}	
				echo '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>';
				}
			}
		}
	$lesMiniCVs .= $line[ 'idG' ];
	if( is_null( $line[ 'derniereEdition' ] ) )
		$lesMiniCVs .= '(actif), ';
	else
		$lesMiniCVs .= '(inactif), ';
	$rang++;
	}
$lesMiniCVs = substr( $lesMiniCVs, 0, strlen( $lesMiniCVs )-2 );
echo '<tr><td>Projets Flash</td><td>' . $lesMiniCVs . '</td></tr>';
echo '</table>';
?>
			<div id="btnRetour">
				<a href="ACTreseauCPE.php?">
					<img src="../images/btnRetour.gif" border="0">
				</a>
			</div>
		</div>
	</body>
</html>