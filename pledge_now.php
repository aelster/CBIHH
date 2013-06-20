<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
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
  <?php
  if( $gFrom == "financial" ) {
	  $tag = "Financial Pledge";
	  $radio = 1;
  } else if( $gFrom == "spiritual" ) {
	  $tag = "Spiritual Pledge";
	  $radio = 0;
  }
  printf( "<input type=hidden name=from id=from value=\"%s\">", $gFrom );
  echo "<script type='text/javascript'>\n";
  printf( "var radio_required = %d;\n", $radio );
  printf( "var pledge_amount = '%.2f';\n", $_POST['amount'] );
  printf( "var gFrom = '%s';\n", $gFrom );
  printf( "var pledgeIds = new Array();\n" );
  printf( "var pledgeOther = '';\n" );
  echo "</script>\n";
  ?>
  <div class="content">
  <h2>5774 High Holy Day Appeal<br /><?php echo $tag ?></h2>
  <?php
  if( $gFrom == "financial" ) {
	  $amount = $_POST['amount'];
	  printf( "<p>Thank you for your generous pledge of \$ %.2f.</p>", number_format($amount, 2 ) );
  } else if( $gFrom == 'spiritual' ) {
	  echo "<div class=spirit_detail>";
	  printf( "Thank you for your pledge to:<br>" );
	  $items = preg_split( '/\|/', $_POST['fields'] );
	  echo "<ul>\n";
	  foreach( $items as $item ) {
		  if( preg_match( '/^spirit_/', $item ) ) {
			  list( $na, $id ) = preg_split( '/_/', $item );
			  $desc = $gSpiritIDtoDesc[$id];
			  printf( "<script type='text/javascript'>pledgeIds.push('id_' + %d);</script>\n", $id );
		  } else {
			  $desc = CleanString( $_POST['other_desc'] );
			  printf( "<script type='text/javascript'>pledgeOther = '%s';</script>\n", $desc );
		  }
		  echo "<li>$desc</li>\n";
	  }
	  echo "</ul>";
	  echo "</div><br>";
  }
  ?>
      <table>
        <tr>
          <td>*&nbsp;First Name</td>
          <td><input type="text" name="paynow" id="firstName" onchange="makeActive('paynow');" onkeyup="makeActive('paynow');" size=60 /></td>
        </tr>
        <tr>
          <td width="130">*&nbsp;Last Name</td>
          <td width="442"><input type="text" name="paynow" id="lastName" onchange="makeActive('paynow');" onkeyup="makeActive('paynow');" size=60 /></td>
        </tr>
        <tr>
          <td>*&nbsp;Phone #</td>
          <td><input type="text" name="paynow" id="phone" onchange="makeActive('paynow');" onkeyup="makeActive('paynow');" size=60 /></td>
        </tr>
        <tr>
          <td>*&nbsp;E-mail Address</td>
          <td><input type="text" name="paynow" id="email" onchange="makeActive('paynow');" onkeyup="makeActive('paynow');" size=60 /></td>
        </tr>
<?php
if( $gFrom == 'financial' ) {
		  echo <<<END
  <tr>
	<td>*&nbsp;Payment (select one)</td>
	<td>
      <table width="600">
        <tr>
          <td><label>
            <input type="radio" name="paynow" value=$PaymentCredit onClick="makeActive('paynow');" />
            Charge my credit card on file</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="radio" name="paynow" value=$PaymentCheck onClick="makeActive('paynow');" />
            I will send a check within three days</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="radio" name="paynow" value=$PaymentCall onClick="makeActive('paynow');" />
            Contact me about payment</label></td>
        </tr>
      </table>
	</td>
  </tr>
END;
}
?>
	</table>
      <h2>
      <input type=button onclick="payNow();addAction('paynow');" class=pledgeBtn id=paynow value=Submit disabled/>
      </h2>
      <p class="left"><em class=left>*</em>&nbsp;Required fields</p>
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
