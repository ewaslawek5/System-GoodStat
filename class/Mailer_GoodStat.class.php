<?php

class Mailer_GoodStat {

	var $mail_do; 
	var $mail_od; 
	var $temat; 
	var $tresc_email;

	function __construct($mail_do, $mail_od, $temat, $tresc_email){
	
		$this->mail_do			= $mail_do;
		$this->mail_od			= $mail_od;
		$this->temat			= $temat;
		$this->tresc_email		= $tresc_email;
/**/		
		$this->wyslij($mail_do, $mail_od, $temat, $tresc_email);
	}

	function wyslij($mail_do, $mail_od, $temat, $tresc_email)
	{

$tresc = '
<html>
<head>

    <!-- Bootstrap CSS -->
    <link href="http://goodstat.com.pl/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://goodstat.com.pl/css/moje.css" rel="stylesheet">
		
  <title>'.$temat.'</title>
</head>
<body>'.$tresc_email.'
</body>
</html>
';

//-----------------
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

$headers .= 'From: GoodStat.com.pl <'.$mail_od.'>' . "\r\n";

/*
$headers .= 'Bcc: kontakt@goodstat.com.pl' . "\r\n";					//kopia wiadomosci ukryta
$headers .= 'To: Sławomir Podrzycki <kontakt@goodstat.com.pl>' . "\r\n";
$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";	//nadawca wiadomosci
$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";					//kopia wiadomosci jawna
$headers .= 'Bcc: kontakt@goodstat.com.pl' . "\r\n";					//kopia wiadomosci ukryta
*/

	// wyslanie maila
	mail($mail_do, $temat, $tresc, $headers);
    }
    
}
