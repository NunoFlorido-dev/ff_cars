<?php

$host = "localhost";
$user = "postgres";
$pass = "postgres";
$port = 5432;
$connection = pg_connect("host=$host port=$port user=$user password=$pass");
