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
$titrePage = "réseau, ajout";
$sncfLibelles = array( 'Accueil', 'Réseau CPE', "Créer" );
$sncfLiens = array( 'ACTAccueil.php', 'ACTreseauCPE.php' );
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
		<div id="global">
			<h1>Ajout de personnes à mon réseau CPE</h1>
<?php
$leTableauAction = $_GET[ 'action' ];
if( isset( $leTableauAction[ 'Ajouter' ] ) )
	$lAction = 'Ajouter';
else if( isset( $leTableauAction[ 'Rechercher' ] ) )
	$lAction = 'Rechercher';
else
	$lAction = 'Saisir';

switch( $lAction )
	{
	case 'Saisir' :			// étape 1 - saisie des paramètres de sélection
		echo '<form name="leF" action="ACTreseauCreer.php" method="get">';
		echo	'<input type="hidden" name="idReseau" value="' . $_GET['idReseau'] . '">';
		echo	'<table border="0">';
		echo		'<col width="15%"><col width="80%">';
		echo		'<tr><td colspan="2">';
		echo			'<h2>choix des personnes à ajouter</h2>';
		echo		'</td></tr>';
		echo		'<tr><td align="right">nom</td>';
		echo			'<td><input name="nom"></td></tr>';
		echo		'<tr><td align="right">métier (projet flash)</td>';
		echo			'<td>';

		require "../includes/mySql.php";

		$query2 = "SELECT D.titre 'DTitre', S.id 'SId', D.id 'DId', S.idPere, S.titre 'STitre'"
			. " FROM tblDomaines as D, tblSousDomaines as S"
			. " WHERE S.idPere=D.id AND D.titre != 'Divers Exclus'"
			. " ORDER BY D.id,S.id";
		$r = mysql_query( $query2 ) or die( $query2 . "<br>" . mysql_error() );
		echo			'<select name="domaine">';
		echo				'<option value="tous">tous</option>';
		$domaineEnCours = 'azertyuiop';
		while( $lDom = mysql_fetch_assoc( $r ) )
			{
			if( $lDom[ 'idPere' ] != $domaineEnCours )
				{
				echo			'<option value="-' . $lDom[ 'DId' ] .'">';
				echo				$lDom[ 'DTitre' ] . '- total';
				echo			'</option>';
				$domaineEnCours = $lDom[ 'idPere' ];
				}
			echo			'<option value="' . $lDom[ 'SId' ] .'">';
			echo				'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $lDom[ 'STitre' ];
			echo			'</option>';
			}
		echo			'</select>';
		echo		'</td></tr>';
		echo		'<tr><td align="right">statut</td>';
		echo			'<td><select name="statut">';
		echo				'<option value="tous">tous</option>';
		echo				'<option value="ACTIF">en recherche d\'emploi</option>';
		echo				'<option value="INTER">emploi trouvé depuis peu</option>';
		echo				'<option value="ANCIEN">ancien</option>';
		echo				'<option value="BENEVOLE">bénévole</option>';
		echo			'</select>';
		echo		'</td></tr>';
		echo		'<tr><td>&nbsp;</td>';
		echo			'<td><p>Entrez une valeur dans chacun des champs que vous voulez utiliser';
		echo				'pour sélectionner les membres à ajouter à votre réseau.</p>';
		echo				'<p>Puis cliquez sur Rechercher. Les personnes sélectionnées seront alors affichées.</p></td>';
		echo		'</tr>';
		echo		'<tr><td colspan="2">';
		echo			'<div class="formBouton" style="margin-left:20px;margin-bottom:20px;">';
		echo				'<input type="image" src="../images/btnRechercher.gif" name="action[Rechercher]" >';
		echo			'</div>';
		echo		'</td></tr>';
		echo	'</table>';
		echo '</form>';
		break;
	case 'Rechercher' :	//		étape 2 - recherche dans la base des adhérents
// Pb lié aux adhérents avec domaine null ///////////////////////////////////////////////////
		// Connexion et sélection de la base
		require "../includes/mySql.php";
		if( $_GET[ 'domaine' ] == 'tous' )
			{
			$query = "SELECT A.id 'AId',nom,prenom,statut,idReseau,S.titre 'STitre', D.titre 'DTitre'"
			. " FROM tblAdherents as A"
				. " LEFT OUTER JOIN tblReseauCPE ON idCible=A.id,"
				. " tblSousDomaines as S, tblDomaines as D"
			. " WHERE S.id=A.domaine AND S.idPere=D.id"
				. " AND FIND_IN_SET( 'diners', integrerDansMailing )";
			}
		else
			{
			if( $_GET[ 'domaine' ] < 0 )
				{	// sélection d'un domaine entier
				$query2 = "SELECT id FROM tblSousDomaines WHERE idPere=" . (-$_GET[ 'domaine' ]);
				$result2 = mysql_query( $query2 ) or die( '<br>...'.$query2.'<br>...'.mysql_error() );
				$listeId = '';
				while( ( $l = mysql_fetch_assoc( $result2 ) ) )
					$listeId .= $l[ 'id' ] . ',';
				$query = "SELECT A.id 'AId',M.id,nom,prenom,statut,idReseau,S.titre 'STitre',D.titre 'DTitre'"
					. " FROM tblMiniCV as M, "
						. " tblAdherents as A LEFT OUTER JOIN tblReseauCPE as R ON idCible=A.id,"
						. " tblDomaines as D,"
						. " tblSousDomaines as S";
				$query .= " WHERE M.idAdherent=A.id"
					. " AND M.domaine IN (" . substr( $listeId,0,-1 ) . ")"
					. " AND D.id=" . -$_GET[ 'domaine' ]
					. " AND S.id=M.domaine";
				}
			else
				{	//	sélection d'un sous domaine précis
				$query = "SELECT A.id 'AId',M.id,nom,prenom,statut,idReseau,S.titre 'STitre',D.titre 'DTitre'"
					. " FROM tblMiniCV as M, "
						. " tblAdherents as A LEFT OUTER JOIN tblReseauCPE as R ON idCible=A.id,"
						. " tblDomaines as D";
				$query .= ",tblSousDomaines as S";
				$query .= " WHERE M.idAdherent=A.id"
					. " AND M.domaine =" . $_GET[ 'domaine' ]
					. " AND S.id=M.domaine"
					. " AND S.idPere=D.id";

				}
			}
		if( $_GET[ 'nom' ] != '' )
			$query .= " AND nom like '%" . $_GET['nom' ] . "%'";
		if( isset( $_GET[ 'statut' ] ) AND $_GET[ 'statut' ] != 'tous' )
			{
			$query .= " AND statut"
				. " = '" . $_GET[ 'statut' ] . "'";
			}
		$query .= " ORDER BY DTitre,STitre,nom";
		$result = mysql_query( $query ) or die( '<br>...'.$query.'<br>...'.mysql_error() );
		//echo '<br>...' . $result . '...' . mysql_num_rows( $result );
		$nbrAdherents = mysql_num_rows( $result );
		if( $nbrAdherents == 0 )
			echo '<h2>Aucune personne trouvée</h2>';
		else if( $nbrAdherents > 20 )
			echo '<h2>Trop de personnes trouvées (' . $nbrAdherents . ' : 20 au plus</h2>';
		else
			{
	//		echo '<table border="1" cellspacing="0" cellpadding="2"><tr><td>Nom</td><td>domaine</td><td>sous-domaine</td><td>Statut</td></tr>';
			echo '<table border="1" cellspacing="0" cellpadding="2"><tr><td>Nom</td><td>Statut</td></tr>';
			$listeIdAdherents = '';
			$adherentsDejaIntegres = false;
			$adherentsAIntegrer = false;
			$adherentEnCours = '';
			while( $line=mysql_fetch_array( $result ) )
				{	// bcle sur les adhérents
				if( $line[ 'AId' ] != $adherentEnCours )
					{	// chgt d'adhérent
					if( $adherentEnCours != '' )
						{
						if( $ajouterCetAdherent )
							{
							echo '<tr style="font-weight:bold;">';
							$listeIdAdherents .= $adherentEnCours . ',';
							}
						else
							echo '<tr style="font-style:italic;">';
						echo '<td>' . $nomEnCours
				//			. '</td><td>' . $domaineEnCours
				//			. '</td><td>' . $sousDomaineEnCours
							. '</td><td>' . $statutEnCours . '</td></tr>';
						}
					$ajouterCetAdherent = true;
					$adherentEnCours = $line[ 'AId' ];
					$nomEnCours = $line['prenom'] . ' ' . $line['nom'];
					$domaineEnCours = $line['DTitre'];
					if( $domaineEnCours == 'Divers exclus' )
						$domaineEnCours = 'Divers';
					$sousDomaineEnCours = $line['STitre'];
					$statutEnCours = $line['statut'];
					}
				if( !is_null($line['idReseau'] ) AND $line[ 'idReseau' ] == $_GET[ 'idReseau' ] )
					$ajouterCetAdherent = false;
				}
			if( $adherentEnCours != '' )
				{
				if( $ajouterCetAdherent )
					{
					echo '<tr style="font-weight:bold;">';
					$listeIdAdherents .= $adherentEnCours . ',';
					}
				else
					echo '<tr style="font-style:italic;">';
				echo '<td>' . $nomEnCours
		//			. '</td><td>' . $domaineEnCours
		//			. '</td><td>' . $sousDomaineEnCours
					. '</td><td>' . $statutEnCours . '</td></tr>';
				}
			echo '</table>';
			if( $listeIdAdherents != '' )
				{
				echo '<table>';
				echo '<tr><td width="15%">&nbsp;</td>';
				echo '<td>';
				if( $adherentsDejaIntegres )
					{
					echo 		'<p>Les personnes affichées en italiques sont déjà dans votre réseau.</p>';
					if( $adherentsAIntegrer )
						echo 	'<p>Cliquez Ajouter pour que les autres personnes soient ajoutées à votre réseau.</p></td>';
					}
				else
					echo 		'<p>Cliquez Ajouter pour que les personnes affichées ci-dessus soient ajoutées à votre réseau.</p></td>';
				echo '</tr></table>';
				echo '<form name="leF" action="ACTreseauCreer.php" method="get">';
				echo	'<div class="formBouton" style="padding-top:20px;margin-left:20px;">';
				echo		'<input type="image" src="../images/btnAjouter.png" alt="Ajouter" name="action[Ajouter]" >';
				echo		'<input type="hidden" name="listeIdAdherents" value="' . substr( $listeIdAdherents, 0, -1 ) . '">';
				echo		'<input type="hidden" name="idReseau" value="' . $_GET['idReseau'] . '">';
				echo	'</div>';
				echo '</form>';
				}
			else
				echo '<h2>Toutes les personnes sélectionnées sont déjà dans votre réseau</h2>';
			}
		break;
	case 'Ajouter' :	//		étape 3 - ajout au réseau
		$lesIdCibles = explode( ',', $_GET[ 'listeIdAdherents' ]);
		// Connexion et sélection de la base
		require "../includes/mySql.php";
		//	colonnes à sélectionner --> $lesColonnes
		$query = "INSERT into tblReseauCPE VALUES";
		$rang = 0;
		foreach( $lesIdCibles as $lIdCible )
			{
			if( $rang > 0 ) $query .= ',';
			$query .= " (" . $_GET['idReseau'] . ',' . $lIdCible . ')';
			$rang++;
			}
		//echo '<br>...' . $query;
		$result = mysql_query( $query ); // or die("erreur 3");
		if( !$result )
			{
			if( mysql_errno() == 1062 )
				{	// duplicate entry
				$ii = strpos( mysql_error(), '-' );
				$lIdDupliquee = (int)substr( mysql_error(), $ii+1 );
				echo '<h2>Personne d\'id ' . $lIdDupliquee . ' déjà intégrée dans réseau</h2>';
				//	rang id dupliauée dans $lesIdCibles -->$rangId
				$rangId = 0;
				foreach( $lesIdCibles as $lId )
					{
					if( $lIdDupliquee == $lId )
						break;
					$rangId ++;
					}
				if( $rangId == 0 )
					echo '<p>Aucune personne n\'a été intégrée dans le réseau</p>';
				else if( $rangId == 1 )
					echo '<p>Seule la personne d\'id ' . $lesIdCibles[0] . ' a été intégrée dans le réseau</p>';
				else
					{
					$liste = '';
					$rang = 0;
					foreach( $lesIdCibles as $lId )
						{
						$liste .= ' ' . $lId;
						$rang++;
						if( $rang >= $rangId ) break;
						}
					echo '<p>Les personnes d\id ' . $liste . ' ont été intégrées dans le réseau</p>';
					}
				}
			else
				{
			    $message  = 'Requête invalide : ' . mysql_error() . "<br>";
			    $message .= 'Requête complète : ' . $query;
			    die($message);
				}
			}
		else
			echo '<h2>Ajout effectué</h2>';
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