<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<title>upload</title>
	</head>
	<body><?phpfunction get_extension( $nom )
	{	$nom = explode( ".", $nom );	$nb = count( $nom );	return strtolower( $nom[ $nb-1 ] );	}$extensions_ok = array( array( 'gif' ), array( 'jpg', 'jpeg' ), array( 'png' ) );// MimeType autorisés// 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF (Ordre des octets Intel), 8 = TIFF (Ordre des octets Motorola), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF */$typeimages_ok = array( 1, 2, 3 );$taille_ko = 1024;$taille_max = $taille_ko * 1024;$dest_dossier = 'img/';//print_r( $_FILES['photo'] );if( isset( $_FILES['photo'] ) )	{	if( $_FILES['photo']['error'] !== "0" )
		{		switch( $_FILES['photo']['error'] )
			{			case 1:				$erreurs[] = "Votre image doit faire moins de $taille_ko Ko !";				break;			case 2:				$erreurs[] = "Votre image doit faire moins de $taille_ko Ko !";				break;			case 3:				$erreurs[] = "L'image n'a été que partiellement téléchargé.";				break;			case 4:				$erreurs[] = "Aucun fichier n'a été téléchargé.";				break;			case 6:				$erreur[] = "Un dossier temporaire est manquant.";				break;			case 7:				$erreurs[] = "échec de l'écriture du fichier sur le disque.";				break;			}		}		if( !( $getimagesize = getimagesize( $_FILES['photo']['tmp_name'] ) ) )		$erreurs[] = "Le fichier n'est pas une image valide.";
	$extensionSource = get_extension( $_FILES['photo']['name'] );
	if( !in_array( $getimagesize[2], $typeimages_ok ) )		{		foreach( $extensions_ok as $text)
			$extensions_string .= $text . ', ';		$erreurs[] = 'Veuillez sélectionner un fichier de type '
			. substr( $extensions_string, 0, -2) . ' !';		}		if( file_exists( $_FILES['photo']['tmp_name'] )		AND filesize( $_FILES['photo']['tmp_name'] ) > $taille_max )		$erreurs[] = "Votre fichier doit faire moins de $taille_ko Ko !";
	if( !isset($erreurs) OR empty($erreurs) )		{		$dest_fichier = basename( $_FILES['photo']['name'] ) ;		$tmpname = rename( tmp_name, promo_name);		}
//	nom du fichier chargé --> $src_fichier
//	nom du fichier final (.p,g) --> $dest_fichier$src_fichier = $dest_fichier;
if( $extensionSource != 'png' )
	{
	$i = strrpos( $dest_fichier, '.' );
	$dest_fichier = substr( $dest_fichier, 0, $i ) . '.png';
	}

	if( move_uploaded_file( $_FILES['photo']['tmp_name'],
		$dest_dossier . $src_fichier) )		$valid[] = "Image chargée avec succés ("
			. "<a href='" . $dest_dossier . $dest_fichier . "'>Voir</a>)";	else		$erreurs[] = "Impossible d'uploader le fichier.<br />Veuillez vérifier que le dossier ".$dest_dossier." existe avec un chmod 755 (ou 777).";	}?>
		<form method="POST" action="" enctype="multipart/form-data"><?phpif( !empty($erreurs) )
	{	echo '<ul class="erreur">';	foreach( $erreurs as $erreur )		echo '<li>'.$erreur.'</li>';	echo '</ul>';	}if( !empty($valid) )
	{	echo '<ul class="validation">';	foreach( $valid as $text )		echo '<li>'.$text.'</li>';	echo '</ul>';

switch( $getimagesize[2] )
	{
	case 1 : 	// gif
		$im = imagecreatefromgif( $dest_dossier . $src_fichier );
		break;
	case 2 : 	// jpeg
		$im = imagecreatefromjpeg( $dest_dossier . $src_fichier );
		break;
	case 3 : 	// png
		$im = imagecreatefrompng( $dest_dossier . $src_fichier );
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
else	{
	$nouvLargeur = $largeur / $facteurLargeur;
	$nouvHauteur = $hauteur / $facteurLargeur;
	$couperSurLargeur = false;
	}
echo '<br>...' . $nouvLargeur . ' x ' . $nouvHauteur . '<br>';$im2 = imagecreatetruecolor( $kLargeurCible, $kHauteurCible );
imagecopyresampled( $im2, $im, 0, 0, 0, 0,
	$nouvLargeur, $nouvHauteur,
	$largeur, $hauteur );

	imagepng( $im2, $dest_dossier . $dest_fichier );
if( $dest_fichier != $src_fichier )
	//	détruire $src_fichier
	unlink( $dest_dossier . $src_fichier );
	}?>
			<fieldset>
				<legend>Envoi d'image</legend>
				<p>
					<label for="photo">Image : </label>
					<input type="file" name="photo" id="photo" />
				</p>
				<p>
					<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $taille_max; ?>" />
					<input type="submit" name="envoi" value="Envoyer l'image" />
				</p>
			</fieldset>
		</form>