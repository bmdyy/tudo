<?php 
    if (session_id() == "")
        session_start(); 
?>

<div id="header">
<b><a href="/">TUDO</a></b> -- <i>An anonymous forum for discussing classes at the <a href="https://www.tuwien.at/en/">Technical University of Vienna</a></i>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){?>
    <span style="float:right;">Logged in as: <a href="/profile.php"><b><?php echo $_SESSION['username']; ?></b></a>, <a href="/includes/logout.php">Log out</a></span>
<?php } ?>
<small style="color:#003366"><a href="http://github.com/bmdyy">&copy; William Moody, 2021</a></small>
</div>