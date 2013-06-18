<?php

$args = array();
$tmp = preg_split( '/\|/', $_POST['fields'] );
foreach( $tmp as $nvp ) {
	list( $name, $value ) = preg_split( '/=/', $nvp );
	if( $name == 'pledgeIds' ) {
		$pledgeIds = array();
		$tmp2 = preg_split( '/,/', $value );
		foreach( $tmp2 as $xx ) {
			list( $key, $id ) = preg_split( '/_/', $xx );
			if( $key == "id" ) {
				$pledgeIds[] = $id;
			}
		}
		$args[] = sprintf( "pledgeIds = '%s'", join(',', $pledgeIds ) );
		 
	} elseif( $name == "phone" ) {
		$args[] = "phone = " . preg_replace("/[^0-9]/", "", $value);

	} else {
		$args[] = sprintf( "%s = '%s'", $name, addslashes($value) );
	}
}

if( $gFrom == 'financial' ) {
	$args[] = "pledgeType = $PledgeTypeFinancial";
	$args[] = sprintf( "paymentMethod = '%d'", $_POST['paynow'] );

} else {
	$args[] = "pledgeType = $PledgeTypeSpiritual";
}


$query = "insert into pledges set " . join( ',', $args );
DoQuery( $query );

?>