<?php
	require 'includes/librairie.php';
	if( !isset( $_COOKIE['CPEid'] ) )
		{	//	pas de cookie ==> on demande login et mdp
		if( isset( $_POST['destination'] ) )
			$destination = $_POST['destination'];
		else if( isset( $_GET[ 'dest' ] ) )
			$destination = $_GET[ 'dest' ];
		else if( isset( $_GET[ 'url' ] ) )
			$destination = 'url';
SetCookie( "testClientAccepteCookie", "1" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>CPE - Cadres pour l'entreprise - identification</title>
		<meta name="robots" content="noindex,nofollow" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript">
			function appelMdp()
			{
			leLogin = document.leF.login.value;
			if( leLogin == '' )
			alert( "vous devez saisir votre identifiant." );
			else
			{
			window.location = "identification4.php?login=" + leLogin;
			}
			}
		</script>
	</head>
	<body id="global2" style="padding-top:2em;">
		<div id="header2">
			<img src="images/logo50.gif" alt="logo CPE" />
			<p>Cadres pour l'Entreprise
				<span style="float:right;">
				</span>
			</p>
		</div>
		<div id="cdeFer">
<?php
echo '<div style="visibility:hidden;"></div>';
			echo 'Accès Espaces Privés';
?>
		</div>
		<p>&nbsp;</p>
<!-- en-têtes -->
		<h1>Veuillez vous identifier</h1>
		<form id="leF" action="identification2.php" method="post" enctype="multipart/form-data">
			<table border="0" cellpadding="5" cellspacing="0" width="580">
				<tr>
					<td>votre identifiant :</td>
					<td>
<?php
echo '<input name="dest" value="' . $destination . '" type="hidden" />';
if( isset( $_GET[ 'url' ] ) )
	echo '<input name="url" value="' . $_GET[ 'url' ] . '" type="hidden" />';
//echo '<br>...' . $_GET[ 'url' ] . '...';
?>
<?php
	if( $_SERVER['HTTP_HOST'] == 'localhost' )
		echo			'<input type="text" value="croy" name="login" size="15" />';
	else
		echo			'<input type="text" value="" name="login" size="15" />';
?>
					</td>
				</tr>
				<tr>
					<td>votre mot de passe :</td>
					<td>
						<table>
							<tr>
								<td>
<?php
	if( $_SERVER['HTTP_HOST'] == 'localhost' )
		echo			'<input type="password" value="" name="mdp" size="15" />';
	else
		echo			'<input type="password" value="" name="mdp" size="15" />';
?>
								</td>
								<td>
									<a href="#" onclick="appelMdp()">
										mot de passe oublié ?
									</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
<p>			<br /><br />
			<input type="image" value="Envoyer" src="images/btnValider.gif" />
</p>		</form>
				<script type="text/javascript">{ document.leF.login.focus(); } </script>
<p>		<a href="index.php">
			<img src="images/btnAnnuler.gif" alt="Annuler" />
		</a></p>
	</body>
</html>
<?php
		}
	else
		{	// cookie défini
		$lesTokens = explode( "\\", recupCookie( $_COOKIE['CPEid'] ) );
		$lEspace = $lesTokens[1];
		switch( $lEspace )
			{
			case "ancien" :
				header( "location:espaceAnciens/ANCAccueil.php" );
				break;
			case 'actif' :
				header( 'location:espaceActifs/ACTAccueil.php' );
				break;
			case 'actif-1' :
				header( 'location:espaceActifs/OffresCEF1.php' );
				break;
			case "les2" :
				header( "location:identificationChoix.php" );
				break;
			default :
				echo "??" . $lEspace ."??";
			}
		exit( 0 );
		}

?>