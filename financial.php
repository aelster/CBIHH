<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>CBI Financial Pledge</title>
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
  </ul>
<!-- end .header --></div>
  <!-- InstanceBeginEditable name="Content" -->
  <input type=hidden name=from id=from value=financial />
  <h2>5774 High Holy Day Appeal </h2>
  <?php
DoQuery( "select sum(amount), count(pledgeType) from pledges where pledgeType = $PledgeTypeFinancial" );
list( $total,$num ) = mysql_fetch_array( $result );
DoQuery( "select amount from pledges where pledgeType = $PledgeTypeFinGoal" );
list( $goal ) = mysql_fetch_array( $result );
	
echo "<hr>";
echo "<div class=to_date>";
echo "<table><tr><td>";
echo "<p class=num>$num</p>";
echo "<p>Donors to date</p>";
echo "</td><td>";
echo "<p class=num>$ " . number_format( $total, 0 ) . "</p>";
echo "<p>Pledged of $ " . number_format( $goal, 0 ) . " goal</p>";
echo "</td></tr></table>";
echo "</div>";
echo "<hr>";
  ?>
  <p>I pledge the following amount:</p>
  <div>
  <?php
  DoQuery( "select multiplier from financial order by multiplier asc" );
  $num_per_row = $gNumRows / 3;
  $i = 0;
  while( list( $mult ) = mysql_fetch_array( $result ) ) {
	  if( $i % $num_per_row == 0 ) {
		  echo "<table class=pledge>\n";
	  }
	  $amount = $mult * 18;
	  printf( "<tr><td><input type=radio name=Pledges value=%d onClick=\"makeActive('pledges');\">\$%s (%d x Chai)</td></tr>\n",
	  	$amount, number_format($amount,0), $mult );
	  $i++;
	  if( $i % $num_per_row == 0 ) {
		  echo "</table>\n";
	  }
  }
  ?>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div>
    <table class=pledge_other>
    <tr>
        <td><input type="radio" name="Pledges" value=other onClick="makeActive('pledges');" />Other: <input type=text name=PledgeOther id=pledgeOther onkeyup="makeActive('pledges');" /></td>
      </tr>
      </table>
	</div>
  </form>
    <p>
      <input type=button class=buttonNotOk id=pledgeNow onclick="setAmount();addAction('pledge_now');" value="Pledge Now" disabled/>
    </p>
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
