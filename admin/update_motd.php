<?php
    session_start();
    if (!isset($_SESSION['isadmin'])) {
        header('location: /index.php');
        die();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $message = $_POST['message'];

        if ($message !== "") {
            $t_file = fopen("../templates/motd.tpl","w");
            fwrite($t_file, $message);
            fclose($t_file);

            $success = "Message set!";
        } else {
            $error = "Empty message";
        }
    }
?>

<html>
    <head>
        <title>TUDO/Update MoTD</title>
        <link rel="stylesheet" href="../style/style.css">
    </head>
    <body>
        <?php 
            include('../includes/header.php'); 
            include('../includes/db_connect.php');
            
            $t_file = fopen("../templates/motd.tpl", "r");
            $template = fread($t_file,filesize("../templates/motd.tpl"));
            fclose($t_file);
        ?>
        <div id="content">
            <form class="center_form" action="update_motd.php" method="POST">
                <h1>Update MoTD:</h1>
                Set a message that will be visible for all users when they log in.<br><br>
                <textarea name="message"><?php echo $template; ?></textarea><br><br>
                <input type="submit" value="Update Message"> <?php if (isset($success)){echo '<span style="color:green">'.$success.'</span>';}
                else if (isset($error)){echo '<span style="color:red">'.$error.'</span>';}?>
            </form>
            <br>
            <form class="center_form" action="upload_image.php" method="POST" enctype="multipart/form-data">
                <h1>Upload Images:</h1>
                These images will display under the message of the day. <br><br>
                <input name="title" placeholder="Title" /><br><br>
                <input type="file" name="image" size="25" />
                <input type="submit" value="Upload Image">
            </form>
        </div>
    </body>
</html>