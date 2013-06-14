<?php
require_once 'lib/swift_required.php';

global $gAction;

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
	include( "tbd.php" );
	
} elseif( $action == "pledges_to_date" ) {
	include( "pledges_to_date.php" );
	
} elseif( $action == "mail" ) {
	$keys = array_keys( $_POST );
	sort( $keys );
	foreach( $keys as $key ) {
//		printf( "_POST[%s] = %s<br>", $key, $_POST[$key] );
	}
	$tmp = preg_split( '/\|/', $_POST['fields'] );
	foreach( $tmp as $xx ) {
		list( $key, $val ) = preg_split( '/=/', $xx );
		$$key = $val;
	}
	$pmt_type = $_POST['paynow'];
	$message = Swift_Message::newInstance()
	->setSubject('CBI Financial Pledge Confirmation' )
	->setFrom(array('cbi18@cbi18.org' => 'CBI'))
	->setTo(array( $email => "$firstName $lastName" ) )
	->setCC(array( 'beth@elsternet.com' => 'The Pres' ) )
	;
	$url = "http://" . $_SERVER['SERVER_NAME'] . preg_replace( '/index.php/', 'pledge.html', $_SERVER['SCRIPT_NAME'] );
	echo "<script type=\"text/javascript\">goToURL('$url');</script>";

} else {
	echo "uh-oh, not sure what to do with action: [$action]<br>";
}
?>
</body>
</html>
