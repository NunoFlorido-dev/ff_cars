<?php

use JetBrains\PhpStorm\NoReturn;

include(__DIR__ . '/../auth/connection.php');
include('../php/carinfo.php');

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


// You can print and debug the values to make sure they are properly populated


#[NoReturn] function createBookingTicket($license_plate, $id, $begin_time, $end_time): void
{



    global $connection;

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

    header("Location: ../index.php");
}

?>
