<?php

function CleanString ($data) {
	$data = trim($data);
	$data = addslashes($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_QUOTES );
	return $data;
}

function LocalInit() {
	include( 'globals.php' );
	
	$gFrom = array_key_exists( 'from', $_POST ) ? $_POST['from'] : '';
	
	$gSpiritIDtoDesc = array();
	DoQuery( "select id, description from spiritual" );
	while( list( $id, $desc ) = mysql_fetch_array( $result ) ) {
		$gSpiritIDtoDesc[$id] = $desc;
	}
}

?>
