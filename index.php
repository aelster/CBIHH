<?php
require_once 'lib/swift_required.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CBI HH Pledges</title>
<script type="text/javascript" src="hhPledges.js"></script>
</head>
<body>
<?php
$action = array_key_exists( "action", $_POST ) ? $_POST[ "action" ]  : "";
if( ! $action ) $action = "pledge";

if( $action == "pledge" ) {
	$url = "http://" . $_SERVER['SERVER_NAME'] . preg_replace( '/index.php/', 'pledge.html', $_SERVER['SCRIPT_NAME'] );
	echo "<script type=\"text/javascript\">goToURL('$url');</script>";
	
} elseif( $action == "pledge_now" ) {
	$url = "http://" . $_SERVER['SERVER_NAME'] . preg_replace( '/index.php/', 'pledge_now.html', $_SERVER['SCRIPT_NAME'] );
	echo "<script type=\"text/javascript\">goToURL('$url');</script>";
	
} elseif( $action == "financial" ) {
	$url = "http://" . $_SERVER['SERVER_NAME'] . preg_replace( '/index.php/', 'financial.html', $_SERVER['SCRIPT_NAME'] );
	echo "<script type=\"text/javascript\">goToURL('$url');</script>";

} elseif( $action == "spiritual" ) {
	$url = "http://" . $_SERVER['SERVER_NAME'] . preg_replace( '/index.php/', 'spiritual.html', $_SERVER['SCRIPT_NAME'] );
	echo "<script type=\"text/javascript\">goToURL('$url');</script>";

} elseif( $action == "paynow" ) {
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
