<?php
global $gAction;
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
  <form action="index.php" method="post" id="form1">
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
  <h2>5774 High Holy Day Appeal </h2>
  <p>I pledge that, during the coming year, I will fulfill the mitzvah/mitzvot which I am choosing below:</p>
    <div class=spirit>
        <div class=spiritLeft>
  		<input type=hidden name=from id=from value="<?php echo $gAction ?>" />
		<table class=spiritTable>
            <tr><th>Torah</th></tr>
            <tr><td><input type=checkbox name=spirit id=torah1 onClick="makeActive('spirit');"/>Learn to read Hebrew or increase my Hebrew skills</td></tr>
            <tr><td><input type=checkbox name=spirit id=torah2 onClick="makeActive('spirit');"/>Learn to put on a tallit or tefillin</td></tr>
            <tr><td><input type=checkbox name=spirit id=torah3 onClick="makeActive('spirit');"/>Attend Adult Education classes</td></tr>
            <tr><td><input type=checkbox name=spirit id=torah4 onClick="makeActive('spirit');"/>Celebrate an Adult Bar/Bat Mitzvah</td></tr>
        </table>
        <table class="spiritTable" >
            <tr><th>Avodah</th></tr>
            <tr><td><input type=checkbox name=spirit id=avodah1 onClick="makeActive('spirit');"/>Chant Torah/Haftorah</td></tr>
            <tr><td><input type=checkbox name=spirit id=avodah2 onClick="makeActive('spirit');"/>Attend Sunday and/or Wednesday morning Minyan</td></tr>
            <tr><td><input type=checkbox name=spirit id=avodah3 onClick="makeActive('spirit');"/>Learn to lead services</td></tr>
            <tr><td><input type=checkbox name=spirit id=avodah4 onClick="makeActive('spirit');"/>Attend Shabbat Services</td></tr>
            <tr><td><input type=checkbox name=spirit id=avodah5 onClick="makeActive('spirit');"/>Incorporate meditation into my day</td></tr>
        </table>
      	<table class="spiritTable">
            <tr><th>Other</th></tr>
            <tr><td>
                <input type=checkbox name=spirit id=other onClick="clearSpiritOther();makeActive('spirit');"/>
        		<input type=text size=55 name=other_desc id=spiritOther onkeyup="makeActive('spirit');" value="Check box and enter description" />
			</td></tr>
		</table>
        </div> <!-- end spiritLeft -->
    	<div class=spiritRight>
      	<table class="spiritTable">
            <tr><th>Gemilut Chasadim</th></tr>
            <tr><td><input type=checkbox name=spirit id=gemilut1 onClick="makeActive('spirit');"/>Prepare food for the Family Promise program</td></tr>
            <tr><td><input type=checkbox name=spirit id=gemilut2 onClick="makeActive('spirit');"/>Attend a Shivah Minyan</td></tr>
            <tr><td><input type=checkbox name=spirit id=gemilut3 onClick="makeActive('spirit');"/>Join the Chessed committee</td></tr>
            <tr><td><input type=checkbox name=spirit id=gemilut4 onClick="makeActive('spirit');"/>Visit the elderly or ill</td></tr>
            <tr><td><input type=checkbox name=spirit id=gemilut5 onClick="makeActive('spirit');"/>Become an usher at Shabbat Services</td></tr>
            <tr><td><input type=checkbox name=spirit id=gemilut6 onClick="makeActive('spirit');"/>Invite guests for Shabbat Dinner</td></tr>
            <tr><td><input type=checkbox name=spirit id=gemilut7 onClick="makeActive('spirit');"/>Become a Buddy for a new family</td></tr>
            <tr><td><input type=checkbox name=spirit id=gemilut8 onClick="makeActive('spirit');"/>Volunteer at Sunday supper</td></tr>
            <tr><td><input type=checkbox name=spirit id=gemilut9 onClick="makeActive('spirit');"/>Donate blood</td></tr>
            <tr><td><input type=checkbox name=spirit id=gemilut10 onClick="makeActive('spirit');"/>Volunteer in the CBI office</td></tr>
        </table>
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
