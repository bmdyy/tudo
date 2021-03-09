<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header('location: /index.php');
        die();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];

        if ($username != 'admin') {
            include('includes/db_connect.php');
            $ret = pg_prepare($db, "checkuser_query", "select * from users where username = $1");
            $ret = pg_execute($db, "checkuser_query", array($_POST['username']));

            if (pg_num_rows($ret) === 1) {
                $row = pg_fetch_row($ret)[0];

                include('includes/utils.php');
                $token = generateToken();

                $ret = pg_prepare($db, "createtoken_query", "insert into tokens (uid, token) values ($1, $2)");
                $ret = pg_execute($db, "createtoken_query", array($row, $token));

                $success = true;
            }
            else {
                $error = true;
            }
        }
    }
?>

<html>
    <head>
        <title>TUDO/Forgot Password</title>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div id="content">
            <form class="center_form" action="forgotpassword.php" method="POST">
                <h1>Forgot Password:</h1>
                <p>Please enter your username, and we will create a reset token that you can use to change your password. It will
                be sent to your email. Please check your spam just in case</p>
                <input name="username" placeholder="Username"><br><br>
                <input type="submit" value="Send Reset Token"> 
                <?php if (isset($error)){echo "<span style='color:red'>User doesn't exist</span>";}
                else if (isset($success)){echo "<span style='color:green'>Email sent!</span>";} ?>
                <br><br>
                <?php include('includes/login_footer.php'); ?>
            </form>
        </div>
    </body>
</html>