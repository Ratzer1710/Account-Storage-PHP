<?php 
    session_start();

    require ('php/database.php');

    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $sql = "SELECT id, username, email, password, verified FROM users WHERE id = '$id'";
        if ($records = $conn->prepare($sql)) {
            $records->execute();
            $records->bind_result($id, $username, $email, $password, $verified);
            while ($records->fetch()) {
                $user = array (
                    'id' => $id,
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'verified' => $verified,
                );
            }
        }
    }

    if (empty($user)) {
        header('Location: login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/scss/style.css">
    <link rel="stylesheet" href="assets/fonts/ico_style.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <title>Account Storage</title>
</head>
<body>
    <header>
        <?php if ($user['verified'] == "no") : ?>
            <script>
                Swal.fire({title: "Check your email inbox to proceed", confirmButtonText: "OK", }).then(() => {window.location.href = "login.php";})
            </script>
        <?php endif; 
        ?>
        <div class="logo">
            <span class="icon icon-key"><h1>Account Storage</h1></span>
        </div>
        <div class="user_logout">
            <button class="icon icon-switch" onclick="logout()"></button>
            <p><?= $user['username'] ?></p>
        </div>
    </header>
    <script>
        function logout(){
            Swal.fire({
                title: 'Logout',
                text: "Are you sure you want to log out?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Logout',
                footer: '<a href="#" onclick="deleteAcc();return false;">Delete Account</a>'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "php/logout.php"
                }
            })
        }
        function deleteAcc() {
            Swal.fire({
                title: 'Delete your account',
                text: "Are you sure you want to delete your account?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    var php_username = "<?php echo $username; ?>";
                    window.location.href = "php/delete.php?username=" + php_username;
                }
            })
        }
    </script>
</body>
</html>