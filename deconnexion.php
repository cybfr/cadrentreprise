<?php
$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
//echo '<br>...' . $_SERVER['HTTP_HOST'] . '...' . $domain;exit;
//setcookie('CPEid', false, -1, '/', $domain, false);
setcookie('CPEid', false, -1 );
//	setcookie("CPEid", false, 1, "/~christia/web1/admin" );	//time()-3600 );
	header( "location:index.php" );
?>