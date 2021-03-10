<?php 
    session_start();
    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] == true) {
        header('location: /login.php');
        die();
    } 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['description'])) {
            $error = true;
        }
        else {
            $description = $_POST['description'];
            
            include('includes/db_connect.php');
            $ret = pg_prepare($db, "updatedescription_query", "update users set description = $1 where username = $2");
            $ret = pg_execute($db, "updatedescription_query", Array($description, $_SESSION['username']));
            $success = true;
        }
    }
?>

<html>
    <head>
        <title>TUDO/My Profile</title>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div id="content">
            <?php
                include('includes/db_connect.php');
                $ret = pg_prepare($db, "selectprofile_query", "select * from users where username = $1;");
                $ret = pg_execute($db, "selectprofile_query", Array($_SESSION['username']));
                $row = pg_fetch_row($ret);
            ?>
            <h1>My Profile:</h1>
            <form action="profile.php" method="POST">
                <label for="username">Username: </label>
                <input name="username" value="<?php echo $row[1]; ?>" disabled><br><br>
                <label for="password">Password: </label>
                <input name="password" value="<?php echo $row[2]; ?>" disabled><br><br>
                <label for="description">Description: </label>
                <input name="description" value="<?php echo $row[3]; ?>"><br><br>
                <input type="submit" value="Update"> 
                <?php if (isset($error)) {echo '<span style="color:red">Error</span>';} 
                else if (isset($success)) {echo '<span style="color:green">Success</span>';} ?>
            </form>
        </div>
    </body>
</html>