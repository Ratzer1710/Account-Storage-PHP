<?php 

    require('php/database.php'); 
    
    $message = '';
    $registration = '';
    $same_username = '';
    $same_email = '';
    
    if (!empty($_POST)) {
        if ($_POST['password'] == $_POST['cpassword']) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $sql_username = "SELECT * FROM users WHERE username='$username'";
  	        $sql_email = "SELECT * FROM users WHERE email='$email'";
  	        $res_username = mysqli_query($conn, $sql_username);
  	        $res_email = mysqli_query($conn, $sql_email);
  	        if (mysqli_num_rows($res_username) > 0) {
  	            $same_username = TRUE;
  	        }else if(mysqli_num_rows($res_email) > 0){
  	            $same_email = TRUE; 	
  	        }
            if ($same_username != TRUE && $same_email != TRUE) {
                $code = substr(str_shuffle("0123456789"), 0, 4);
                include ('php/mail.php');
                if ($sent) {
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    $verified = 'no';
                    $sql = "INSERT INTO users (username, email, password, verified, code) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $username, $email, $password, $verified, $code);
                    if ($stmt->execute() === TRUE) {
                        $registration = 'Succes';
                    } else {
                        $message = 'Registration Failed';
                    }
                } else {
                    $message = 'Unable to send email';
                }
            } else if ($same_username == TRUE) {
                $message = "There is already an account with that username on our system";
            } else if ($same_email == TRUE) {
                $message = "There is already an account with that email on our system";
            }
        } else {
            $message = 'Passwords do not match';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php') ?>
    <title>Register</title>
</head>
<body>
    <section class="register">
        <?php if ($registration == 'Succes') : ?>
            <script>
                var php_email = "<?php echo $email; ?>";
                var php_code = "<?php echo $code; ?>";
                Swal.fire({title: "Check your email inbox to proceed", confirmButtonText: "OK", }).then(() => {window.location.href = "https://accountstorageratzer.000webhostapp.com/verify.php?email=" + php_email + "&code=" + php_code;});
            </script>
        <?php endif; ?>
        <section class="header">
            <h1>Register</h1>
            <p>or <a href="login.php">login</a> </p>
        </section>
        <form method="POST" action="register.php" class="register_form">
            <input required type="text" placeholder="Username" name="username" class="register_username">
            <input required type="email" placeholder="Email" name="email" class="register_email">
            <input required type="password" placeholder="Password" name="password" class="register_password">
            <input required type="password" placeholder="Confirm Password" name="cpassword" class="cregister_password">
            <?php if (!empty($message) && empty($registration)) : ?>
                <section class="message">
                    <p><span class="icon icon-notification"></span> <?= $message ?></p>
                </section>
            <?php endif; ?>
            <input type="submit" class="btn" name="submit" value="Register">
        </form>
    </section>
</body>
</html>