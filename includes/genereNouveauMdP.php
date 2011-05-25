<?php //	nouveau mot de passe --> $leMdp
$leMdp = '';
$i=0;
do
	{
	$n = rand( ord('a'), ord('z') );
	if( $n != ord('l') && $n != ord('o') )
		{
		$leMdp .= chr($n );
		$i++;
		}
	} while( $i<4 );
$i=0;
do
	{
	$n = rand( ord('2'), ord('9') );
	$leMdp .= chr($n );
	$i++;
	} while( $i<4 );
?>