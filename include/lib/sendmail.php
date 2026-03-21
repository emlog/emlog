<?php

class SendMail {

    public $smtp_host;
    public $smtp_port;
    public $smtp_username;
    public $smtp_password;
    public $smtp_from_mail;
    public $smtp_from_name;

    public function __construct() {
        $this->smtp_host = Option::get('smtp_server');
        $this->smtp_port = Option::get('smtp_port');
        $this->smtp_from_mail = Option::get('smtp_mail');
        $smtpUser = Option::get('smtp_user');
        $this->smtp_username = !empty($smtpUser) ? $smtpUser : $this->smtp_from_mail;
        $this->smtp_password = Option::get('smtp_pw');
        $this->smtp_from_name = Option::get('smtp_from_name');
    }

    function send($to, $title, $content) {
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->SMTPAuth = true;
        $port = (int)$this->smtp_port;
        if (in_array($port, [587, 2587], true)) {
            $mail->SMTPSecure = 'tls';
            if (property_exists($mail, 'SMTPAutoTLS')) {
                $mail->SMTPAutoTLS = true;
            }
        } elseif (in_array($port, [465, 2465], true)) {
            $mail->SMTPSecure = 'ssl';
            if (property_exists($mail, 'SMTPAutoTLS')) {
                $mail->SMTPAutoTLS = false;
            }
        } else {
            $mail->SMTPSecure = '';
            if (property_exists($mail, 'SMTPAutoTLS')) {
                $mail->SMTPAutoTLS = true;
            }
        }
        $mail->Port = $this->smtp_port;
        $mail->Host = $this->smtp_host;
        $mail->Username = $this->smtp_username;
        $mail->Password = $this->smtp_password;
        $mail->From = $this->smtp_from_mail;
        $mail->FromName = $this->smtp_from_name;
        $mail->IsHTML();
        if (is_array($to)) {
            foreach ($to as $value) {
                $mail->AddAddress($value);
            }
        } else {
            $mail->AddAddress($to);
        }

        $mail->Subject = $title;
        $mail->Body = $content;
        $mail->WordWrap = 80; // Set the length of each string line

        try {
            return $mail->Send();
        } catch (Exception $exc) {
            return false;
        }
    }

}
