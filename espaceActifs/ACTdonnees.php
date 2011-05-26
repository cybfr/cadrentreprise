<?php
$titrePage = "données personnelles";
$sncfLibelles = array( 'Accueil', 'Données' );
$sncfLiens = array( 'ACTAccueil.php' );
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
		<div id="global">
			<h1>Mes données personnelles</h1>
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
	if( !is_numeric( $lIdAdherent ) )
		die( "L'id n'est pas numérique" );
	//	colonnes à sélectionner --> $lesColonnes
	$query = "SELECT A.*,M.id as idG,M.idRubrique as idRubrique,M.titre as titre,M.derniereEdition"
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
	$lesColsPasAffichees = array( "photo", "idG", "id", "nom","prenom","derniereEdition", 'domaine', 'idRubrique', 'titre' );
	$rang = 0;
	$lIdAdherentEnCours = -1;
	while( ($line = mysql_fetch_assoc($result)) )
		{
//echo '<br>...' . strlen( $line['photo'] );
		if( $lIdAdherentEnCours != $line[id])
			{	// changement de personne ==> affichage projets adh précédent puis entête personne
			//	photo
			echo '<div style="float:right">';
			echo 	'<img src="../photosId/id' . $lIdAdherent . '.png" alt="Photo" />';
			echo	'<p><a href="ACTphotoCharge.php?id=' . $lIdAdherent . '">';
			echo		'pour charger une nouvelle photo';
			echo	'</a></p>';
			echo	'<p><a href="ACTphotoSupprime.php?id=' . $lIdAdherent . '">';
			echo		'pour supprimer cette photo';
			echo	'</a></p>';
			echo '</div>';
			//
			echo '<h2>' . $line[id] . '-' . $line['prenom']. ' ' . $line['nom'] . '</h2>';
			echo '<table cellpadding="0" cellspacing="0" style="padding-left:40px;">';
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
							if( $value == "" )
								$value = "&nbsp;";
							else
								{
								$laDate = explode( "-", $value );
								$value = $laDate[1] . "/" . $laDate[0];
								}
							}
						else if( $key == "rue" )
							{
							$key = "voie";
							}
						else if( $key == "commentairesACTIF" )
							{
							if( $_SERVER['HTTP_HOST'] != 'localhost' )
								$value = utf8_encode( nl2br( $value ) );
							else
								$value = nl2br( $value );
							}
						}	
					echo '<tr style="height:1.2em;padding:4px 40 2px 0">';
					echo	'<td>' . $key . '</td>';
					echo	'<td>' . $value . '</td></tr>';
					}
				}
			}
		if( $line[ 'idG' ] != '' )
			{
	if( isset( $line[ 'telephoneMobile' ] ) )
		$leTelephone = $line[ 'telephoneMobile' ];
	if( isset( $line[ 'telephoneFixe' ] ) )
		$leTelephone = $line[ 'telephoneFixe' ];
	else
		$leTelephone = '';
			if( is_null( $line[ 'derniereEdition' ] ) )
				{
				$lUrl = '<a href="../miniCVUnminiCV.php?'
					. 'retour=' . urlencode( 'espaceActifs/ACTdonnees.php' )
					. '&amp;idRubrique=' . urlencode( $line[ 'idRubrique' ] )
					. '&amp;titreProjet=' . urlencode( $line[ 'titre' ] )
					. '&amp;telephone=' . urlencode( $leTelephone )
					. '&amp;ref=' . $line[ 'idG' ] . '">' . $line[ 'titre' ] . '</a>';
				$lesMiniCVs .= $lUrl . ' (actif), ';
				$lUrl = '<a href="http://cadrentreprise.asso.fr/miniCVUnminiCV.php?'
					. '&amp;idRubrique=' . urlencode( $line[ 'idRubrique' ] )
					. '&amp;titreProjet=' . urlencode( $line[ 'titre' ] )
					. '&amp;telephone=' . urlencode( $leTelephone )
					. '&amp;ref=' . $line[ 'idG' ] . '">' . $line[ 'titre' ] . '</a>';
				$lesMiniCVs .= '&nbsp;&nbsp;&nbsp;&nbsp;Pour coller ce lien vers votre projet flash : cliquer droit sur le lien, copier puis coller." />';
				}
			else
				$lesMiniCVs .= '(inactif), ';
			}
		$rang++;
		}
	if( $lesMiniCVs == '' )
		$lesMiniCVs = 'aucun';
	else
		$lesMiniCVs = substr( $lesMiniCVs, 0, strlen( $lesMiniCVs )-2 );
	echo '<tr><td>Projets Flash</td><td>' . $lesMiniCVs . '</td></tr>';
	echo '</table>';
	?>
			<p>Si vous souhaitez modifier ces données, merci d'adresser un courriel au Webmestre (utilisez la rubrique "Contact")
			</p>
			<p>L'Association CPE dispose de moyens informatiques destinés à gérer plus facilement ses adhérents.</p>
			<p>Les informations enregistrées sont réservées à l’usage de CPE et ne peuvent être communiquées qu’aux membres de l'Association.
			</p>
			<p>Conformément aux articles 39 et suivants de la loi n° 78-17 du 6 janvier 1978 relative à l’informatique, aux fichiers et aux libertés,
				toute personne peut obtenir communication et, le cas échéant, rectification des informations la concernant, en s’adressant au Webmestre de CPE.
			</p> 
<!--<p id="teteDePage"></p>-->
		</div>
	</body>
</html>
