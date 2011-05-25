function check()
	{
	var image2 = new Image();
	var temp = "file:///c:/Users/Libre%20Service/AppData/Roaming/Identity.jpg";
	//var temp = "file:///users/christianroy/Pictures/Identité.jpg";

	image2.src = temp;
	var width = image2.width;

	//alert( width + '--' + temp + '--' + image2.src );
	if( width != 409)
		{
		//	supprime dernière option
		document.getElementById('lim').value = 'non';
		}
	else
		{
		document.getElementById( 'partialaccess' ).style.display="none";
		document.getElementById( 'fullaccess' ).style.display="block";
		//	supprime dernière option
		var theSelect = document.getElementById('lim');
		document.getElementById('lim').value = 'oui';
		}
	}
