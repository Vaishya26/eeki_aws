<?php
	function sendOTP($email,$otp) {
		// require('phpmailer/class.phpmailer.php');
		// require('phpmailer/class.smtp.php');
		// require_once('phpmail/PHPMailerAutoload.php');
		require 'PHPMailer-master/PHPMailerAutoload.php';


		$message_body = "One Time Password for Farm User's Password Reset:<br/><br/>" .$otp;
		$mail = new PHPMailer();
		// $mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = TRUE;
		$mail->SMTPSecure = 'ssl'; // tls or ssl
		$mail->Port     = "465";
		$mail->Username = "gopieeki@gmail.com";
		$mail->Password = "eeki@2020";
		$mail->Host     = "smtp.gmail.com";
		$mail->Mailer   = "smtp";
		$mail->SetFrom("gopieeki@gmail.com", "EEKI Admin");
		// $mail->AddReplyTo("info@eekifoods.com", "EEKI Admin");
		$mail->AddAddress("$email");
		$mail->Subject = "OTP For Password Reset";
		$mail->MsgHTML($message_body);
		$mail->IsHTML(true);
		$result = $mail->Send();

		if($result){
		return $result;
		}
		else {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}

	}
?>
