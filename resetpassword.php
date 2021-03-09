<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header('location: /index.php');
        die();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include('includes/db_connect.php');
        $ret = pg_prepare($db, "checktoken_query", "select * from tokens where token = $1");
        $ret = pg_execute($db, "checktoken_query", array($_GET['token']));

        if (pg_num_rows($ret) === 0) {
            $invalid_token = true;
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['token'])) {
            echo 'invalid request';
            die();
        }

        $token = $_POST['token'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if ($password1 !== $password2) {
            $pass_error = true;
        }
        else {
            include('includes/db_connect.php');
            $ret = pg_prepare($db, "checktoken_query", "select * from tokens where token = $1");
            $ret = pg_execute($db, "checktoken_query", array($token));

            if (pg_num_rows($ret) === 0) {
                $invalid_token = true;
            } else {
                $uid = pg_fetch_row($ret)[1];
                $newpass = hash('sha256', $password1);

                $ret = pg_prepare($db, "changepassword_query", "update users set password = $1 where uid = $2");
                $ret = pg_execute($db, "changepassword_query", array($newpass, $uid));

                $ret = pg_prepare($db, "deletetoken_query", "delete from tokens where token = $1");
                $ret = pg_execute($db, "deletetoken_query", array($token));

                $success = true;
            }
        }
    }
?>

<html>
    <head>
        <title>TUDO/Reset Password</title>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div id="content">
            <?php
                if (isset($invalid_token)) {
                    echo '<h1 style="color:red">Token is invalid.</h1>';
                    echo '<a href="#" onclick="history.back();return false">Go back</a>';
                    die();
                }
                
                if (isset($pass_error)) {
                    echo '<h1 style="color:red">Passwords don\'t match.</h1><br>';
                    echo '<a href="#" onclick="history.back();return false">Go back</a>';
                    die();
                }
            ?>
            <div id="content">
                <form class="center_form" action="resetpassword.php" method="POST">
                    <h1>Reset Password:</h1>
                    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                    <input type="password" name="password1" placeholder="New password"><br><br>
                    <input type="password" name="password2" placeholder="Confirm password"><br><br>
                    <input type="submit" value="Change password"> 
                    <?php if (isset($success)){echo "<span style='color:green'>Password changed!</span>";} ?>
                    <br><br>
                    <?php include('includes/login_footer.php'); ?>
                </form>
            </div>
        </div>
    </body>
</html>