<?php
use JetBrains\PhpStorm\NoReturn;

include(__DIR__ . '/../auth/connection.php');
include('userinfo.php');


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

#[NoReturn] function addCar() : void {
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
    $id = $_POST['id'];

    // Ensure the $id is being fetched correctly
    if (empty($id)) {
        echo "User ID is missing.";
        exit();
    }

    // Check database connection
    if (!$connection) {
        echo "Database connection error.";
        exit();
    }

    // Step 1: Insert the car into the 'car' table, including the admin_user_web_id
    $car_insert_query = "INSERT INTO car (license_plate, brand, model, segment, fuel_type, seats, year_from, gearshift, km, cv, admin_user_web_id) 
                         VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)";

    $car_added = pg_query_params($connection, $car_insert_query, [
        $license_plate_change, $brand, $model, $segment,
        $fuel_type, $seats, $year, $gearshift,
        $km, $cv, $id
    ]);

    if (!$car_added) {
        echo "Error adding the car: " . pg_last_error($connection);
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
    $variables_added = "INSERT INTO car_variables (price_per_day, availability, change_time, admin_user_web_id, car_license_plate, is_latest) 
                        VALUES ($1, $2, $3, $4, $5, true)";

    $result = pg_query_params($connection, $variables_added, [
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
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['license_plate_change'])) {
    addCar();
}