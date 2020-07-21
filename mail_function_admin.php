<?php
	function sendOTP($email,$otp) {
		// require('phpmailer/class.phpmailer.php');
		// require('phpmailer/class.smtp.php');
		// require_once('phpmail/PHPMailerAutoload.php');
		require 'PHPMailer-master/PHPMailerAutoload.php';


		$message_body = "One Time Password for Farm's Admin Password Reset:<br/><br/>" .$otp;
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
		$mail->SetFrom("gopieeki@gmail.com", "EEKI Super Admin");
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



function sendNotif($usermail,$username,$pass)
{
		// require('phpmailer/class.phpmailer.php');
		// require('phpmailer/class.smtp.php');
		// require_once('phpmail/PHPMailerAutoload.php');
		require 'PHPMailer-master/PHPMailerAutoload.php';


		$message_body = "Username:".$username."<br/>Password:".$pass;
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
		$mail->SetFrom("gopieeki@gmail.com", "EEKI Super Admin");
		// $mail->AddReplyTo("info@eekifoods.com", "EEKI Admin");
		$mail->AddAddress("$usermail");
		$mail->Subject = "Admin Authentication Credentials";
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


function sendUpdateNotif($usermail,$username,$pass)
	{
			// require('phpmailer/class.phpmailer.php');
			// require('phpmailer/class.smtp.php');
			// require_once('phpmail/PHPMailerAutoload.php');
			require 'PHPMailer-master/PHPMailerAutoload.php';


			$message_body = "Username:".$username."<br/>Password:".$pass;
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
			$mail->SetFrom("gopieeki@gmail.com", "EEKI Super Admin");
			// $mail->AddReplyTo("info@eekifoods.com", "EEKI Admin");
			$mail->AddAddress("$usermail");
			$mail->Subject = "Admin Authentication Updated Credentials";
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

function sendFarmNotif($usermail,$username,$pass)
		{
					// require('phpmailer/class.phpmailer.php');
					// require('phpmailer/class.smtp.php');
					// require_once('phpmail/PHPMailerAutoload.php');
					require 'PHPMailer-master/PHPMailerAutoload.php';


					$message_body = "Username:".$username."<br/>Password:".$pass;
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
					$mail->SetFrom("gopieeki@gmail.com", "EEKI Super Admin");
					// $mail->AddReplyTo("info@eekifoods.com", "EEKI Admin");
					$mail->AddAddress("$usermail");
					$mail->Subject = "Farm User Authentication Credentials";
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

function sendFarmUpdateNotif($usermail,$username,$pass)
		{
							// require('phpmailer/class.phpmailer.php');
							// require('phpmailer/class.smtp.php');
							// require_once('phpmail/PHPMailerAutoload.php');
							require 'PHPMailer-master/PHPMailerAutoload.php';


							$message_body = "Username:".$username."<br/>Password:".$pass;
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
							$mail->SetFrom("gopieeki@gmail.com", "EEKI Super Admin");
							// $mail->AddReplyTo("info@eekifoods.com", "EEKI Admin");
							$mail->AddAddress("$usermail");
							$mail->Subject = "Farm User Updated Authentication Credentials";
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
