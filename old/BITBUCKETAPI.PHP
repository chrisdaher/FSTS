<?php

function displayLatest(){
	$username = "bitbucketapiryannasr";
	$password="bitbucketapi9";
	$url = "https://api.bitbucket.org/1.0/repositories/ryannasr/soen390_team5/changesets";
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 4);
	$json = curl_exec($ch);
	if(!$json) {
		echo curl_error($ch);
		
	}
	curl_close($ch);
	$res = json_decode($json, true);
	$arrKeys = array_keys($res);
	$arrVal = array_values($res);

	$changeSets = $res['changesets'];
	$arrKeys = array_keys($changeSets);
	$lastIndex = count($arrKeys) -1;
	$aChange = $changeSets[$lastIndex];
	$arrKeys = array_keys($aChange);


	$files = $aChange['files'];
	$theMessage = $aChange['message'];
	$theAuthor = $aChange['raw_author'];
	$theDate = $aChange['timestamp'];

	print_r("<h2><u><b>This is what changed:<br /></b></u></h2>");

	print_r("<u><b>AUTHOR:</u></b>   $theAuthor");
	print_r("<br/>");
	print_r("<u><b>DATE:</u></b>     $theDate");
	print_r("<br/>");
	print_r("<u><b>MESSAGE:</u></b>  $theMessage");
	print_r("<br/>");
	print_r("<u><b>FILES CHANGED:</u></b>");
	print_r("<br/>");
	foreach ($files as $file){
		print_r("  - " . $file['file']);
		print_r("<br/>");
	}
	
	include('showDiff.php');
	
	/*
	require_once('class.phpmailer-lite.php');
	date_default_timezone_set('America/Toronto');
	$mail             = new PHPMailerLite(); // defaults to using php "Sendmail" (or Qmail, depending on availability)

	$body                = "THIS IS A TEST LOL";
	$mail->SetFrom('list@mydomain.com', 'List manager');

	$mail->Subject       = "PHPMailer Test Subject via Sendmail";
	  $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	  $mail->MsgHTML($body);
	  $mail->AddAddress("ryannasr@gmail.com", "Ryan");
	  if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	  echo "Message sent!";
	}
	*/
}
?>

