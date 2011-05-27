<?php
$titrePage = 'adhérents';
$sncfLibelles = array( 'Accueil', 'Adhérents CPE' );
$sncfLiens = array( 'ACTAccueil.php' );
require "includes/ACTenTetes.php";
?>
<script type="text/javascript">
$(function() {
		$( "#adherent" ).autocomplete({
			source: "search.php",
			minLength: 2,
			html: true,
			select: function( event, ui ) {
				$.get("ACTFicheAdherent.php?idAdherent=" + ui.item.id, function(data){
					  $("#log").empty();
					  $("#log").append(data);
					});
									
			}
		});
	});
</script>

<?php
// Connexion et sélection de la base
require "../includes/mySql.php";
?>
<div class="ui-widget">
	<label for="adherent">id ou tout ou partie du nom de l'adhérent : </label>
	<input id="adherent" />
</div>

<div class="ui-widget" style="float: left; margin: 4em; font-family:Arial">
	<div id="log" style="overflow: auto; margin-left: 40px;" class="ui-widget-content">
	</div>
</div>
	</body>
</html>