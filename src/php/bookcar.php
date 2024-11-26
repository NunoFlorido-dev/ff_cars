<?php
include("connection.php");
include("definemode.php");

    if (isset($_POST['license_plate'])) {
        $license_plate = $_POST['license_plate'];
        echo "<p>$license_plate</p>";
    }