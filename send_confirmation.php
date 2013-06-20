<?php

$standalone = 0;
if( $standalone ) {
	require_once 'lib/swift_required.php';
	
	include( 'globals.php' );
	include( 'library.php' );
	include( 'local_cbi.php' );
	
	require_once( 'SiteLoader.php' );
	SiteLoad( 'CommonV2' );
	
	$gDb = OpenDb();                # Open the MySQL database
	
	LocalInit();
	
	$post = array();
	$post['action'] = 'paynow';
	$post['amount'] = '';
	$post['fields'] = 'lastName=Elster|firstName=Andrew|phone=9495096711|email=andy.elster@gmail.com|amount=270.00';
	$post['from'] = 'financial';
	$post['paynow'] = '1';
	
	$post = array();
	$post['action'] = 'paynow';
	$post['amount'] = '';
	$post['fields'] = 'lastName=Elster|firstName=Andrew|phone=9495096711|email=andy.elster@gmail.com|pledgeIds=id_1,id_14';
	$post['from'] = 'spiritual';
	$post['paynow'] = 'andy@elsternet.com';
	
	$post = array();
	$post['action'] = 'paynow';
	$post['amount'] = '';
	$post['fields'] = 'lastName=Elster|firstName=Andrew|phone=9495096711|email=andy.elster@gmail.com|pledgeIds=id_1|pledgeOther=Shop till I drop';
	$post['from'] = 'spiritual';
	$post['paynow'] = 'andy@elsternet.com';

} else {
	$post = $_POST;
}

if( $standalone ) {
	$keys = array_keys( $post );
	sort( $keys );
	foreach( $keys as $key ) {
		printf( "\$post['%s'] = '%s';<br>", $key, $post[$key] );
	}
}

$tmp = preg_split( '/\|/', $post['fields'] );
foreach( $tmp as $xx ) {
	list( $key, $val ) = preg_split( '/=/', $xx );
	$$key = $val;
}

if( 1 ) {
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
		$html[] = "&nbsp;&nbsp;Thank you for your pledge of the following mitzvot:<br>";
		$html[] = "<ul>";
		$tmp = preg_split( '/,/', $pledgeIds );
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
		$text[] = "  Thank you for your pledge of the following mitzvot:\n";
		$text[] = "\n";
		$tmp = preg_split( '/,/', $pledgeIds );
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
	
	
	$message
	->setFrom(array('support@elsternet.com' => 'Andy Elster'))
	->setTo(array( $email => "$firstName $lastName" ) )
	->setBcc(array( 'beth@elsternet.com' => 'Beth Elster' ) )
	->setBody( join('',$html), 'text/html' )
	->addPart( join('',$text), 'text/plain' )
	;

	MyMail($message);
}

?>