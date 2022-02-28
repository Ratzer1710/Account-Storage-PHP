<?php
    
    if(isset($_GET['username'])) {
        $username = $_GET['username'];
    }
    
    session_start();

    session_unset();

    session_destroy();
    
    require ('database.php');
    
    $sql = "DELETE FROM users WHERE username='$username'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    header('Location: ../index.php');
    
?>