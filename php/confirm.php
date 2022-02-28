<?php

    require('database.php'); 

    $message = '';
    $confirmed = '';

    $email = $_POST['email'];
    $code = $_POST['code'];
    $sql = "SELECT * FROM users WHERE email='$email' and code='$code'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $sql_replace = "UPDATE users SET verified='yes' WHERE email='$email'";
        $stmt = $conn->prepare($sql_replace);
        $stmt->execute();
        $confirmed = 'yes';
    } else {
        $confirmed = 'no';
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script> $msg = ''; </script>
    <?php require('../head.php') ?>
    <title>Verify</title>
</head>
<body>
    <section class="confirm">
        <?php if ($confirmed == 'yes') : ?>
            <script>
                Swal.fire({title: "Account created succesfully", confirmButtonText: "Login", }).then(() => {window.location.href = "../login.php";});
            </script>
        <?php endif; ?>
        <?php if ($confirmed == 'no') : ?>
            <script>
                var php_email = "<?php echo $email; ?>";
                Swal.fire({title: "Verification failed", confirmButtonText: "Try Again", }).then(() => {window.location.replace("https://accountstorageratzer.000webhostapp.com/verify.php?email=" + php_email);});
            </script>
            <?php $confirmed = ''; ?>
        <?php endif; ?>
    </section>
</body>
</html>
