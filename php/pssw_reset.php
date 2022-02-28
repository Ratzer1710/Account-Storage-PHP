<?php

    require('database.php'); 

    $confirmed = '';
    
    if(!empty($_POST)) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_BCRYPT);
        $sql_replace = "UPDATE users SET password='$password' WHERE email='$email'";
        $stmt = $conn->prepare($sql_replace);
        $stmt->execute();
        header('Location: ../index.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('../head.php') ?>
    <title>Password Reset</title>
</head>
<body>
    <section class="verify">
        <?php if ($confirmed == 'yes') : ?>
            <script>
                Swal.fire({title: "Password reset succesfully", confirmButtonText: "Login", }).then(() => {window.location.href = "../login.php";});
            </script>
        <?php endif; ?>
        <?php if ($confirmed == 'no') : ?>
            <script>
                var php_email = "<?php echo $email; ?>";
                Swal.fire({title: "Password reset failed", confirmButtonText: "Try Again", }).then(() => {window.location.href("../password_reset.php");});
            </script>
            <?php $confirmed = ''; ?>
        <?php endif; ?>
    </section>
</body>
</html>
