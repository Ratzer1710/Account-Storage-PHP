<?php

$to  = $email;

$title = 'Thank you for registering';

$message = '
<html>
<head>
    <title style="font-family: Arial, Helvetica, sans-serif;">Than you for registering!</title>
</head>
<body>
    <h1 style="font-family: Arial, Helvetica, sans-serif;">Your verification code is</h1>
    <h2 style="font-family: Arial, Helvetica, sans-serif; font-size: 25px;">'.$code.'</h2>
    <p><a href="https://accountstorageratzer.000webhostapp.com/verify.php?email='.$email.'" style="font-size: 20px; text-decoration: none;">Verify your account</a></p>
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