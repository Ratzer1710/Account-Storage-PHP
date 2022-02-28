<?php

    session_start();
    
    $message = '';
    
    require ('php/database.php');
    
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $mail = $_POST['email'];
        $sql_email = "SELECT * FROM users WHERE email='$mail'";
  	    $res_email = mysqli_query($conn, $sql_email);
  	    if(mysqli_num_rows($res_email) > 0){
            $sql = "SELECT id, username, email, password, verified FROM users WHERE email = '$mail'";
            if ($records = $conn->prepare($sql)) {
                $records->execute();
                $records->bind_result($id, $username, $email, $password, $verified);
                while ($records->fetch()) {
                    if (password_verify($_POST['password'], $password)) {
                        if ($verified == 'yes') {
                            $_SESSION['user_id'] = $id;
                            header('Location: index.php');
                        } else {
                            $message = 'Verify your account to continue';
                        }
                    } else {
                        $message = 'Incorrect Password';
                    }
                }
            } 
        } else {
            $message = "Your email doesn't match an account in our system";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php') ?>
    <title>Login</title>
</head>
<body>
    <section class="login">
        <section class="header">
            <h1>Login</h1>
            <p>or <a href="register.php">register</a> </p>
        </section>
        <form method="POST" action="login.php" class="login_form">
            <input required type="email" placeholder="Email" name="email" class="login_email">
            <input required type="password" placeholder="Password" name="password" class="login_password">
            <?php if (!empty($message) && empty($registration)) : ?>
                <section class="message">
                    <p><span class="icon icon-notification"></span> <?= $message ?></p>
                </section>
            <?php endif; ?>
            <input type="submit" class="btn" name="submit" value="Login">
        </form>
        <p><a href="password_reset.php">Forgot your password?</a></p>
    </section>
</body>
</html>