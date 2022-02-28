<?php

    require ('php/database.php');
    
    $message = "";
    
    if (!empty($_POST)) {
        $email = $_POST['email'];
        $sql = "SELECT * FROM users WHERE email='$email'";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            include('php/reset_mail.php');
        } else {
            $message = "This email doesn't match an account on our system";        
        }
    }
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php') ?>
    <title>Password Reset</title>
</head>
<body>
    <section class="register">
        <h1>Reset your Password</h1>
        <form action="password_reset.php" method="POST" class="register_form">
            <input placeholder="Email" type="email" required name="email" class="register_email">
            <?php if (!empty($message) && empty($registration)) : ?>
                <section class="message">
                    <p><span class="icon icon-notification"></span> <?= $message ?></p>
                </section>
            <?php endif; ?>
            <input type="submit" class="btn" name="submit" value="Submit">
        </form>
        <?php if ($sent) : ?>
            <script>
                var php_email = "<?php echo $email; ?>";
                Swal.fire({title: "Check your email inbox to proceed", confirmButtonText: "OK", }).then(() => {window.location.href = "login.php"});
            </script>
        <?php endif; ?>
    </section>
</body>
</html>