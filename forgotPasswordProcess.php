<?php

    require "connection.php";

    require "SMTP.php";
    require "PHPMailer.php";
    require "Exception.php";

    use PHPMailer\PHPMailer\PHPMailer;

if(isset($_GET["e"])){

    $email = $_GET["e"];

    $rs = Database::search("SELECT * FROM `users` WHERE `email`='".$email."'");
    $n = $rs->num_rows;

    if($n == 1){

        $code = uniqid();

        Database::iud("UPDATE `users` SET `verification_code`='".$code."' WHERE
        `email`='".$email."'");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hasindut1@gmail.com';
        $mail->Password = 'vlinhrrceyyfwodc';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('hasindut1@gmail.com', 'Reset Password');
        $mail->addReplyTo('hasindut1@gmail.com', 'Reset Password');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'eShop Forgot Password Verification Code';
        $bodyContent = '<h1 style="color:green">Your Verification code is '.$code.'</h1>';
        $mail->Body    = $bodyContent;

        if(!$mail->send()){
            echo 'Verification code sending failed';
        }else{
            echo 'Success';
        }
       
    }else{

    echo ("Invalid Email address");
    }

}

?>