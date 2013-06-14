<?php
global $gSiteName;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<?php
global $gAction;
global $gFrom;

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>CBI Pledge Info Page</title>
<!-- InstanceEndEditable -->
<link href="oneColFixCtrHdr.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript" src="hhPledges.js"></script>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>
<body>

<div class="container">
  <form action="index.php" method="post" id="form1">
  <input type=hidden name=action id=action />
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
  <h2>5774 High Holy Day Appeal - <?php echo $gFrom ?></h2>
      <table>
        <tr>
          <td>First Name</td>
          <td><input type="text" name="paynow" id="firstName" oninput="makeActive('paynow');" size=60 /></td>
        </tr>
        <tr>
          <td width="130">Last Name</td>
          <td width="442"><input type="text" name="paynow" id="lastName" oninput="makeActive('paynow');" size=60 /></td>
        </tr>
        <tr>
          <td>Phone #</td>
          <td><input type="text" name="paynow" id="phone" oninput="makeActive('paynow');" size=60 /></td>
        </tr>
        <tr>
          <td>E-mail Address</td>
          <td><input type="text" name="paynow" id="email" oninput="makeActive('paynow');" size=60 /></td>
        </tr>
      </table>
      <table width="600">
        <tr>
          <td><label>
            <input type="radio" name="paynow" value="credit" onClick="makeActive('paynow');" id="payment_0" />
            Charge my credit card on file</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="radio" name="paynow" value="check" onClick="makeActive('paynow');" id="payment_1" />
            I will send a check within three days</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="radio" name="paynow" value="call" onClick="makeActive('paynow');" id="payment_2" />
            Contact me about payment</label></td>
        </tr>
      </table>
      <h2>
      <input type=button onclick="payNow();addAction('paynow');" class=pledgeBtn id=paynow value=Submit />
      </h2>
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
