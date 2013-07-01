<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>CBI Spiritual Pledge</title>
<!-- InstanceEndEditable -->
<link href="oneColFixCtrHdr.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript" src="hhPledges.js"></script>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>
<body onload="firstName();">

<div class="container">
  <form action="" method="post" id="form1">
  <input type=hidden name=action id=action />
  <input type=hidden name=amount id=amount />
  <input type=hidden name=fields id=fields />
  <div class="header">
  <img id=img1 src="assets/CBI_logo.png" alt="CBI Logo" width="263" height="110"/>
  <img id=img2 src="assets/CBI_header_right.png" width="405" height="96" alt="HeaderName" />
  <ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a href="http://cbi18.org/">CBI Home</a></li>
      <li><a onclick="addAction('pledge');">Pledge Home</a></li>
      <li><a onclick="addAction('financial');">Financial Pledge</a></li>
      <li><a onclick="addAction('spiritual');">Spiritual Pledge</a></li>
<!--
      <li><a onclick="addAction('pledges_to_date');">Pledges To Date</a></li>
-->
  </ul>
<!-- end .header --></div>
  <!-- InstanceBeginEditable name="Content" -->
  <input type=hidden name=from id=from value=spiritual />
  <div class="content">
  <h2>5774 High Holy Day Appeal </h2>
  <?php
DoQuery( "select pledgeIds, pledgeOther from pledges where pledgeType = $PledgeTypeSpiritual" );
$num = $gNumRows;
$mitzvot = 0;
while( list( $ids, $other ) = mysql_fetch_array( $result ) ) {
	if( ! empty( $ids ) ) {
		$tmp = preg_split( '/,/', $ids );
		$mitzvot += count($tmp);
	}
	if( ! empty( $other ) ) {
		$mitzvot++;
	}
}
	
echo "<hr>";
echo "<div class=to_date>";
echo "<table><tr><td>";
echo "<p class=num>$num</p>";
echo "<p>Individuals</p>";
echo "</td><td>";
echo "<p class=num>$mitzvot</p>";
echo "<p>Pledged mitzvot to date<br>See below for (counts)</p>";
echo "</td></tr></table>";
echo "</div>";
echo "<hr>";
  ?>
  <p>I pledge that, during the coming year, I will fulfill the mitzvah/mitzvot which I am choosing below:</p>
    <div class=spirit>
        <div class=spiritLeft>
        <?php
echo "<table class=spiritTable>";
echo "<tr><th>Torah</th></tr>";
DoQuery( "select id, description from spiritual where spiritualType = $SpiritualTorah" );
while( list( $id, $desc ) = mysql_fetch_array( $result ) ) {
	$freq = empty( $gSpiritIDstats[$id] ) ? 0 : $gSpiritIDstats[$id];
	printf( "<tr><td><input type=checkbox name=spirit id=spirit_%d onClick=\"makeActive('spirit');\">(%d) %s</td></tr>",
	 $id, $freq, $desc );
}
echo "</table>";

echo "<table class=spiritTable>";
echo "<tr><th>Avodah</th></tr>";
DoQuery( "select id, description from spiritual where spiritualType = $SpiritualAvodah" );
while( list( $id, $desc ) = mysql_fetch_array( $result ) ) {
	$freq = empty( $gSpiritIDstats[$id] ) ? 0 : $gSpiritIDstats[$id];
	printf( "<tr><td><input type=checkbox name=spirit id=spirit_%d onClick=\"makeActive('spirit');\">(%d) %s</td></tr>",
	 $id, $freq, $desc );
}
echo "</table>";
			?>
      	<table class="spiritTable">
            <tr><th>Other</th></tr>
            <tr><td>
                <input type=checkbox name=spirit id=other onClick="clearSpiritOther();makeActive('spirit');"/>
<?php
$id = 0;
$freq = empty( $gSpiritIDstats[$id] ) ? 0 : $gSpiritIDstats[$id];
echo "(" . $freq . ")";
?>
        		<input type=text size=50 name=other_desc id=spiritOther onkeyup="makeActive('spirit');" value="Check box and enter description" />
			</td></tr>
		</table>
        </div> <!-- end spiritLeft -->
    	<div class=spiritRight>
<?php
echo "<table class=spiritTable>";
echo "<tr><th>Gemilut Chasadim</th></tr>";
DoQuery( "select id, description from spiritual where spiritualType = $SpiritualGemilut" );
while( list( $id, $desc ) = mysql_fetch_array( $result ) ) {
	$freq = empty( $gSpiritIDstats[$id] ) ? 0 : $gSpiritIDstats[$id];

	printf( "<tr><td><input type=checkbox name=spirit id=spirit_%d onClick=\"makeActive('spirit');\">(%d) %s</td></tr>",
	 $id, $freq, 		$desc );
}
echo "</table>";
?>
		</div> <!-- end spiritRight -->
    </div> <!-- end spirit -->
	<div class=spiritBottom>
    <p>
      <input type=button class=buttonNotOk id=spiritNow onclick="spiritFields();addAction('pledge_now');" value="Pledge Now" />
    </p>
    </div>
  </div> <!-- end content -->
  <!-- InstanceEndEditable -->
  <div class="footer">
    <p><img src="assets/CBI_footer.png" width="971" height="194" alt="Footer" /></p>
    <!-- end .footer --></div>
    </form>
  <!-- end .container --></div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
<!-- InstanceEnd --></html>
