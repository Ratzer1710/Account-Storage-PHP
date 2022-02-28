<?php

$to  = $email;

$title = 'Reset your Password';

$message = '
<html>
<head>
    <title style="font-family: Arial, Helvetica, sans-serif;">Reset your password</title>
</head>
<body>
    <h1 style="font-family: Arial, Helvetica, sans-serif; font-size: 35px;">Input your new password</h1>
    <form method="POST" action="https://accountstorageratzer.000webhostapp.com/php/pssw_reset.php?email='.$email.'">
        <input required class="pssw" type="password" placeholder="Password" name="password" class="mail_input" style="border-radius: 30px; font-size: 25px; padding: 0.8%; padding-left: 1.2%; padding-right: 1.2%;">
        <input type="hidden" name="email" value="'.$email.'"><br><br>
        <input type="submit" name="submit" class="mail_submit" value="RESET" style="background: #66A80F; color: #fff; font-size: 25px; border-radius: 30px; border: none; padding: 0.8%; padding-left: 1.2%; padding-right: 1.2%; cusor: none;">
    </form>
</body>
</html>
';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Account Storage <sebastian.ratzer1710@gmail.com>' . "\r\n";
$headers .= "Return-Path: Account Storage <sebastian.ratzer1710@gmail.com>\r\n"; 
$headers .= "X-Priority: 3\r\n";

$sent = false;

if (mail($to, $title, $message, $headers)) {
    $sent = true;
}

?>