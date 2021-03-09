<?php
    if (!isset($db)) {
        $host        = "host = 127.0.0.1";
        $port        = "port = 5432";
        $dbname      = "dbname = tudo";
        $credentials = "user = postgres password = postgres";

        $db = pg_connect( "$host $port $dbname $credentials" );

        if (!$db) {
            echo "Error: Unable to connect to db.";
        }
    }
?>