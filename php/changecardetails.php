<?php
include("../auth/connection.php");


$license_plate = isset($_GET['license_plate']) ? htmlspecialchars($_GET['license_plate']) : null;

if (!$license_plate) {
    die("License plate is missing.");
}
function getCarDetail($carDetail): ?string
{
    global $connection, $license_plate;

    $query = "SELECT $carDetail FROM car WHERE license_plate = $1";
    $result = pg_query_params($connection, $query, [$license_plate]);

    if ($result && pg_num_rows($result) > 0) {
        return htmlspecialchars(pg_fetch_result($result, 0, 0));
    } else {
        return null;
    }
}

function getVariableDetail($variableDetail): ?string
{
    global $connection, $license_plate;

    $query = "SELECT $variableDetail FROM car_variables WHERE car_license_plate = $1";
    $result = pg_query_params($connection, $query, [$license_plate]);

    if ($result && pg_num_rows($result) > 0) {
        return htmlspecialchars(pg_fetch_result($result, 0, 0));
    } else {
        return null;
    }
}
