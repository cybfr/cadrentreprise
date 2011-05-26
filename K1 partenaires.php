<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>CPE - Cadres pour l'entreprise - partenaires</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>
<!-- en-têtes -->
<?php
echo '<div style="visibility:hidden;"></div>';
$lEtage = 0;
$sncfLibelles = array( 'Accueil', 'partenaires' );
$sncfLiens = array( 'index.php' );
require "includes/enTetes.php";
?>
<!-- Contenu -->
	<div id="global">
		<h1>Nos partenaires :</h1>

		<table style="margin-bottom:10;" border="0">
			<tr>
				<td>
					<a href="http://www.lexpansion.com/">
						<img src="images/expansion.jpg" width="155" height="45" alt="L'expansion"/>
					</a>
				</td>
				<td>
					<a href="http://www.exposium.com/exposium/index.jsp">
						<img src="exposium.jpg" width="72" height="77" alt="Exposium"/>
					</a>
				</td>
				<td>
					<a href="http://www.foiredeparis.fr">
						<img src="images/FoireParis.jpg" width="145" height="94" alt="Foire de Paris" />
					</a>
				</td>
				<td>
					<a href="http://cqfd.asso.free.fr">
						<img src="images/CQFD.gif" width="92" height="78" alt="CQFD" />
					</a>
				</td>
			</tr>
			<tr>
				<td >
					<a href="http://www.batimat.com/">
						<img src="images/batimat.jpg" width="163" height="69" alt="BatiMat" />
					</a>
				</td>
				<td>
					<a href="http://www.midest.com/">
						<img src="images/midest.gif" width="143" height="120" alt="MidEst" />
					</a>
				</td>
				<td>
					<a href="http://www.reedexpo.com">
						<img src="images/reed.gif" width="216" height="48" alt="Reed" />
					</a>
				</td>
				<td>
					<a href="http://www.jardin-paysage.com/ExposiumCms/do/admin/visu?reqCode=accueil">
						<img src="images/Jardi.GIF" width="96" height="163" alt="Jardin-Paysage" />
					</a>
				</td>
			</tr>
			<tr>
				<td>
					<img src="images/smbtp.jpg" width="130" height="73" alt="SMBTP" />
				</td>
				<td>
					<a href="http://www.pollutec.com/">
						<img src="images/Pollut.gif" width="163" height="54" alt="Pollutech" />
				</a>
				</td>
				<td>
					<a href="http://www.seniorplanet.fr">
						<img src="images/SeniorPlanet.gif" width="319" height="78" alt="Senior Planet" />
					</a>
				</td>
				<td>
					<a href="http://www.comexpo-paris.com">
						<img src="images/comexpo.gif" width="79" height="79" alt="ComExpo" />
					</a>
				</td>
			</tr>
		</table>
		<div id="btnRetour">
			<a href="index.php">
				<img src="images/btnRetour.gif" alt="Retour" />
			</a>
		</div>
		</div>
		<!--<p id="piedDePage"></p>-->
	</body>

</html>
