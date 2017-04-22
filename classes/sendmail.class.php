<?php

//require_once(DOC_ROOT."/phpmailer/class.phpmailer.php");
class SendMail extends Main
{
		
	public function Prepare($subject, $body, $to = "mwleinad@yahoo.com", $toName = "Director", $from = "ventas@comprobantedigital.mx", $fromName = "Administrador del Sistema") 
	{
		$mail = new PHPMailer();
//		$mail->Host = 'localhost';
		$mail->IsSMTP(); 
		
		$mail->SMTPAuth = true; 
    //$mail->SMTPSecure = "false";
		//print_r($mail);
		$mail->Host = SMTP_HOST;
		$mail->Username = SMTP_USER;
		$mail->Password = SMTP_PASS;
		$mail->Port = SMTP_PORT;
		//$mail->SMTPSecure = "ssl";
		$mail->From = $from;
		//print_r($mail);

		$mail->FromName = $fromName;
		$mail->Subject = $subject;

		$mail->AddAddress($to, $toName);
		$mail->Body = $body;
		$mail->Send();
	}

}


?>