<?php
require_once "includes/librairie.php";

$lePath = getPathRacine();
$leFichier = "rss.xml";
$handle = fopen( $leFichier, "w");
if( !$handle ) die( 'erreur ouverture ' . $leFichier );
// génération début du fichier
fwrite( $handle, "<?xml version='1.0' encoding='utf-8'?>");
fwrite( $handle, "\n<rss version='2.0'>");
    fwrite( $handle, "\n<channel>");
        fwrite( $handle, "\n<title>CPE - Espace Actifs</title>");
        fwrite( $handle, "\n<link>http://" . $lePath . "/espaceActifs</link>");
        fwrite( $handle, "\n<description>Derniers messages importants du forum Futuroscope (20 au plus)</description>");
		fwrite( $handle, "\n<language>fr</language>");		fwrite( $handle, "\n<copyright>Copyright 2008 Cadres pour l\'entreprise (CPE)" );		fwrite( $handle, "\n</copyright>");		fwrite( $handle, "\n<lastBuildDate>" . date(DATE_RFC822) . "</lastBuildDate>");
		fwrite( $handle, "\n<image>");			fwrite( $handle, "\n<url>../images/logo50.gif</url>");			fwrite( $handle, "\n<link>http://" . $lePath . "espaceActifs/ACTAccueil.php</link>");			fwrite( $handle, "\n<title>site CPE - espace actifs</title>");			fwrite( $handle, "\n<height>31</height>");			fwrite( $handle, "\n<width>88</width>");		fwrite( $handle, "\n</image>");
//	génération des items de base (i.e. définis dans fichier rssBase.xml)
fwrite( $handle, file_get_contents( "rssBase.xml" ) );
//	génération des items (i.e. les messages mis en avant)
require "../includes/mySql.php";

$query = "SELECT M.auteur,M.texte,date_format( M.date, '%a, %d %b %y %T +0200') as date,M.id as MId,idFil,F.sujet"
	. " FROM f01Messages AS M, f01Fils AS F"
	. " WHERE enAvant=1 AND M.idFil=F.id"
	. " ORDER BY M.date DESC LIMIT 20";
$result = mysql_query( $query ) or die(mysql_error());
while( $line = mysql_fetch_array( $result ) )
	{
	fwrite( $handle, "\n\t<item>");
		fwrite( $handle, "\n\t\t<title>Forum-" . $line['sujet']
			. '-' . substr( $line['texte'],0,40 ) . "...</title>");		fwrite( $handle, "\n\t\t<link>http://" . $lePath . "espaceActifs/forumMessages.php"
			. "?id=" . $line['idFil']
			. ".m.m" . $line['MId']			//	on doublonne l'ancre pour que ca marche si appel avec
			. "#m" . $line['MId']			//	authentification faite ou pas
			. "</link>");		fwrite( $handle, "\n\t\t<description>De " . $line['auteur'] . " - " . substr( $line['texte'],0,70) . "...</description>" );		fwrite( $handle, "\n\t\t<pubDate>" . $line[ 'date' ] . "</pubDate>");	fwrite( $handle, "\n\t</item>");
	}
//	génération fin
fwrite( $handle, "\n</channel></rss>");
fclose( $handle );

echo "ecriture terminee (" . mysql_num_rows($result) . " entrées)";
?>