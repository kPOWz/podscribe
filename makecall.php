<?php
require 'vendor/autoload.php';


/* Set our AccountSid and AuthToken */
$sid = "ACea653355632bce6e60cf2bae49928625";
$token = "c8f8a08fa23a9751651c30cd198c759d";

/* Outgoing Caller ID you have previously validated with Twilio */
$CallerID = '+13193275186';

/* Instantiate a new Twilio Rest Client */
$client = new Services_Twilio($sid, $token);

/* Validate request */
if (!isset($_REQUEST['number'])) {
    $err = urlencode("Must specify phone number");
    header("Location: .?msg=$err");
    die;
}

if (!isset($_REQUEST['email'])) {
    $err = urlencode("Must specify email address");
    header("Location: .?msg=$err");
    die;
}

if (!preg_match('/^[a-z0-9_.-]+@([a-z0-9_-]+\.)+[a-z0-9_-]{2,4}$/i', $_REQUEST['email'])) {
    $err = urlencode("Invalid email address");
    header("Location: .?msg=$err");
    die;
}

// $url = "http://demo.twilio.com/voicemailtranscribe/makerecording.php?email="
// 	. urlencode($_REQUEST['email']);
// $url = "http://3bdf320a.ngrok.com/~karrie/vmt/makerecording.php?email="
//     . urlencode($_REQUEST['email']);
$url = "http://podscribe.herokuapp.com/makerecording.php?email="
    . urlencode($_REQUEST['email']);

/* make Twilio REST request to initiate outgoing call */
try {

	$call = $client->account->calls
		->create($CallerID, $_REQUEST['number'], $url);

	/* redirect back to the main page with CallSid */
	$msg = urlencode("Calling... ".$_REQUEST['number']);
	header("Location: .?msg=$msg&CallSid=" . $call->sid);

} catch(Exception $e) {

    $err = urlencode($e->getMessage());
    header("Location: .?msg=$err");
	die;

}

?>