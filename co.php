<?php
	
	try {
		$name = $_POST['name'];
		$email_address=$_POST['email'];
		$subject = $_POST['subject'];
		$message = $_POST['message'];



		require 'PHPMailerAutoload.php';
		
		$mail = new PHPMailer;

		

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication


		$mail->Username = 'flysafe.terbangterus@gmail.com';                 // SMTP username
		$mail->Password = 'terbangterus2016';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587 ;                                    // TCP port to connect to

		$mail->setFrom('hilman@gmail.com', 'My Security Files Supports');
		$mail->addAddress('andreydoang@gmail.com', 'My Security Files');     // Add a recipient
		$mail->addAddress('hilman@gmail.com', 'My Security Files');     // Add a recipient
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Request Code - My Security Files';
		$mail->Body    = '<h1>Welcome</h1> <br>
		
		Someone send your contact :D

		Name : '.$name.' <br>
		Email : '.$email_address.' <br>
		Subject : '.$subject.' <br>
		Message : '.$message.' <br>

		';



		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent';		    

		}
	} catch (Exception $e) {
		
	}

	
?>
