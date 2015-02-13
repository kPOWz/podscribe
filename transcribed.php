<?php
    if (!isset($_REQUEST['email'])) {
        echo "Must specify email address";
        die;
    }
    
    if (!isset($_REQUEST['RecordingUrl'])) {
        echo "Must specify recording url";
        die;
    }
    
    if (!isset($_REQUEST['TranscriptionStatus'])) {
        echo "Must specify transcription status";
        die;
    }
    
    $sendgrid = new SendGrid('app33973105@heroku.com', 'lklrfwuu');
    $message = new SendGrid\Email();

    if (strtolower($_REQUEST['TranscriptionStatus']) != "completed") {
        $subject = "Error transcribing voicemail from ${_REQUEST['Caller']}";
        $body = "New have a new voicemail from ${_REQUEST['Caller']}\n\n";
        $body .= "Click this link to listen to the message:\n";
        $body .= $_REQUEST['RecordingUrl'];
    } else {
        $subject = "New voicemail from ${_REQUEST['Caller']}";
        $body = "New have a new voicemail from ${_REQUEST['Caller']}\n\n";
        $body .= "Text of the Twilio transcribed voicemail:\n";
        $body .= $_REQUEST['TranscriptionText']."\n\n";
        $body .= "Click this link to listen to the message:\n";
        $body .= $_REQUEST['RecordingUrl'];
    }

    $message->addTo($_REQUEST['email'])->
              setFrom('me@bar.com')->
              setSubject($subject)->
              setText($body)->
              setHtml('<strong>Podscribe!</strong>');
    $response = $sendgrid->send($message);
    
    // $headers = 'From: help@twilio.com' . "\r\n" .
    //     'Reply-To: help@twilio.com' . "\r\n" .
    //     'X-Mailer: Twilio';
    // mail($_REQUEST['email'], $subject, $body, $headers);
?>