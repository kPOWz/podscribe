<h1>Voicemail transcription demo</h1>

<h2 style="color: #ff0000"><?php echo htmlentities($_REQUEST['msg']); ?></h2>

<h3>Please enter your phone number and email address<br/><br/>
<form action="makecall.php" method="post">
	Phone: <input type="text" name="number" /><br/>
	Email: <input type="text" name="email" /><br/>
	<input type="submit" value="Call me">
</form>
</h3>

<i>You will called and asked to leave a voicemail message.  The voicemail will
be transcribed using Twilio's transcription API and emailed to you in a
few minutes.</i>
