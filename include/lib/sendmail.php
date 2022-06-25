<?php

class SendMail {

	public $smtp_host;
	public $smtp_port;
	public $smtp_username;
	public $smtp_password;

	public function __construct() {
		$this->smtp_host = Option::get('smtp_server');
		$this->smtp_port = Option::get('smtp_port');
		$this->smtp_username = Option::get('smtp_mail');
		$this->smtp_password = Option::get('smtp_pw');
	}

	function send($to, $title, $content) {
		$mail = new PHPMailer(true);
		$mail->IsSMTP();                          // Use smtp authentication to send email
		$mail->CharSet = 'UTF-8';                 // Set email charset, this is very important, otherwise the Chinese is garbled
		$mail->SMTPAuth = true;                   // Enable authentication
		$mail->SMTPSecure = 'ssl';                // Set up login authentication using ssl encryption
		$mail->Port = $this->smtp_port;           // Port. Set the remote server port number for ssl connection to the smtp server, the previous default was 25, but now the new one seems to be unavailable. Optional 465 or 587
		$mail->Host = $this->smtp_host;           // SMTP server address: smtp.qq.com,  smtp.sina.com.cn,  smtp.163.com,  smtp.qiye.163.co ...
		$mail->Username = $this->smtp_username;   // Email address
		$mail->Password = $this->smtp_password;   // TMP authorization code mentioned above needs to be saved and used
		$mail->From = $this->smtp_username;
		if (is_array($to)) { //Multiple recepients
			foreach ($to as $value) {
				$mail->AddAddress($value);
			}
		} else {                        //Single recepient
			$mail->AddAddress($to); //cc
		}

		$mail->Subject = $title;

		//Add the email body. If isHTML is set to true, it can be a complete html string, i.e. you can use the file_get_contents function to read the local html file
		$mail->Body = $content;

		//Add an attachment to the email. This method also has two parameters. The first parameter is the directory where the attachment is stored (relative directory or absolute directory can be used). The second parameter is the name of the attachment in the email attachment
		//$mail->addAttachment('./1.png,'Image');
		//The same method can be called multiple times to upload multiple attachments
		//$mail->addAttachment('./test.php','php file');

		$mail->WordWrap = 80; // Set the length of each line
		$mail->IsHTML(true);

		try {
			return $mail->Send();
		} catch (Exception $exc) {
			return false;
		}
	}

}
