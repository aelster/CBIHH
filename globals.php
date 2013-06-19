<?php

global $gAccessLevel;
global $gAction;
global $gActive;
global $gDb;
global $gDebug;
global $gEnabled;
global $gFrom;
global $gFunction;
global $gMailLive;
global $gNumRows;
global $gSourceCode;
global $gSpiritIDtoDesc;
global $gTrace;
global $gUserId;

global $PasswdChanged;
global $result;

$gFunction = array('index.php');
#=====================================================
global $PaymentCredit;
global $PaymentCheck;
global $PaymentCall;

$PaymentCredit = 1;
$PaymentCheck = 2;
$PaymentCall = 3;

#=====================================================
global $PledgeTypeFinancial;
global $PledgeTypeSpiritual;
global $PledgeTypeFinGoal;

$PledgeTypeFinancial = 1;
$PledgeTypeSpiritual = 2;
$PledgeTypeFinGoal = 3;

#=====================================================
global $SpiritualTorah;
global $SpiritualAvodah;
global $SpiritualGemilut;

$SpiritualTorah = 1;
$SpiritualAvodah = 2;
$SpiritualGemilut = 3;

?>
