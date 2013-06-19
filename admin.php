<?php
require_once 'lib/swift_required.php';

include( 'globals.php' );
include( 'library.php' );
include( 'local_cbi.php' );

require_once( 'SiteLoader.php' );
SiteLoad( 'CommonV2' );

$gDb = OpenDb();                # Open the MySQL database

//-----------------------------------------------------------------------------
// Main Program
//
// Initial actions:
//		Start 		==>	Before authentication
//		Login			==> Verify the user password
//		Welcome		==> After successful authentication
//-----------------------------------------------------------------------------
//

$gAction = ( isset( $_POST[ "action" ] ) ) ? $_POST[ "action" ] : "";
$gFrom = ( isset( $_POST[ 'from' ] ) ? $_POST[ 'from' ] : "" );
$func = ( isset( $_POST['func'] ) ? $_POST['func'] : "" );

switch( $gAction )
{
	case( 'Back' ):
	case( 'Logout' ):
		continue;
		
	case( 'New' ):
		if( $gFrom == "UserReleaseNotes" ) { $gAction = "Update"; }
		break;
	
	default:
		if( $gFrom == "UserFeatures" ) { $gAction = "Update"; }
		if( $gFrom == "UserManager" ) { $gAction = "Update"; }
		if( $gFrom == "UserReleaseNotes" ) { $gAction = "Update"; }
		if( empty( $gAction ) ) { $gAction = "Start"; }
		break;
}

SessionStuff('start');

WriteHeader();
AddForm();

LocalInit();

if( $gDebug ) { DumpPostVars( "After SessionStuff(start): gAction=[$gAction]" ); }

switch( $gAction ) {
   case 'Back':
      $gAction = 'Welcome';
      $func = "";
      break;
   
   case( 'Continue' ):
      $gAction = "Start";
      break;

   case( 'Login' ):
      UserManager('verify');
      break;

   case( 'Update' ):
      if( $gFrom == "UserManagerPassword" ) {
         UserManager('update');
         $gAction = 'Start';
         
      } elseif( $gFrom == "UserManagerPrivileges" ) {
         UserManager('update');
         $gAction = 'Main';
         $func = 'privileges';
   
      } elseif( $gFrom == 'Users' ) {
         UserManager('update');
         $gAction = "Main";
         $func = 'users';

	  } elseif( $gFrom == 'goal' ) {
		  $goal = preg_replace( '/[^0-9]/', '', $_POST['goal'] );
		  DoQuery( "select * from pledges where pledgeType = $PledgeTypeFinGoal" );
		  if( $gNumRows ) {
			  DoQuery( "update pledges set amount = $goal where pledgeType = $PledgeTypeFinGoal" );
		  } else {
			  DoQuery( "insert into pledges set pledgeType = $PledgeTypeFinGoal, amount = $goal" );
		  }
		  $gAction = "Main";
		  $func = 'goal';
		  
      } else {
         UserManager( 'update' );
         $gAction = 'Welcome';
      }
      break;
}

$_POST['action'] = $gAction;
$_POST['func'] = $func;

if( $gDebug ) { DumpPostVars( "After Login/Logout:  gAction=[$gAction]" ); }

$vect = $args = array();

$vect['Inactive'] = 'UserManager';
$vect['Login']	= 'UserManager';
$vect['Logout'] = 'UserManager';
$vect['Main'] = 'DisplayMain';
$vect['Resend'] = 'UserManager';
$vect['Start'] = 'UserManager';
$vect['Welcome'] = 'DisplayMain';

$args['Inactive'] = array('inactive');
$args['Login'] = array( 'verify' );
$args['Logout'] = array( 'logout' );
$args['Resend'] = array( 'resend' );
$args['Start'] = array('login');

if( ! empty( $vect[ $gAction ] ) ) {
	$func = $vect[ $gAction ];
	$arg = array_key_exists( $gAction, $args ) ? $args[ $gAction ] : NULL;
	switch( count( $arg ) ) {
		case( 0 ):
			$func();
			break;
		
		case( 1 ):
			$func( $arg[0] );
			break;
		
		case( 2 ):
			$func( $arg[0], $arg[1] );
			break;
	}
} else {
	switch( $gAction )
	{
		case( 'Done' ):
			break;
		
		case( 'Reset Password' ):
			UserManager( 'reset' );
			SessionStuff( 'logout' );
			break;
		
		default:
			echo "action: $gAction<br>";
			echo "I'm sorry but something unexpected occurred.  Please send all details<br>";
			echo "of what you were doing and any error messages to $gSupport<br>";
            echo "<input type=submit name=action value=Back>"; 
        
	}
}

echo "</form>";
echo "</body>";
echo "</html>";

?>