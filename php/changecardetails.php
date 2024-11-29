<?php
include("../auth/connection.php");

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

function updateValues() : void{

    global $connection;

    // Retrieve updated data from the form
    $license_plate_change = $_POST['license_plate_change'] ?? '';
    $brand = $_POST['brand_change'] ?? '';
    $model = $_POST['model_change'] ?? '';
    $segment = $_POST['segment_change'] ?? '';
    $fuel_type = $_POST['fuel_type_change'] ?? '';
    $seats = $_POST['seats_change'] ?? 0;
    $year = $_POST['year_change'] ?? 0;
    $gearshift = $_POST['gearshift_change'] ?? '';
    $km = $_POST['km_change'] ?? 0;
    $cv = $_POST['cv_change'] ?? 0;
    $price_per_day = $_POST['price_per_day_change'] ?? 0;
    $availability = isset($_POST['availability_change']) ? 't' : 'f';

    // Debugging: Output form values
    if (!$connection) {
        echo "Database connection error.";
        exit();
    }

    // Update the 'car' table
    $car_update_query = "UPDATE car SET 
        license_plate = $1, brand = $2, model = $3, segment = $4, 
        fuel_type = $5, seats = $6, year_from = $7, 
        gearshift = $8, km = $9, cv = $10 
        WHERE license_plate = $11";

    pg_query_params($connection, $car_update_query, [
        $license_plate_change, $brand, $model, $segment,
        $fuel_type, $seats, $year, $gearshift,
        $km, $cv, $license_plate_change
    ]);

    // Update the 'car_variables' table
    $variable_update_query = "UPDATE car_variables SET 
        price_per_day = $1, availability = $2 
        WHERE car_license_plate = $3";

    pg_query_params($connection, $variable_update_query, [
        $price_per_day, $availability, $license_plate_change
    ]);


    header("Location: ../pages/car_form.php");
}

// Only call updateValues() if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['license_plate_change'])) {
    updateValues();
}