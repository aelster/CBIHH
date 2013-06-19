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


function DisplayMain() {
	include( 'globals.php' );
	if( $gTrace ) {
		$gFunction[] = "DisplayMain()";
		Logger();
	}
	
	$func = $_POST['func'];
	
	if( empty( $func ) ) {
		if( UserManager( 'authorized', 'control' ) ) {
			echo "<input type=button onclick=\"setValue('func','users');addAction('Main');\" value=Users>";
			echo "<input type=button onclick=\"setValue('func','privileges');addAction('Main');\" value=Privileges>";
			echo "<input type=button onclick=\"setValue('func','goal');addAction('Main');\" value=Goal>";
			echo "<br>";
		}
		echo "<input type=button onclick=\"setValue('func','financial');addAction('Main');\" value=Financial>";
		echo "<input type=button onclick=\"setValue('func','spiritual');addAction('Main');\" value=Spiritual>";
		echo "<input type=button onclick=\"addAction('Logout');\" value=Logout>";

	} elseif( $func == 'users' ) {
		UserManager( 'control' );
		
	} elseif( $func == 'privileges' ) {
		UserManager( 'privileges' );
	
	} elseif( $func == 'goal' ) {
		echo "<div class=CommonV2>";
		echo "<input type=button value=Back onclick=\"setValue('from', '$func');addAction('Back');\">";
		echo "<input type=button value=Update onclick=\"setValue('from','$func');addAction('Update');\">";
		echo "<p>Financial goal:&nbsp;&nbsp;";
		DoQuery( "select amount from pledges where pledgeType = $PledgeTypeFinGoal" );
		list( $goal ) = mysql_fetch_array( $result );
		$tag = MakeTag( 'goal' );
		printf( "<input type=text $tag size=20 value=\"\$ %s\">", number_format( $goal, 0 ) );
		echo "</p>";
		echo "</div>";
		
	} elseif( $func == 'financial' ) {
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
		echo "<table class=sortable>";
		echo "<tr>";
		echo "  <th>#</th>";
		echo "  <th>Amount</th>";
		echo "  <th>Donor</th>";
		echo "  <th>Method</th>";
		echo "  <th>Date/Time</th>";
		echo "</tr>";
		
		$methods = array( $PaymentCredit => 'Credit', $PaymentCheck => 'Check', $PaymentCall => 'Call' );
		
		$i = 0;
		while( $rec = mysql_fetch_assoc( $result ) ) {
			$i++;
			echo "<tr>";
			printf( "<td>%d</td>", $i );
			printf( "<td style=\"text-align:right;\">\$ %s</td>", number_format( $rec['amount'], 2 ) );
			printf( "<td>%s %s</td>", $rec['lastName'], $rec['firstName'] );
			printf( "<td class=c>%s</td>", $methods[ $rec['paymentMethod'] ] );
			$ts = strtotime( $rec['timestamp'] );
			printf( "<td>%s</td>", date( 'j-M-Y h:i A', $ts ) );
			echo "</tr>";
		}
		echo "</table>";
		echo "</div>";

	} elseif( $func == 'spiritual' ) {
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
}

function WriteHeader() {
	include( 'globals.php' );
	
	echo "<html>";
	echo "<head>";
	
	$styles = array();
	$styles[] = "/css/CommonV2.css";
	$styles[] = "styles.css";
	
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
	echo "<div class=adminBody>";
	echo "<img src=\"assets/CBI_ner_tamid.png\">";
	echo "<h2>5774 High Holy Day Appeal</h2>";
}
?>
