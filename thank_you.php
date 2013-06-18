<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>CBI High Holy Day Pledge Home</title>
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
    <p class="content"><br />
        <br />
      Thank you for your pledge.  You should receive an e-mail confirmation  shortly.
    </p>
    <div style="clear:both;">
      <p>
        <input class=buttonOk type=button onClick="addAction('financial');" value="Make a Financial Pledge" />&nbsp;
        <input class=buttonOk type=button onClick="addAction('spiritual');" value="Make a Spiritual Pledge" />&nbsp;
        <input class=buttonOk type=button onClick="addAction('pledges_to_date');" value="Pledges to Date" />
      </p>
</div>
    <!-- end .content -->
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
