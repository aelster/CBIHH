<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Pledges to Date</title>
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
      <li><a onclick="addAction('pledges_to_date');">Pledges To Date</a></li>
  </ul>
<!-- end .header --></div>
  <!-- InstanceBeginEditable name="Content" -->
  <div class="content">
    <h2>5774 High Holy Day Appeal</h2>
<div class=spirit>
        <div class=spiritLeft>
<?php
$num_cols = 3;
$tr_spacer = "class=spacer";
$td_spacer = "class=col_left";
echo "<table class=spiritTable>";
echo "<tr><th colspan=$num_cols>Financial Summary</th></tr>";

echo "<tr $tr_spacer><td colspan=$num_cols>&nbsp;</td></tr>";

echo "<tr>";
echo "<td $td_spacer>&nbsp;</td>";
DoQuery( "select * from pledges where pledgeType = $PledgeTypeFinancial" );
echo "<td class=box>$gNumRows</td>";
echo "<td>Pledges</td>";
echo "</tr>";

echo "<tr $tr_spacer><td colspan=$num_cols>&nbsp;</td></tr>";

echo "<tr>";
echo "<td $td_spacer>&nbsp;</td>";
DoQuery( "select sum( amount ) from pledges where pledgeType = $PledgeTypeFinancial" );
list( $amount ) = mysql_fetch_array( $result );
echo "<td class=box>\$ " . number_format( $amount ) . "</td>";
DoQuery( "select amount from pledges where pledgeType = $PledgeTypeFinGoal" );
list( $goal ) = mysql_fetch_array( $result );
printf( "<td>Toward \$ %s goal</td>", number_format($goal) );
echo "</tr>";

echo "<tr $tr_spacer><td colspan=$num_cols>&nbsp;</td></tr>";

echo "</table>";
?>
</div> <!--   end class=spiritLeft -->

<div class=spiritRight>
<?php
$td_spacer = "class=col_right";

echo "<table class=spiritTable>";
echo "<tr><th colspan=$num_cols>Spiritual Summary</th></tr>";

echo "<tr $tr_spacer><td colspan=$num_cols>&nbsp;</td></tr>";

echo "<tr>";
echo "<td $td_spacer>&nbsp;</td>";
DoQuery( "select * from pledges where pledgeType = $PledgeTypeSpiritual" );
echo "<td class=box>$gNumRows</td>";
echo "<td>Pledges</td>";
echo "</tr>";

echo "<tr $tr_spacer><td colspan=$num_cols>&nbsp;</td></tr>";

echo "<tr>";
echo "<td $td_spacer>&nbsp;</td>";
DoQuery( "select pledgeIds, pledgeOther from pledges where pledgeType = $PledgeTypeSpiritual" );
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
echo "<td class=box>" . number_format( $mitzvot ) . "</td>";
printf( "<td>Mitzvot</td>" );
echo "</tr>";

echo "<tr $tr_spacer><td colspan=$num_cols>&nbsp;</td></tr>";

echo "</table>";
?>
</div>

</div> <!-- end class=spirit -->
  </div>
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
