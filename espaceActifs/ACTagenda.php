<?php
$titrePage = "agenda";
$sncfLibelles = array( 'Accueil', 'Agenda' );
$sncfLiens = array( 'ACTAccueil.php' );
require "includes/ACTenTetes.php";
require "../includes/mySql.php";

echo	'<div id="global">';
echo		'<h1>Vos activités</h1>';

$lesMois = array( 'Janvier', 'Février', 'Mars', 'Avril', 'Mai',
	'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre',
	'Décembre' );
$nbrJours = Array( 31,0,31,30,31,30,31,31,30,31,30,31 );	// nbre des jours de l'année

$cetteDate = getdate();
$ceJour = $cetteDate[ 'day' ];
$ceMois = $cetteDate[ 'mon' ];
$cetteAnnee = $cetteDate[ 'year' ];
if( !isset( $_GET[ 'leMois' ] ) )
	$leMoisC = $ceMois . "," . $cetteAnnee;
else
	$leMoisC = $_GET[ 'leMois' ];
//	décalage de $leMoisDebut de - 6 mois
$laDate = explode( ',', $leMoisC );
$leMois = $laDate[ 0 ];
$lAnnee = $laDate[ 1 ];
if( $leMois <= 0 )
	{
	$leMois += 12;
	$lAnnee--;
	}
elseif( $leMois > 12 )
	{
	$leMois -= 12;
	$lAnnee++;
	}
if( !isset( $_GET[ 'groupe' ] ) )
	$leGroupe = 'toutes';
else
	$leGroupe = $_GET[ 'groupe' ];
?>

		<div class="selectionActivites">
				<form action="ACTagenda.php" method="get">
			<p>choix des activités affichées : 
<?php
echo				'<input type="hidden" name="leMois" value="'.$leMois.",".$lAnnee.'" />';
?>
					<select name='groupe' size='1'>
						<option value='toutes' selected='selected'>Toutes</option>
<?php
	require "../includes/mySql.php";

	$query = "SELECT id, titre from tblGroupes";
	$result = mysql_query($query);	// or die("erreur 3");
	while( ($line = mysql_fetch_assoc($result)) ){
		echo 			"<option value='" . $line['id'] . "'";
		if($leGroupe == $line['id']) echo " selected='selected'";
		echo ">";
		echo htmlspecialchars($line['titre'])."</option>";
		}
?>
					</select>
					<input type="submit" value=" ok " />
			</p>
				</form>
		</div>
<?php
$lePremierJourDuMois = $lAnnee . '-' . $leMois . '-1';
$leMoisSuivant = $leMois==12?1:$leMois+1;
$lAnneeSuivante = $leMois==12?$lAnnee+1:$lAnnee;
$lePremierJourDuMoisSuivant = $lAnneeSuivante . '-' . $leMoisSuivant . '-1';
$query = "SELECT id, date_format( dateDebut, '%d,%m,%Y' ) as laDateDebut,"
	. "date_format( dateFin, '%d,%m,%Y' ) as laDateFin,"
	. "date_format( dateDebut, '%H:%i' ) as lHeureDebut,"
	. "date_format( dateFin, '%H:%i' ) as lHeureFin,"
	. "titre, texte "
	. "FROM tblEvts "
	. "WHERE (( dateFin is not null AND dateDebut < '" . $lePremierJourDuMoisSuivant . "' and dateFin >='" . $lePremierJourDuMois . "')"
		. " OR (dateFin is null AND dateDebut < '" . $lePremierJourDuMoisSuivant . "'"
			. " AND dateDebut >= '" . $lePremierJourDuMois . "'))";
if( $leGroupe <> 'toutes' )
	$query .= " AND type = '" . $leGroupe . "' ";
$query .= " ORDER BY laDateDebut asc, lHeureDebut ASC";

$result = mysql_query($query);	// or die("erreur 3");
if( ! $result )
	{
	echo "..." . mysql_error() . '...' . $query . "...<br>";
	exit;
	}
$nbrLgns = mysql_num_rows( $result );

//	résultat --> lesEvts[] en dupliquant les evts qui
//		s'étendent sur plusieurs jours
while( ($line = mysql_fetch_assoc( $result ) ) )
	{
	$laDateDebut = explode( ',', $line[ 'laDateDebut' ] );
	$laDateFin = explode( ',', $line[ 'laDateFin' ] );
	//	recadrage jours début et fin dans mois et année en cours
	if( $laDateDebut[ 2 ] < $lAnnee )
		$leJourDebut = 1;
	elseif( $laDateDebut[ 1 ] < $leMois )
		$leJourDebut = 1;
	else
		$leJourDebut = $laDateDebut[ 0 ];
	if( $line[ 'laDateFin' ] != '' )
		{
		if( $laDateFin[ 2 ] > $lAnnee )
			$leJourFin = 31;
		elseif( $laDateFin[ 1 ] > $leMois )
			$leJourFin = 31;
		else
			$leJourFin = $laDateFin[ 0 ];
		}
	else
		$leJourFin = $leJourDebut;
	for( $leJ = $leJourDebut; $leJ <= $leJourFin; $leJ++ )
		$lesEvts[] = array( "lId"=>$line['id'], "leJour"=>$leJ, "lHeureDebut"=>$line[ 'lHeureDebut'], 
			"lHeureFin"=>$line[ 'lHeureFin'], "leTitre"=>$line[ 'titre' ], "leTexte"=>$line[ 'texte' ] );
	}
//echo '<br>...';var_dump($lesEvts);

function compare($a, $b) 
	{	// fonction pour tri par jour croissant
    if ($a["leJour"] == $b["leJour"])
		{
    	if ($a["lHeureDebut"] == $b["lHeureDebut"])
			return 0;
		else
    		return ($a["lHeureDebut"] > $b["lHeureDebut"]) ? 1 : -1;
		}
    return ($a["leJour"] > $b["leJour"]) ? 1 : -1;
	}
	
