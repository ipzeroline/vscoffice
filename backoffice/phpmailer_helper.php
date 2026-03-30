<?php
//include("phpmailer_5.2.4/class.phpmailer.php");
//include("phpmailer_5.2.4/class.smtp.php");

include("PHPMailer/class.phpmailer.php");

function send_email($sender = array(), $subject, $message, $file_attachment = array(), $type = 'normal', $from_email = 'pttac.website@gmail.com', $from_name = 'pttac')
{
    define('MANDRILL_USER', '');
    define('MANDRILL_PASS', '');

    $mail = new PHPMailer();  // create a new object
    $mail->CharSet = "utf-8";
    /* 	$mail->isSMTP(); */
    /* 	$mail->Debugoutput = 'html'; */
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = MANDRILL_USER;
    $mail->Password = MANDRILL_PASS;
    $mail->SetFrom(MANDRILL_USER, MANDRILL_USER);
    $mail->Subject = $subject;
    $mail->MsgHTML($message);
    if ($type == 'upload') {
        if (!empty($file_attachment)) {
            $mail->AddAttachment($file_attachment);
        }
    } else {
        if (!empty($file_attachment)) {
            foreach ($file_attachment as $arr) {
                if ($arr != '') {
                    $mail->AddAttachment($arr);
                }
            }
        }
    }
    if (!empty($sender)) {
        foreach ($sender as $v) {
            $mail->AddAddress($v);
        }
    }

    return $mail->Send();
    if (!$mail->send()) {
        echo 'Message could not be sent<br>';
        echo 'Mailer Error: ' . $mail->ErrorInfo . '<br>';

    } else {
        echo 'Message has been sent ' . date('Y-m-d H:i:s') . '<br>';
    }
    print_r($sender);

    $mail->ClearAddresses();
}
