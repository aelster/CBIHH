<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CBI HH Pledges</title>

<script type="text/javascript">
function goToURL(page) {
	window.location.href = page;
}
</script>
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

} else {
	echo "uh-oh, not sure what to do with action: [$action]<br>";
}
?>
</body>
</html>