if( isset( $lesEvts ) )
	{
	usort( $lesEvts, "compare" );
	reset( $lesEvts );
	$line = current( $lesEvts );
	$leJourEvtEnCours = $line[ 'leJour' ];
	}
else
	$leJourEvtEnCours = 100;
//	correction nbre jours février
$nbrJours[1] =
	(
		(
			( 	( $lAnnee ) % 100 != 0 )
		&&
			(	( $lAnnee ) % 4 == 0 )
	)
	|| ( ( $lAnnee ) % 400 == 0 ) )?29:28;

$premierJourDuMois = strtotime( $lAnnee . '-' . $leMois. '-1' );
$rangJourPremiereCase = -date( 'w', $premierJourDuMois );
	
$todayDate = getdate( );
$todayAn = $todayDate[ 'year' ];
$todayMois = $todayDate[ 'mon' ];
$todayJour =  $todayDate[ 'mday' ];
$scanfortoday = $anCalendrier==$toDayAn && $moisCalendrier==$todayMois ? $todaydate : 0; //DD added

$indxCaseDuJour = 
	$todayAn == $lAnnee && $todayMois == $leMois?
		 $todayJour - $rangJourPremiereCase : -100;

//	affichage de l'agenda
	echo '<div class="main">
	<table class="main" cellpadding="0" border="1" cellspacing="0">
	<colgroup width="150px" span="7"></colgroup>
	<tr align="center">
	<td><a href="ACTagenda.php?leMois='
						. ($leMois-1) . ',' . $lAnnee;
	if(isset($_GET['urlRetour'])) echo '&urlRetour=' . $_GET[ 'urlRetour' ];
	if($recherche) echo '&recherche';
	echo 					'&amp;lesAutor=' . $lActivite . '">';
	echo				'<img src="../images/chevronG.gif" alt="&lt;" /></a></td>';
	echo 			'<td colspan="5" align="center" class="month">'.$lesMois[ $leMois-1 ].' - '.$lAnnee .'</td>';
	echo			'<td><a href="ACTagenda.php?leMois='
						. ($leMois+1) . ',' . $lAnnee;
	if(isset($_GET['urlRetour'])) echo '&urlRetour=' . $_GET[ 'urlRetour' ];
	if($recherche) echo	'&amp;recherche';
	echo					'&amp;lesAutor=' . $lActivite . '">';
	echo				'<img src="../images/chevronD.gif" alt="&gt;"/></a></td>';
	echo		'</tr>
				<tr align="center">';
	for( $s=0; $s<7; $s++)	//	affichage entêtes jours
		echo 		'<td class="daysOfWeek">' . substr("DLMMJVS",$s,1) . '</td>';
	echo 		'</tr>';
	//	 cases des quantièmes
	echo		'<tr align="center">';
	for( $indxCase = 1; $indxCase <= 42; $indxCase++)	//	bcle sur les cases potentielle (6 x 7)
		{
		//	rang du jour de la case en cours --> $indxJour : le 1er du mois a pour indxJour 0,
		//		la case juste à gauche a pour indxJour -1
		$indxJour = $indxCase + $rangJourPremiereCase;
		//	affichage du quantième si dans le mois
		if( ( $indxJour > 0 ) && ( $indxJour  <= $nbrJours[$leMois-1] ) )
			{	//	jour à afficher
			$x = $indxJour;
			if( $indxCase == $indxCaseDuJour )
				$x = '<span id="today">' . $x . '</span>';
			echo 		'<td class="days" valign="top" style="padding:0px;"><table width="100%"><tr><td align="center" style="border-bottom:1px solid black;">';
			echo			$x;
			while( $indxJour == $leJourEvtEnCours )
				{
				echo 					'</td></tr><tr><td>';
				if( $recherche )
					echo					'<a href="' . $_GET[ 'urlRetour' ] . '?idEvtChoisi=' . $line[ 'lId' ]
												. '&titreEvt=' . urlencode($line[ 'leTitre' ].' du '.$line[ 'leJour' ] . '/' . $leMois . "/" . $lAnnee)
												. '&mois=' .$leMois . "/" . $lAnnee . '">';
				else
					echo					'<a class="info" href="#" onclick="javascript:popitup'
												. "('ACTagendaDetail.php?evt=" . $line[ 'lId' ] . "')\">";
				if( $line['lHeureDebut'] != "00:00" )
					{
					echo $line['lHeureDebut'];
					if( $line['lHeureFin'] != '00:00' )
						echo '-' . $line['lHeureFin'];
					echo ' ';
					}
				echo htmlspecialchars($line['leTitre']);
				if( $line[ 'leTexte' ] != '' )
					echo '<span>'.nl2br(htmlspecialchars($line['leTexte'])).'</span>';
				echo					'</a>';
				$line = next( $lesEvts );
				$leJourEvtEnCours = $line[ 'leJour' ];
				}
			echo		'</td></tr></table></td>';
			}
		else
			//	jour à ne pas afficher (hors du mois)
			echo 		'<td class="days">&nbsp;</td>';
		if(( ($indxCase % 7) == 0 ) && ( $indxCase < 36 ))
			{
			if( $indxJour  < $nbrJours[$leMois-1] )
				{
				echo '</tr>';
				echo '<tr align="center">';
				}
			else
				break;
			}
		}
?>
</tr></table></div>
<h2>Les inscriptions à ces activités sont exclusivement effectuées pendant les réunions hebdomadaires du mardi.</h2>
		</div>
		<!--<p id="piedDePage"></p>-->
	</body>
</html>
