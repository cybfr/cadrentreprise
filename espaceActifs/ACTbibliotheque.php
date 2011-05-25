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
$titrePage = "documents";
$sncfLibelles = array( 'Accueil', 'Documents' );
$sncfLiens = array( 'ACTAccueil.php' );
require "includes/ACTenTetes.php";
?>
<!-- Contenu -->
		<div id="global">
			<h1>Bibliothèque</h1>
			<p>Les documents suivants sont à votre disposition.</p>
<!-- Encart -->
<!--		<div id="encart">
			<h3>Actualités</h3>
			<div id="bloccadre">
				<ul>
					<li>vive les vacances</li>
					<li>à bas la rentrée</li>
				</ul>
			</div>
		</div>-->
			<h2>Projets Flash</h2>
			<div style="margin-left:3em;">
				<p><b>projets flash :</b>
				<a href="bibliotheque/dossierPF.pdf">pour présenter les compétences disponibles à CPE, le dossier complet des projets flash sous forme imprimable.</a></p>
			</div>
			
			<h2>Informations générales</h2>
			<div style="margin-left:3em;">
				<p><b>Allocations et reprise d'activité</p>
				<div style="margin-left:20px;">
					<p><a href= "bibliotheque/Aide_createurs.ppt">Aides aux créateurs/repreneurs d'entreprise</a></p>
					<p><a href= "bibliotheque/Aide_differentielle.ppt">Aides si nouvelle rémunération < ancienne rémunération</a></p>
					<p><a href= "bibliotheque/Cumul_alloc_remun.ppt">Cumul allocations / rémunération</a></p>
					<p><a href= "bibliotheque/Guide_Protection_sociale__septembre10.pdf">Protection sociale du créateur d'entreprise</a></p>
				</div>
				<p><b>Vos droits :</b>
				<a href="bibliotheque/111009.pdf">Sécurité Sociale.</a></p> 
				<p><b>Tri automatisé des CV :</b>
				<a href="bibliotheque/logiciel_CV.doc">conseils.</a></p> 
				<p><b>Plan national d’action concerté pour l’emploi des seniors :</b>
				<a href="bibliotheque/plan concerte senior.pdf">Plan national 2006-2010.</a></p> 
				<p><b>modernisation du marché du travail :</b>
				<a href="nouvellesDispositions.php">Ce qui va changer en droit du travail, Conséquences de cet accord.</a></p> 
				<p><b>liste recruteurs :</b>
				<a href="bibliotheque/listeRecruteurs.xls">Liste de recruteurs opérant en Ile de France</a></p>
				<p><b>bibliothèque CPE :</b>
				<a href="livresCPE.php">Ouvrages disponibles au secrétariat</a><p>
				<p><b>Aide Dégressive à l’Employeur :</b>
				<a href="bibliotheque/ADE_janv_ 2008.pdf">Modalités d’attribution de l’Aide Dégressive à l’Employeur</a></p>
			</div>
			
			<h2>Formulaires CPE</h2>
			<div style="margin-left:3em;">
				<p><b>inscription :</b>
				<a href="bibliotheque/formInscription.pdf">Formulaire d'inscription d'un nouvel adhérent</p></a>
				<p><b>retour à l'emploi :</b>
				<a href="bibliotheque/formRetourEmploi.pdf">Formulaire pour connaître l'emploi que vous avez élu.</p></a>
			</div>
			
			<h2>Documents CPE</h2>
			<div style="margin-left:3em;">
				<p><b>Site CPE :</b>
				<a href="bibliotheque/CPEPresentationWeb.ppt">Présentation des espaces public et adhérents.</p></a>
				<p><b>accès WiFi :</b>
				<a href="bibliotheque/accesWiFi.pdf">Accès au réseau WiFi du Secrétariat.</p></a>
				<p><b>Opération terrain :</b>
				<a href="bibliotheque/Operation terrain Neuilly.pps">Neuilly-sur-Seine 2010.</p></a>
				<p><b>charte adhésion :</b>
				<a href="bibliotheque/charteAdhesion.doc">Charte de l'adhérent.</p></a>
				<p><b>tract CPE :</b>
				<ul><li><a href="../espaceActifs/bibliotheque/tractCadres.pdf">pour cadres</a></li>
				<li><a href="../espaceActifs/bibliotheque/tractEntreprises.pdf">pour entreprises</a></li></ul>
				<p><b>triptyque CPE :</b>
				<ul><li><a href="../espaceActifs/bibliotheque/triptyqueCadres.pdf">pour cadres</a></li>
				<li><a href="../espaceActifs/bibliotheque/triptyqueEntreprises.pdf">pour entreprises</a></li></ul>
			</div>
			
			<h2>Outils du Web</h2>
			<div style="margin-left:3em;">
				<p><b>créer un compte :</b>
				<a href="bibliotheque/CreationCompteGoogle.pdf">Création d'un compte Google pour partage.</p></a>
				<strong>&nbsp;&nbsp;&nbsp;&nbsp;Le partage de documents pour opérations terrain sera bientôt intégré dans le site CPE pour faciliter l'accès et conserver et sécuriser ces données importantes</strong>
				<p><b>alertes nouvelles offres :</b>
				<a href="bibliotheque/GoogleAlertes.pdf"><span style="color:orange;font-weight:bold">NOUVEAU</span>&nbsp;&nbsp;&nbsp;Création d'une alerte Google.<span style="color:orange;font-weight:bold">NOUVEAU</span></p></a>
				<strong>&nbsp;&nbsp;&nbsp;&nbsp;Pour recevoir des offres d'emploi à votre rythme dans votre boîte aux lettres</strong>
			</div>
		<p style="margin-top:40px;font-weight:bold;">
			Pour que tous disposent de documents à jour et pertinents, merci de nous communiquer vos remarques (cliquez "Contact" en haut à droite).
		</p>
		</div>
	<!--<p id="piedDePage"></p>-->
		</div>
	</body>
</html>
