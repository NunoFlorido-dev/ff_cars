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

// Function to safely trim a string and ensure it's not null
function trimString($string): string
{
    return is_string($string) ? trim($string, "'") : '';
}

// Check if form values are set before using them
$license_plate = isset($_POST['license_plate']) ? trimString($_POST['license_plate']) : '';
$id = $_POST['id'] ?? '';
$begin_time = $_POST['begin-time'] ?? '';
$end_time = $_POST['end-time'] ?? '';

// You can print and debug the values to make sure they are properly populated

#[NoReturn] function createBookingTicket(): void
{
    global $license_plate, $id, $begin_time, $end_time, $connection;

    // Check for empty or invalid data and handle accordingly
    if (empty($license_plate) || empty($id) || empty($begin_time) || empty($end_time)) {
        echo "Error: Missing required fields.";
        exit();
    }

    // Check database connection
    if (!$connection) {
        echo "Database connection error.";
        exit();
    }

    // Step 3: Insert a new record with the updated values and is_latest = true
    $create_ticket = "INSERT INTO booking_ticket (begin_time, end_time, car_license_plate, client_user_web_id) 
                             VALUES ($1, $2, $3, $4)";

    $result = pg_query_params($connection, $create_ticket, [
        $begin_time, $end_time, $license_plate, $id]);

    if (!$result) {
        echo "Error inserting new history record: " . pg_last_error($connection);
        exit();
    } else {
        echo "Successfully booked a car!";
    }

    header("Location: ../pages/cart.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    createBookingTicket();
}

?>
}