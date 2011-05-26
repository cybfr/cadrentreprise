<!-- en-têtes -->
<?php
//if( !isset( $_COOKIE['CPEid'] ) )
if(false)         // W3C validation item
	{	// cookie pas défini : on va vers l'authentification
		//	avec l'url cible en paramètre (dans cette url cible, l'ancre
		//	est délimitée par '.m.' et les param au delà du prmier par .p.
	$lUri = $_SERVER[ 'REQUEST_URI'];
	$lUrl = 'Location: ../identification1.php?url='
		. urlencode( $lUri );
	header( $lUrl );
	exit;
	}
$titrePage = "réseau";
$sncfLibelles = array( 'Accueil', 'Réseau CPE' );
$sncfLiens = array( 'ACTAccueil.php' );
require "includes/ACTenTetes.php";
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
echo	'<h1>Réseau CPE de ' . $login . '</h1>';

	$query = "SELECT count(*) as n FROM tblReseauCPE"
		. " WHERE idReseau=" . $lIdAdherent;
	$result = mysql_query($query) or die('<br>...'.$query.'<br>...'.mysl_error());
	$line = mysql_fetch_array($result);
	$nbrMembres = $line[ 'n' ];

	//	colonnes à sélectionner --> $lesColonnes
	$query = "SELECT R.idCible, A.id, A.nom, A.prenom, A.profession, A.formation, A.eMail, A.telephoneFixe, A.telephoneMobile, S.titre 'STitre', D.titre 'DTitre'"
		. " FROM tblAdherents as A,"
		.	" tblReseauCPE R, tblSousDomaines S, tblDomaines D"
		. " WHERE R.idReseau = " . $lIdAdherent
			. " AND A.id=R.idCible"
			. " AND A.domaine=S.id"
			. " AND S.idPere=D.id"
			//. " AND M.idAdherent = A.id"
			//. " AND tblMiniCV.domaine = S2.id"
			//. " AND S2.idPere = D2.id"
		. " ORDER BY nom, prenom";
	//echo '<br>...'.$query;
	$result = mysql_query($query) or die('<br>...'.$query.'<br>...'.mysql_error());
	//$nbrMembres = mysql_num_rows( $result );
	if( $nbrMembres == 0 )
		echo '<p>Aucun membre dans votre réseau</p>';
	else
		{
		echo '<h2>' . $nbrMembres . ' membres dans votre réseau</h2>';
		echo '<div style="margin-left:20px;margin-top:20px;">';
		echo '<table cellspacing="0" cellpadding="2">';
		echo	'<tr><th>id</th><th>nom</th><th>métier (adhérent)</th><th>profession (adhérent)</th><th>formation (adhérent)</th><th>métier (prjt flash)</th></tr>';
		$rangLgn = 0;
		while( ($line = mysql_fetch_array($result)) )
			{
			if( $rangLgn++ % 2 == 0 )
				echo '<tr style="background-color:bisque">';
			else
				echo '<tr>
				';
			$styleCellules = '';//border:1px solid black;border-bottom:none;border-top:none';
			echo	'<td style="' . $styleCellules . '">' . $line['id'] . '</td>';
			echo	'<td style="' . $styleCellules . '">';
			echo 	'<a href="#" onclick="javascript:popitup(\'ACTFicheAdherent.php'
						. '?prenomNom=' . urlencode($line[ 'prenom' ] . ' ' . $line[ 'nom' ] )
						. '&amp;fixe=' . $line['telephoneFixe']
						. '&amp;mobile=' . $line['telephoneMobile']
						. '&amp;email=' . $line['eMail'] 
						. '&amp;idAdherent=' . $line['id']
						. "','Fiche')\">";
			echo			$line[ 'prenom' ] . ' ' . $line[ 'nom' ];
			echo 	'</a></td>';
			if( $line['DTitre'] == 'Divers exclus' )
				$ssDomaine = 'Divers';
			else
				$ssDomaine = $line['DTitre'];
			if( $ssDomaine != 'Divers' AND $line['STitre'] != '' )
				$ssDomaine .= ' - ' . $line['STitre'];
			echo 	'<td style="' . $styleCellules . '">' . $ssDomaine . '</td>';
			echo 	'<td style="' . $styleCellules . '">' . $line['profession'] . '</td>';
			echo 	'<td style="' . $styleCellules . '">' . $line['formation'] . '</td>';
			$query2 = "SELECT S.titre 'STitre', D.titre 'DTitre'"
			. " FROM tblMiniCV as M, tblDomaines as D, tblSousDomaines as S"
			. " WHERE M.idAdherent = " . $line[ 'id' ]
			.	" AND M.domaine=S.id AND D.id=S.idPere";
			$result2 = mysql_query($query2) or die('<br>...'.$query2.'<br>...'.mysql_error());
			if( mysql_num_rows( $result2 ) == 0 )
				echo '
				</tr>';
			else
				{
				$rangCV = 0;
				while( ($line2 = mysql_fetch_array($result2)) )
					{
					if( $rangCV++ > 0 )
						{
			if( $rangLgn++ % 2 == 0 )
				echo '<tr style="background-color:bisque">';
			else
				echo '<tr>';
						echo '<td colspan="5" style="' . $styleCellules . '">&nbsp;</td>';
						}
					echo 	'<td style="' . $styleCellules . '">' . $line['DTitre'] . ' - ' . $line['STitre' ] . '</td>';
						$idAvant = $line[ 'id' ];
					echo '
					</tr>';
					}
				}
				}
			echo '</table></div>';
			echo '<p>Pour voir les informations pour un des membres du réseau : cliquer sur son nom</p>';
	}
		
	echo '<h2>Gestion des membres du réseau</h2>';
	echo '</div><div style="margin-left:20em;">';
	echo '<a href="ACTreseauCreer.php?idReseau=' . $lIdAdherent . '">';
	echo	'<img src="../images/btnAjouter.png" alt="Ajouter" />';
	echo '</a>';
	if( $nbrMembres > 0 )
		{
		echo '<a href="ACTreseauSupprimer.php?idReseau=' . $lIdAdherent . '">';
		echo	'<img src="../images/btnSupprimer.gif" alt="Supprimer" />';
		echo '</a>';
		}
	echo '</div>';
?>
			<div id="btnRetour">
				<a href="ACTAccueil.php?">
					<img src="../images/btnRetour.gif" alt="Retour" />
				</a>
			</div>
	</body>
</html>