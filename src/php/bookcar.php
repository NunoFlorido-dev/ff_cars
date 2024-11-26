<?php
session_start();
include("php/connection.php");
include("php/definemode.php");

$license_plate = $_POST['license_plate'];

echo $license_plate;
