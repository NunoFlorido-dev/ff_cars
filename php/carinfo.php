<?php

use JetBrains\PhpStorm\NoReturn;

include(__DIR__ . '/../auth/connection.php');

global $connection;
if (!$connection) {
    echo "Database connection failed.";
    exit();
}

// Ensure that session_start() is only called if the session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();  // Start session if not already started
}

// Now you can access $_SESSION variables safely
$email = $_SESSION['email'] ?? '';  // For example, accessing session data

if (empty($email)) {
    echo "User email is not set or empty.";
    exit();
}

// Continue with the rest of your code
include_once("userinfo.php");

$id = fetchID($email);
if (!$id) {
    echo "Unable to fetch user ID for " . $_SESSION['email'];
    exit();
}

// rest of the code...

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

    $query = "SELECT $variableDetail FROM car_variables WHERE car_license_plate = $1 AND is_latest = true";
    $result = pg_query_params($connection, $query, [$license_plate]);

    if ($result && pg_num_rows($result) > 0) {
        return htmlspecialchars(pg_fetch_result($result, 0, 0));
    } else {
        return null;
    }
}

function fetchCarPrice($license_plate) {
    $query = pg_query_params(
        $GLOBALS['connection'],
        "SELECT price_per_day FROM car_variables WHERE car_license_plate = $1 AND is_latest = true",
        [$license_plate]
    );

    if ($query && pg_num_rows($query) > 0) {
        $row = pg_fetch_array($query);
        return $row['price_per_day'] ?? null;
    }
    return null;
}


function fetchChangeDate($license_plate) {
    $query = pg_query($GLOBALS['connection'], "SELECT change_time FROM car_variables WHERE car_license_plate = '$license_plate'");
    if ($query) {
        $row = pg_fetch_array($query);
        return $row['change_time'] ?? null;
    }
    return null;
}

function fetchAvailability(string $license_plate): bool {
    global $connection;

    $query = "SELECT availability FROM car_variables WHERE car_license_plate = $1 AND is_latest = true";
    $result = pg_query_params($connection, $query, [$license_plate]);

    if ($result) {
        $row = pg_fetch_assoc($result);
        if ($row) {
            // Convert 't' or 'f' to true or false
            return $row['availability'] === 't';
        }
    }
    return false; // Default to false if not found
}


#[NoReturn] function updateValues() : void {
    global $connection;
    global $id;

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
    $availability = $_POST['availability_change'] ? 't' : 'f';
    $current_date = date('Y-m-d');  // Proper date format for PostgreSQL

    // Check database connection
    if (!$connection) {
        echo "Database connection error.";
        exit();
    }

    // Step 1: Update the 'car' table
    $car_update_query = "UPDATE car SET 
        license_plate = $1, brand = $2, model = $3, segment = $4, 
        fuel_type = $5, seats = $6, year_from = $7, 
        gearshift = $8, km = $9, cv = $10 
        WHERE license_plate = $11";

    $result_car = pg_query_params($connection, $car_update_query, [
        $license_plate_change, $brand, $model, $segment,
        $fuel_type, $seats, $year, $gearshift,
        $km, $cv, $license_plate_change
    ]);

    if (!$result_car) {
        echo "Error updating car table: " . pg_last_error($connection);
        exit();
    }

    // Step 2: Update all entries' is_latest to false for the car
    $update_latest_query = "UPDATE car_variables SET is_latest = false 
                            WHERE car_license_plate = $1";
    $result = pg_query_params($connection, $update_latest_query, [$license_plate_change]);
    if (!$result) {
        echo "Error updating latest records: " . pg_last_error($connection);
        exit();
    }

    // Step 3: Insert a new record with the updated values and is_latest = true
    $insert_history_query = "INSERT INTO car_variables (price_per_day, availability, change_time, admin_user_web_id, car_license_plate, is_latest) 
                             VALUES ($1, $2, $3, $4, $5, true)";

    $result = pg_query_params($connection, $insert_history_query, [
        $price_per_day, $availability, $current_date, $id, $license_plate_change
    ]);
    if (!$result) {
        echo "Error inserting new history record: " . pg_last_error($connection);
        exit();
    }

    // Step 4: Optionally update the current state if needed (you can skip this if no further updates are needed)
    $update_current_variables_query = "UPDATE car_variables SET price_per_day = $1, availability = $2 
                                       WHERE car_license_plate = $3 AND is_latest = true";
    $result = pg_query_params($connection, $update_current_variables_query, [$price_per_day, $availability, $license_plate_change]);

    if (!$result) {
        echo "Error updating current variables: " . pg_last_error($connection);
        exit();
    }

    // Redirect to the car form page
    header("Location: ../pages/car_form.php");
    exit();
}

// Only call updateValues() if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['license_plate_change'])) {
    updateValues();
}

