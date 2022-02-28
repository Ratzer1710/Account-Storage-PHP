<?php 
    $servername = "localhost";
    $db_username = 'root';
    $db_password = '';
    $database = 'php_login_database';
        
    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $database);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
?>
