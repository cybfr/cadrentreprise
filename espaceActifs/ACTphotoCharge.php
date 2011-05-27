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
$titrePage = "chargement photo";
$sncfLibelles = array( 'Accueil', 'Données', 'Chargement photo' );
$sncfLiens = array( 'ACTAccueil.php', 'ACTdonnees.php' );
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
		<div id="global">
			<h1>Espace actifs - chargement photo</h1>

<?php

function get_extension( $nom )
	{
	$nom = explode( ".", $nom );
	$nb = count( $nom );
	return strtolower( $nom[ $nb-1 ] );
	}

$extensions_ok = array( array( 'gif' ), array( 'jpg', 'jpeg' ), array( 'png' ) );
// MimeType autorisés
// 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF (Ordre des octets Intel), 8 = TIFF (Ordre des octets Motorola), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF */
$typeimages_ok = array( 1, 2, 3 );

$taille_ko = 1024;
$taille_max = $taille_ko * 1024;
$dest_dossier = 'images/';

if( !isset( $_FILES['photo'] ) )
	{
	echo	'<form method="post" action="" enctype="multipart/form-data">';
	echo		'<p style="margin-top:20px;">';
	echo		'<input type="hidden" name="MAX_FILE_SIZE" value="' . $taille_max . '" />';
	echo			'<label for="photo">Image : </label>';
	echo			'<input type="file" name="photo" id="photo" src="../images/btnParcourir.gif" />';
	echo		'</p>';
	echo		'<div class="formBouton" style="margin-top:40px;">';
	echo			'<input type="image" value="Envoyer" src="../images/btnCharger.png" />';
	echo		'</div>';
	echo	'</form>';
	}
else
	{
	if( $_FILES['photo']['error'] !== "0" )
		{
		switch( $_FILES['photo']['error'] )
			{
			case 1:
			case 2:
				$erreurs[] = 'Votre image est trop volumineuse (max. ' . $taille_ko . ' Ko !';
				break;
			case 3:
				$erreurs[] = "L'image n'a été que partiellement chargée.";
				break;
			case 4:
				$erreurs[] = "Aucun fichier n'a été chargé.";
				break;
			case 6:
				$erreurs[] = "Un dossier temporaire est manquant.";
				break;
			case 7:
				$erreurs[] = "échec de l'écriture du fichier sur le disque.";
				break;
			}
		if( empty( $erreurs ) )
			{
			if( !( $getimagesize = getimagesize( $_FILES['photo']['tmp_name'] ) ) )
				$erreurs[] = "Le fichier n'est pas une image valide.";
			$extensionSource = get_extension( $_FILES['photo']['name'] );
		
			if( !in_array( $getimagesize[2], $typeimages_ok ) )
				{
				foreach( $extensions_ok as $text)
					$extensions_string .= implode( ', ', $text ) . ', ';
				$erreurs[] = 'Veuillez sélectionner un fichier de type '
					. substr( $extensions_string, 0, -2);
				}
			
			if( file_exists( $_FILES['photo']['tmp_name'] )
				AND filesize( $_FILES['photo']['tmp_name'] ) > $taille_max )
				$erreurs[] = "Votre fichier doit faire moins de $taille_ko Ko !";
		
			if( !isset($erreurs) OR empty($erreurs) )
				{
				$src_fichier = basename( $_FILES['photo']['name'] ) ;
				//$tmpname = rename( tmp_name, promo_name);
				}
			//	nom du fichier chargé --> $src_fichier
			//	nom du fichier final (id<id>.png) --> $dest_fichier
			$dest_fichier = "id" . $_GET[ 'id' ] . '.png';
			if( $extensionSource != 'png' )
				{
				$i = strrpos( $dest_fichier, '.' );
				$dest_fichier = substr( $dest_fichier, 0, $i ) . '.png';
				}
			if( empty( $erreurs ) )
				{
				$res = move_uploaded_file( $_FILES['photo']['tmp_name'],
					$dest_dossier . $src_fichier);
				if( ! $res )
					$erreurs[] = "Impossible de charger le fichier.";
				if( empty( $erreurs ) )
					{
					switch( $getimagesize[2] )
						{
						case 1 : 	// gif
							$im = imagecreatefromgif( $dest_dossier . $src_fichier );
							break;
						case 2 : 	// jpeg
							$im = imagecreatefromjpeg( $dest_dossier . $src_fichier );
//echo '<br>C...' . $im;
							break;
						case 3 : 	// png
							$im = imagecreatefrompng( $dest_dossier . $src_fichier );
//							var_dump($im);
							break;
						}
					//	redimensionnement vers la cible 140 x 185
					//	redimensionnement vers la cible 100 x 132
					$kLargeurCible = 100;
					$kHauteurCible = 132;
					$largeur = $getimagesize[0];
					$hauteur = $getimagesize[1];
					$facteurLargeur = $getimagesize[0] / $kLargeurCible;
					$facteurHauteur = $getimagesize[1] / $kHauteurCible;
					$nouvHauteur = $hauteur / $facteurLargeur;
					if( $nouvHauteur < $kHauteurCible )
						{
						$nouvLargeur = $largeur / $facteurHauteur;
						$nouvHauteur = $hauteur / $facteurHauteur;
						$couperSurLargeur = true;
						}
					else
						{
						$nouvLargeur = $largeur / $facteurLargeur;
						$nouvHauteur = $hauteur / $facteurLargeur;
						$couperSurLargeur = false;
						}
					$im2 = imagecreatetruecolor( $kLargeurCible, $kHauteurCible );
					imagecopyresampled( $im2, $im, 0, 0, 0, 0,
						$nouvLargeur, $nouvHauteur,
						$largeur, $hauteur );
					
					$result = imagepng( $im2, '../photosId/' . $dest_fichier );
//echo '<br>imagepng...' . $res . '...' . $dest_dossier . $dest_fichier;
					//	ménage
					unlink( $dest_dossier . $src_fichier );
					//
					if( !$result )
						$erreurs[] = "Erreur chargement";
					}
				}
			}
		}

if( !empty( $erreurs ) )
	{
	echo '<ul class="erreur">';
	foreach( $erreurs as $erreur )
		echo '<li>'.$erreur.'</li>';
	echo '</ul>';
	}
else
	echo '<h2>La photo est chargée</h2>';
	}
?>
		</div>
		<div id="btnRetour">
			<a onclick="window.close();">
				<img src="../images/btnRetour.gif" alt="Retour" />
			</a>
		</div>
	</body>
</html>