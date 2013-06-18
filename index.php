<?php
require_once 'lib/swift_required.php';

include( 'globals.php' );
include( 'library.php' );
include( 'local_cbi.php' );

require_once( 'SiteLoader.php' );
SiteLoad( 'CommonV2' );

$gDb = OpenDb();                # Open the MySQL database

LocalInit();

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CBI HH Pledges</title>
<script type="text/javascript" src="hhPledges.js"></script>
</head>
<body>
<?php

$debug = 0;
$x = isset( $_REQUEST['bozo'] ) ? 1 : 0;
if( $x ) {
	$debug = $x;
}

if( $debug ) {
	$tmp = array_keys( $_POST );
	sort( $tmp );
	foreach( $tmp as $key ) {
		printf( "_POST['%s'] = %s<br>", $key, $_POST[$key] );
	}
}

$action = array_key_exists( "action", $_POST ) ? $_POST[ "action" ]  : "";
if( ! $action ) $action = "pledge";
$gFrom = array_key_exists( "from", $_POST ) ? $_POST[ "from" ]  : "";

$gAction = $action;

if( $action == "pledge" ) {
	include( "pledge.php" );
	
} elseif( $action == "pledge_now" ) {
	include( "pledge_now.php" );

} elseif( $action == "financial" ) {
	include( "financial.php" );

} elseif( $action == "spiritual" ) {
	include( "spiritual.php" );

} elseif( $action == "paynow" ) {
	include( "store_pledge.php" );
	include( "send_confirmation.php" );
	include( "thank_you.php" );
	
} elseif( $action == "pledges_to_date" ) {
	include( "pledges_to_date.php" );
	
} else {
	echo "uh-oh, not sure what to do with action: [$action]<br>";
}
?>
</body>
</html>
