<?php

function AddForm() {
	include( 'globals.php' );
	echo "<form name=fMain id=fMain method=post action=\"$gSourceCode\">";
	
	$hidden = array( 'action', 'area', 'fields', 'func', 'from', 'id' );
	foreach( $hidden as $var ) {
		$tag = MakeTag($var);
		echo "<input type=hidden $tag>";
	}
}

function CleanString ($data) {
	$data = trim($data);
	$data = addslashes($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_QUOTES );
	return $data;
}

function DisplayFinancial() {
	include( 'globals.php' );
	if( $gTrace ) {
		$gFunction[] = "DisplayFinancial()";
		Logger();
	}
	
	$area = $_POST['area'];
	$func = $_POST['func'];
	
	$ok_to_edit = UserManager( 'authorized', 'admin' );
	echo "<div class=CommonV2>";
	echo "<input type=button value=Back onclick=\"setValue('from', '$func');addAction('Back');\">";
	
	DoQuery( "select sum(amount) from pledges where pledgeType = $PledgeTypeFinancial" );
	list( $total ) = mysql_fetch_array( $result );
	
	DoQuery( "select amount from pledges where pledgeType = $PledgeTypeFinGoal" );
	list( $goal ) = mysql_fetch_array( $result );
	
	DoQuery( "select * from pledges where pledgeType = $PledgeTypeFinancial order by amount desc, lastName asc" );
	echo "<ul>";
	echo "<li>The columns are sortable by clicking on their header</li>";
	$x = $total * 100.0 / $goal;
	printf( "<li>Total pledges: \$ %s ( %d %% of \$ %s goal)</li>", number_format( $total ), intval($x), number_format( $goal ) );
	echo "</ul>";
	echo "<div class=CommonV2>";
	echo "<table class=sortable>";
	echo "<tr>";
	echo "  <th>#</th>";
	echo "  <th>Amount</th>";
	echo "  <th>Donor</th>";
	echo "  <th>Phone</th>";
	echo "  <th>Method</th>";
	echo "  <th>Date/Time</th>";
	if( $ok_to_edit ) {
		echo "<th>Action</th>";
	}
	echo "</tr>";
	
	$methods = array( $PaymentCredit => 'Credit', $PaymentCheck => 'Check', $PaymentCall => 'Call' );
	
	$i = 0;
	while( $rec = mysql_fetch_assoc( $result ) ) {
		$i++;
		echo "<tr>";
		printf( "<td>%d</td>", $i );
		printf( "<td style=\"text-align:right;\">\$ %s</td>", number_format( $rec['amount'], 2 ) );
		printf( "<td>%s %s</td>", $rec['lastName'], $rec['firstName'] );
		printf( "<td>%s</td>", FormatPhone( $rec['phone']) );
		printf( "<td class=c>%s</td>", $methods[ $rec['paymentMethod'] ] );
		$ts = strtotime( $rec['timestamp'] );
		printf( "<td>%s</td>", date( 'j-M-Y h:i A', $ts ) );
		if( $ok_to_edit ) {
			echo "<td>";
			$jsx = array();
			$jsx[] = "setValue('area','$area')";
			$jsx[] = sprintf( "setValue('id','%d')", $rec['id']);
			$jsx[] = "addAction('Edit')";
			$js = sprintf( "onclick=\"%s\"", join(';',$jsx) );
			echo "<input type=button value=Edit $js>";
			$jsx = array();
			$jsx[] = "setValue('area','$area')";
			$jsx[] = "setValue('from','DisplayFinancial')";
			$jsx[] = "setValue('func','delete')";
			$jsx[] = sprintf( "setValue('id','%d')", $rec['id']);
			$txt = sprintf( "Are you sure you want to delete %s %s's donation for \$ %s?",
								$rec['firstName'], $rec['lastName'], number_format($rec['amount'],2));
			$jsx[] = sprintf( "myConfirm('%s')", CVT_Str_to_Overlib($txt) );
			$js = sprintf( "onclick=\"%s\"", join(';',$jsx) );
			echo "<input type=button value=Delete $js>";
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	echo "</div>";

	if( $gTrace ) array_pop( $gFunction );
}

function DisplayGoal() {
	include( 'globals.php' );
	if( $gTrace ) {
		$gFunction[] = "DisplayGoal()";
		Logger();
	}
	
	$area = $_POST['area'];
	$func = $_POST['func'];
	
	echo "<div class=CommonV2>";
	echo "<input type=button value=Back onclick=\"setValue('from', '$func');addAction('Back');\">";

	$tag = MakeTag('update');
	$jsx = array();
	$jsx[] = "setValue('area','$area')";
	$jsx[] = "setValue('from','DisplayGoal')";
	$jsx[] = "setValue('func','update')";
	$jsx[] = "addAction('Update')";
	$js = sprintf( "onClick=\"%s\"", join(';',$jsx) );
	echo "<input type=button value=Update $tag $js>";

	echo "<p>Financial goal:&nbsp;&nbsp;";
	DoQuery( "select amount from pledges where pledgeType = $PledgeTypeFinGoal" );
	list( $goal ) = mysql_fetch_array( $result );
	$tag = MakeTag( 'goal' );
	$jsx = array();
	$jsx[] = "setValue('area','$area')";
	$jsx[] = "setValue('from','DisplayGoal')";
	$jsx[] = "addField('goal')";
	$jsx[] = "toggleBgRed('update')";
	$js = sprintf( "onKeyDown=\"%s\"", join(';',$jsx) );
	printf( "<input type=text $tag $js id=goal size=20 value=\"\$ %s\">", number_format( $goal, 0 ) );
	echo "</p>";
	echo "</div>";

	if( $gTrace ) array_pop( $gFunction );
}

function DisplayMain() {
	include( 'globals.php' );
	if( $gTrace ) {
		$gFunction[] = "DisplayMain()";
		Logger();
	}
	
	$func = $_POST['func'];
	$area = $_POST['area'];
	
	if( $area == 'financial' ) {
		DisplayFinancial();
		
	} elseif( $area == 'spiritual' ) {
		DisplaySpiritual();
		
	} elseif( $area == 'goal' ) {
		DisplayGoal();
	
	} elseif( $func == 'users' ) {
		UserManager( 'control' );
		
	} elseif( $func == 'privileges' ) {
		UserManager( 'privileges' );
		
	} else {
		if( UserManager( 'authorized', 'admin' ) ) {
			echo "<div class=admin>";
			echo "<h3>Admin features</h3>";
			echo "<input type=button onclick=\"setValue('func','users');addAction('Main');\" value=Users>";
			echo "<input type=button onclick=\"setValue('func','privileges');addAction('Main');\" value=Privileges>";

			$jsx = array();
			$jsx[] = "setValue('area','goal')";
			$jsx[] = "addAction('Main')";
			$js = sprintf( "onClick=\"%s\"", join(';',$jsx) );
			echo "<input type=button $js value=Goal>";

			$jsx = array();
			$jsx[] = "setValue('area','reset')";
			$jsx[] = "setValue('from','DisplayMain')";
			$jsx[] = "myConfirm('Are you sure you want to delete all pledges?')";
			$js = sprintf( "onClick=\"%s\"", join(';',$jsx) );
			echo "<input type=button $js value='Reset Pledges'>";

			DoQuery( "select sum(amount) from pledges where pledgeType = $PledgeTypeFinancial" );
			list( $total ) = mysql_fetch_array( $result );
			
			DoQuery( "select amount from pledges where pledgeType = $PledgeTypeFinGoal" );
			list( $goal ) = mysql_fetch_array( $result );
			
			DoQuery( "select * from pledges where pledgeType = $PledgeTypeFinancial order by amount desc, lastName asc" );
			echo "<ul>";
			$x = $total * 100.0 / $goal;
			printf( "<li>Total financial pledges: \$ %s ( %d %% of \$ %s goal)</li>", number_format( $total ), intval($x), number_format( $goal ) );
		
			DoQuery( "select pledgeIds, pledgeOther from pledges where pledgeType = $PledgeTypeSpiritual" );
			$num_pledges = $gNumRows;
			$num_spirit = 0;
			while( list( $ids, $other ) = mysql_fetch_array( $result ) ) {
				$num_spirit += count( preg_split( '/,/', $ids ) );
				if( ! empty( $other ) ) $num_spirit++;
			}
			printf( "<li>Total spiritual pledegs: %d ( %d mitzvot )</li>", $num_pledges, $num_spirit );
			echo "</ul>";

			echo "</div>";
			echo "<br>";
		}
		$jsx = array();
		$jsx[] = "setValue('area','financial')";
		$jsx[] = "addAction('Main')";
		$js = sprintf( "onClick=\"%s\"", join(';',$jsx) );
		echo "<input type=button $js value=Financial>";
		
		$jsx = array();
		$jsx[] = "setValue('area','spiritual')";
		$jsx[] = "addAction('Main')";
		$js = sprintf( "onClick=\"%s\"", join(';',$jsx) );
		echo "<input type=button $js value=Spiritual>";
		
		echo "<br>";
		echo "<input type=button onclick=\"addAction('Logout');\" value=Logout>";
	}
	
	if( $gTrace ) array_pop( $gFunction );
}

function DisplaySpiritual() {
	include( 'globals.php');
	if( $gTrace ) {
		$gFunction[] = "DisplaySpiritual()";
		Logger();
	}

	$func = $_POST['func'];
	
	echo "<div class=CommonV2>";
	echo "<input type=button value=Back onclick=\"setValue('from', '$func');addAction('Back');\">";
	
	DoQuery( "select * from pledges where pledgeType = $PledgeTypeSpiritual" );
	$hist = array();
	$other = array();
	$people = array();
	
	foreach( $gSpiritIDtoDesc as $id => $desc ) {
		$hist[$id] = 0;
	}
	
	while( $rec = mysql_fetch_assoc( $result ) ) {
		$str = FormatPhone( $rec['phone'] );
		$tmp = preg_split( '/,/', $rec['pledgeIds'] );
		if( count( $tmp ) ) {
			foreach( $tmp as $id ) {
				$hist[$id]++;
				$people[$id][] = sprintf( "%s, %s: %s", $rec['lastName'], $rec['firstName'], $str );
			}
		}
		if( ! empty( $rec['pledgeOther'] ) ) {
			$desc = $rec['pledgeOther'];
			if( empty( $other[ $desc ] ) ) {
				$other[$desc] = 0;
				$other[$desc]++;
				$people[$desc][] = sprintf( "%s, %s: %s",  $rec['lastName'], $rec['firstName'], $str );
			}
		}
	}

	arsort( $hist );
	
	echo "<ul><li>The columns are sortable by clicking on their header</li></ul>";
	echo "<table class=sortable>";
	echo "<tr>";
	echo "  <th>Mitzvah</th>";
	echo "  <th># Selected</th>";
	echo "</tr>";
	
	foreach( $hist as $id => $count ) {
		if( empty( $count ) ) continue;
		echo "<tr>";
		printf( "<td>%s</td>", $gSpiritIDtoDesc[$id] );
		echo "<td class=c>";
		$tag = number_format($count,0);
		$str = join( '<br>', $people[$id] );
		$cap = $gSpiritIDtoDesc[$id];
		echo <<<END
<a href="javascript:void(0);"
onmouseover="return overlib('$str', WIDTH, 300, CAPTION, '$cap')"
onmouseout="return nd();">$tag
</a>
END;
		echo "</td>";
		echo "</tr>";
	}
	foreach( $other as $desc => $count ) {
		echo "<tr>";
		printf( "<td>%s (other)</td>", $desc );
		echo "<td class=c>";
		$tag = number_format($count,0);
		$str = $people[$desc][0];
		$cap = 'caption';
		echo <<<END
<a href="javascript:void(0);"
onmouseover="return overlib('$str', WIDTH, 300, CAPTION, '$cap')"
onmouseout="return nd();">$tag
</a>
END;
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "</div>";
		
	if( $gTrace ) array_pop( $gFunction );
}

function GoalUpdate() {
	include( 'globals.php' );
	if( $gTrace ) {
		$gFunction[] = "GoalUpdate()";
		Logger();
	}
	
	$goal = preg_replace( '/[^0-9]/', '', $_POST['goal'] );
	DoQuery( "select * from pledges where pledgeType = $PledgeTypeFinGoal" );
	if( $gNumRows ) {
		DoQuery( "update pledges set amount = $goal where pledgeType = $PledgeTypeFinGoal" );
	} else {
		DoQuery( "insert into pledges set pledgeType = $PledgeTypeFinGoal, amount = $goal" );
	}
	
	if( $gTrace ) array_pop( $gFunction );	
}

function LocalInit() {
	include( 'globals.php' );
	
	$gDebug = 0;
	$gTrace = 0;
	$x = isset( $_REQUEST['bozo'] ) ? 1 : 0;
	if( $x ) {
		$gDebug = $x;
		$gTrace = $x;
	}

	$gFrom = array_key_exists( 'from', $_POST ) ? $_POST['from'] : '';
	$gFunction = array();
	$gSourceCode = $_SERVER['REQUEST_URI'];
	
	$gSpiritIDtoDesc = array();
	DoQuery( "select id, description from spiritual" );
	while( list( $id, $desc ) = mysql_fetch_array( $result ) ) {
		$gSpiritIDtoDesc[$id] = $desc;
	}
	
	$gSpiritIDstats = array();
	DoQuery( "select pledgeIds, pledgeOther from pledges" );
	while( list( $pids, $pother ) = mysql_fetch_array( $result ) ) {
		$tmp = preg_split( '/,/', $pids );
		foreach( $tmp as $id ) {
			if( empty( $gSpiritIDstats[$id] ) ) $gSpiritIDstats[$id] = 0;
			$gSpiritIDstats[$id]++;
		}
		$id = 0;
		if( ! empty( $pother ) ) {
			if( empty( $gSpiritIDstats[$id] ) ) $gSpiritIDstats[$id] = 0;
			$gSpiritIDstats[$id]++;
		}
	}
}

function PayPal() {
	include( 'globals.php' );
	if( $gTrace ) {
		$gFunction[] = "PayPal()";
		Logger();
	}
	
	foreach( array('amount','email','firstName','lastName','phone') as $fld ) {
		$$fld = $_POST[$fld];
	}
	
	echo <<<END
<form name=form_paypal action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="amount" value="$amount">
	<input type="hidden" name="email" value="$email">
	<input type="hidden" name="first_name" value="$firstName">
	<input type="hidden" name="last_name" value="$lastName">
	<input type="hidden" name="phone" value="$phone">
	<input type="image" src="http://www.cbi18.org/images/Donate_sm.jpg" border="0"
		  name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<script type="text/javascript">
form_paypal.submit();
</script>
END;

	if( $gTrace ) array_pop( $gFunction );
}
	
function PledgeEdit() {
	include( 'globals.php' );
	if( $gTrace ) {
		$gFunction[] = "PledgeEdit()";
		Logger();
	}
	
	$id = $_POST['id'];
	$area = $_POST['area'];
	DoQuery( "select * from pledges where id = '$id'" );
	$rec = mysql_fetch_assoc( $result );
	
	echo "<input type=button value=Back onclick=\"setValue('from', 'PledgeEdit');addAction('Back');\">";
	
	$tag = MakeTag('update');
	$jsx = array();
	$jsx[] = "setValue('area','$area')";
	$jsx[] = "setValue('from','PledgeEdit')";
	$jsx[] = "setValue('id','$id')";
	$jsx[] = "setValue('func','update')";
	$jsx[] = "addAction('Update')";
	$js = sprintf( "onClick=\"%s\"", join(';',$jsx) );
	echo "<input type=button value=Update $tag $js>";

	echo "<div class=CommonV2>";
	
	if( $area == 'financial' ) {
		echo "<table>";
		echo "<tr><th>Field</th><th class=val>Value</th></tr>";
		$fields = array( 'firstName' => 'First Name',
							 'lastName' => 'Last Name',
							 'phone' => 'Phone',
							 'email' => 'E-mail' );
		foreach( $fields as $key => $label  ) {
			echo "<tr>";
			echo "<td>$label</td>";
			$jsx = array();
			$jsx[] = "setValue('area','$area')";
			$jsx[] = "setValue('from','PledgeEdit')";
			$jsx[] = "addField('$key')";
			$jsx[] = "toggleBgRed('update')";
			$js = sprintf( "onKeyDown=\"%s\"", join(';',$jsx) );
			printf( "<td><input type=text size=50 name=%s value=\"%s\" $js></td>", $key, $rec[$key] );
			echo "</tr>";
		}
		$jsx = array();
		$jsx[] = "setValue('area','$area')";
		$jsx[] = "setValue('from','PledgeEdit')";
		$jsx[] = "addField('amount')";
		$jsx[] = "toggleBgRed('update')";
		$js = sprintf( "onKeyDown=\"%s\"", join(';',$jsx) );
		echo "<tr>";
		echo "<td>Amount</td>";
		printf( "<td><input type=text size=50 name=amount value=\"\$ %s\" $js></td>",
				number_format( $rec['amount'], 2 ) );
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>Payment Method</td>";
		$tag = MakeTag( 'paymentMethod');
		$types = array( $PaymentCredit => 'Credit', $PaymentCheck => 'Check', $PaymentCall => 'Call' );
		$jsx = array();
		$jsx[] = "setValue('area','$area')";
		$jsx[] = "setValue('from','PledgeEdit')";
		$jsx[] = "addField('paymentMethod')";
		$jsx[] = "toggleBgRed('update')";
		$js = sprintf( "onChange=\"%s\"", join(';',$jsx) );
		echo "<td><select $tag $js>";
		foreach( $types as $val => $label ) {
			$selected = ( $val == $rec['paymentMethod'] ) ? "selected" : "";
			echo "<option value=$val $selected>$label</option>";
		}
		echo "</select></td>";
		echo "</tr>";
		echo "</table>";
	}
	
	echo "</div>";
	
	if( $gTrace ) array_pop( $gFunction );
}

function PledgeStore() {
	include( 'globals.php' );
	if( $gTrace ) {
		$gFunction[] = "PledgeStore()";
		Logger();
	}
	
	$args = array();
	$tmp = preg_split( '/\|/', $_POST['fields'] );
	foreach( $tmp as $nvp ) {
		list( $name, $value ) = preg_split( '/=/', $nvp );
		$_SESSION[$name] = $value;
		if( $name == 'pledgeIds' ) {
			$pledgeIds = array();
			$tmp2 = preg_split( '/,/', $value );
			foreach( $tmp2 as $xx ) {
				list( $key, $id ) = preg_split( '/_/', $xx );
				if( $key == "id" ) {
					$pledgeIds[] = $id;
				}
			}
			$args[] = sprintf( "pledgeIds = '%s'", join(',', $pledgeIds ) );
			 
		} elseif( $name == "phone" ) {
			$args[] = "phone = " . preg_replace("/[^0-9]/", "", $value);
	
		} else {
			$args[] = sprintf( "%s = '%s'", $name, addslashes($value) );
		}
	}
	
	if( $gFrom == 'financial' ) {
		$args[] = "pledgeType = $PledgeTypeFinancial";
		$args[] = sprintf( "paymentMethod = '%d'", $_POST['paynow'] );
	
	} else {
		$args[] = "pledgeType = $PledgeTypeSpiritual";
	}
	
	$query = "insert into pledges set " . join( ',', $args );
	DoQuery( $query );

	if( $gTrace ) array_pop( $gFunction );
}

function PledgeUpdate() {
	include( 'globals.php' );
	if( $gTrace ) {
		$gFunction[] = "PledgeUpdate()";
		Logger();
	}
	
	$func = $_POST['func'];
	$id = $_POST['id'];
	
	if( $func == 'update' ) {
		$tmp = preg_split( '/,/', $_POST['fields'] );  // This is what was touched
		$keys = array_unique( $tmp );
		$qx = array();
		foreach( $keys as $key ) {
			$val = CleanString($_POST[$key]);
			if( $key == 'phone' ) {
				$val = preg_replace("/[^0-9]/", "", $val );
			} elseif( $key == 'amount' ) {
				$val = preg_replace( "/[\$,]/", "", $val );
			}
			$qx[] = sprintf( "`%s` = '%s'", $key, $val );
		}
		$query = sprintf( "update pledges set %s where id = $id", join( ',', $qx ) );
		DoQuery( $query );
		
	} elseif( $func == 'delete' ) {
		$query = sprintf( "delete from pledges where id = $id" );
		DoQuery( $query );
	}
	
	if( $gTrace ) array_pop( $gFunction );
}

function SendConfirmation() {
	include( 'globals.php' );
	if( $gTrace ) {
		$gFunction[] = "SendConfirmation()";
		Logger();
	}
	
	$post = $_POST;

	$tmp = preg_split( '/\|/', $post['fields'] );
	foreach( $tmp as $xx ) {
		list( $key, $val ) = preg_split( '/=/', $xx );
		$$key = $val;
	}

	$subject = "CBI " . ucfirst( $post['from'] ) . " Pledge Confirmation";
	$message = Swift_Message::newInstance($subject);

	$html = $text = array();
	$cid = $message->embed(Swift_Image::fromPath('assets/CBI_ner_tamid.png'));

	$html[] = "<html><head></head><body>";
	$html[] = '<img src="' . $cid . '" alt="Image" /><br>';
	$html[] = "Dear $firstName $lastName,<br><br>";
	if( $post['from'] == 'financial' ) {
		$html[] = "&nbsp;&nbsp;Thank you for your pledge of \$ " . number_format( $amount, 2 ) . ".";
		$pmt_type = $post['paynow'];
		switch( $pmt_type ) {
			case $PaymentCredit:
				$html[] = "&nbsp;We will charge your credit card on file.";
				break;
				
			case $PaymentCheck:
				$html[] = "&nbsp;Please send or drop off your check at your earliest convenience.";
				break;
				
			case $PaymentCall:
				$html[] = "&nbsp;The office will contact you to arrange for payment.";
				break;
		}
		
	} else {
		$tmp = preg_split( '/,/', $pledgeIds );
		$j = count($tmp);
		$j += empty( $pledgeOther ) ? 0 : 1;
		$word = ( $j > 1 ) ? "mitzvot" : "mitzvah";
		$html[] = "&nbsp;&nbsp;Thank you for your pledge of the following $word:<br>";
		$html[] = "<ul>";
		if( count( $tmp ) ) {
			foreach( $tmp as $tag ) {
				list( $na, $id ) = preg_split( '/_/', $tag );
				$html[] = sprintf( "<li>%s</li>", $gSpiritIDtoDesc[$id] );
			}
		}
		if( ! empty( $pledgeOther ) ) {
			$html[] = sprintf( "<li>%s</li>", $pledgeOther );
		}
		$html[] = "</ul>";
	}
	
	$html[] = "<br><br>";
	$html[] = "L'Shanah Tovah, may the new year be a meaningful one for you.";
	
	$text[] = "Dear $firstName $lastName,\n";
	if( $post['from'] == 'financial' ) {
		$text[] = "  Thank you for your pledge of \$ " . number_format( $amount, 2 ) . ".";
		$pmt_type = $post['paynow'];
		switch( $pmt_type ) {
			case $PaymentCredit:
				$text[] = " We will charge your credit card on file.";
				break;
				
			case $PaymentCheck:
				$text[] = " Please send or drop off your check at your earliest convenience.";
				break;
				
			case $PaymentCall:
				$text[] = " The office will contact you to arrange for payment.";
				break;
		}
		
	} else {
		$tmp = preg_split( '/,/', $pledgeIds );
		$j = count($tmp);
		$j += empty( $pledgeOther ) ? 0 : 1;
		$word = ( $j > 1 ) ? "mitzvot" : "mitzvah";
		$text[] = "  Thank you for your pledge of the following $word:\n";
		$text[] = "\n";
		if( count( $tmp ) ) {
			foreach( $tmp as $tag ) {
				list( $na, $id ) = preg_split( '/_/', $tag );
				$text[] = sprintf( "  o %s\n", $gSpiritIDtoDesc[$id] );
			}
		}
		if( ! empty( $pledgeOther ) ) {
			$text[] = sprintf( "  o %s\n", $pledgeOther );
		}
		$text[] = "\n";
	}

	$text[] = "\n";
	$text[] = "L'Shanah Tovah, may the new year be a meaningful one for you.";
	
	$message
	->setFrom(array('cbi18@cbi18.org' => 'CBI'))
	->setTo(array( $email => "$firstName $lastName" ) )
	->setBcc(array( 'beth@elsternet.com' => 'Beth Elster' ) )
	->setBody( join('',$html), 'text/html' )
	->addPart( join('',$text), 'text/plain' )
	;

	MyMail($message);

	if( $gTrace ) array_pop( $gFunction );
}

function WriteHeader() {
	include( 'globals.php' );
	
	echo "<html>";
	echo "<head>";
	
	$styles = array();
	$styles[] = "/css/CommonV2.css";
	$styles[] = "admin.css";
	
	foreach( $styles as $style ) {
		printf( "<link href=\"%s\" rel=\"stylesheet\" type=\"text/css\" />", $style );
	}

	$scripts = array();
	$scripts[] = "/scripts/overlib/overlib.js";
	$scripts[] = "/scripts/overlib/overlib_hideform.js";
	$scripts[] = "/scripts/commonv2.js";
	$scripts[] = "/scripts/sha256.js";
	$scripts[] = "/scripts/sorttable.js";
	
	foreach( $scripts as $script ) {
		printf( "<script type=\"text/javascript\" src=\"%s\"></script>\n", $script );
	}
	echo "</head>";
	echo "<body>";
	AddOverlib();
	echo "<div class=center>";
	echo "<img src=\"assets/CBI_ner_tamid.png\">";
	echo "<h2>5774 High Holy Day Appeal</h2>";
	echo "</div>";
}
?>
