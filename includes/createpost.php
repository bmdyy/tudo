<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lvaCode = $_POST['lvaCode'];
        $lvaName = $_POST['lvaName'];
        $professor = $_POST['professor'];
        $ects = $_POST['ects'];
        $description = $_POST['description'];

        if ($lvaCode!=="" && $lvaName!=="" && $professor!=="" && $ects!=="" && $description!=="") {
            include('db_connect.php');
            $ret = pg_prepare($db,
                "createpost_query", "insert into class_posts (code, name, professor, ects, description) values ($1, $2, $3, $4, $5)");
            $ret = pg_execute($db, "createpost_query", array($lvaCode,$lvaName,$professor,$ects,$description));
        }
    }
    header('location:/index.php');
    die();
?>