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

$license_plate = $_POST['license_plate'];
$id = $_POST['id'];
$begin_time = $_POST['begin-time'];
$end_time = $_POST['end-time'];

function test(){
    global $license_plate;
    global $id;
    global $begin_time;
    global $end_time;
    $result = $license_plate . $id . $begin_time . $end_time;
    var_dump($license_plate);
    echo $result;
}

function createBookingTicket(){
    global $license_plate;
    global $id;
    global $begin_time;
    global $end_time;
    global $connection;
    echo $id;

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
    }else{
        echo "Successfully booked a car!";
    }

    header("Location: ../pages/cart.php");
    exit();

}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    test();
}