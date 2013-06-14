<?php
global $gAction;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<?php
require_once( 'SiteLoader.php' );

SiteLoad( 'CommonV2' );

include( 'local_cbi.php' );
//$gDb = OpenDb();                # Open the MySQL database

global $gAction;
global $gFrom;

?>
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
      <li><a onclick="addAction('pledges_to_date');">Pledges To Date</a></li>
  </ul>
<!-- end .header --></div>
  <!-- InstanceBeginEditable name="Content" -->
  <h2>5774 High Holy Day Appeal </h2>
  <p>I pledge the following amount:</p>
  <div>
  <input type=hidden name=from id=from value="<?php echo $gAction ?>" />
  <table class=pledge>
    <tr><td><input type="radio" name="Pledges" value=18 onClick="makeActive('pledges');" />$18 (Chai)</td></tr>
    <tr><td><input type="radio" name="Pledges" value=36 onClick="makeActive('pledges');" />$36 (2 x Chai)</td></tr>
	<tr><td><input type="radio" name="Pledges" value=54 onClick="makeActive('pledges');" />$54 (3 x Chai)</td></tr>
	<tr><td><input type="radio" name="Pledges" value=72 onClick="makeActive('pledges');" />$72 (4 x Chai)</td></tr>
	<tr><td><input type="radio" name="Pledges" value=90 onClick="makeActive('pledges');" />$90 (5 x Chai)</td></tr>	
  </table>
  <table class=pledge>
    <tr><td><input type="radio" name="Pledges" value=180 onClick="makeActive('pledges');" />$180 (10 x Chai)</td></tr>
    <tr><td><input type="radio" name="Pledges" value=270 onClick="makeActive('pledges');" />$270 (15 x Chai)</td></tr>
	<tr><td><input type="radio" name="Pledges" value=360 onClick="makeActive('pledges');" />$360 (20 x Chai)</td></tr>
	<tr><td><input type="radio" name="Pledges" value=540 onClick="makeActive('pledges');" />$540 (30 x Chai)</td></tr>
	<tr><td><input type="radio" name="Pledges" value=1080 onClick="makeActive('pledges');" />$1080 (60 x Chai)</td></tr>	
  </table>
  <table class=pledge>
    <tr><td><input type="radio" name="Pledges" value=1800 onClick="makeActive('pledges');" />$1800 (100 x Chai)</td></tr>
    <tr><td><input type="radio" name="Pledges" value=3600 onClick="makeActive('pledges');" />$3600 (200 x Chai)</td></tr>
	<tr><td><input type="radio" name="Pledges" value=5400 onClick="makeActive('pledges');" />$5400 (300 x Chai)</td></tr>
	<tr><td><input type="radio" name="Pledges" value=7200 onClick="makeActive('pledges');" />$7200 (400 x Chai)</td></tr>
	<tr><td><input type="radio" name="Pledges" value=9000 onClick="makeActive('pledges');" />$9000 (500 x Chai)</td></tr>	
  </table>
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
