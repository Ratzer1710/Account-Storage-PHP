<?php
    
    require('php/database.php');
    
    $email = $_GET['email'];
    $code = $_GET['code'];
    $url = "verify.php?email=$email&code=$code";
    
    if(empty($_POST)) {
        if(isset($_GET['email'])) {
            $email = $_GET['email'];
        } else {
            header ('Location: index.php');
        }
    }

    $confirmed = '';

    if (!empty($_POST)) {
        $code = $_POST['code'];
        $email = $_POST['email'];
        $sql = "SELECT * FROM users WHERE email='$email' and code='$code'";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            $sql_replace = "UPDATE users SET verified='yes' WHERE email='$email'";
            $stmt = $conn->prepare($sql_replace);
            $stmt->execute();
            $confirmed = 'yes';
        } else {
            $message = 'Wrong Code';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('head.php') ?>
    <title>Verify</title>
</head>
<body>
    <section class="verify">
        <h1>Verify your account</h1>
        <form action="<?php echo $url; ?>" method="POST" class="verify_form">
            <input placeholder="Verification code" pattern="\d*" maxlength="4" type="text" name="code" class="verification_code">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <?php if (!empty($message) && empty($registration)) : ?>
                <section class="message">
                    <p><span class="icon icon-notification"></span> <?= $message ?></p>
                </section>
            <?php endif; ?>
            <input type="submit" class="btn" name="submit" value="Submit">
        </form>
        <?php if(empty($confirmed)) : ?>
            <?php 
                $code = $_GET['code'];
                $email = $_GET['email'];
            ?>
            <script>
                function urlRedirect() {
                    var php_email = "<?php echo $email; ?>";
                    var php_code = "<?php echo $code; ?>";
                    window.location.href("php/resend.php?email="+php_email+"&code="+php_code);
                }
            </script>
            <a href='#' onclick='urlRedirect();return false;'>Resend Email</a>
        <?php endif; ?>
        <?php if ($confirmed == 'yes') : ?>
            <script>
                Swal.fire({title: "Account created succesfully", confirmButtonText: "Login", }).then(() => {window.location.href = "../login.php";});
            </script>
        <?php endif; ?>
    </section>
</body>
</html>