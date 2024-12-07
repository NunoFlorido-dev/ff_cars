<?php

function fetchTotalCarNumber() {
    $query = pg_query($GLOBALS['connection'], 'SELECT COUNT(license_plate) AS total FROM car');

    if ($query) {
        $count = pg_fetch_result($query, 0, 0);
        return "<p>$count</p>";
    }
}

function fetchTotalUserNumber(){
    $query = pg_query($GLOBALS['connection'], 'SELECT COUNT(id) AS total FROM user_web');

    if ($query){
        $count = pg_fetch_result($query, 0, 0);
        return "<p>$count</p>";
    }
}

function getAverageCarPrice() {
    global $connection;

    if (!$connection) {
        die("Connection failed: " . pg_last_error());
    }

    // SQL query to calculate the average car price
    $query = "SELECT AVG(price_per_day) AS average_price FROM car_variables";
    $result = pg_query($connection, $query);

    if (!$result) {
        die("Query failed: " . pg_last_error());
    }

    // Fetch the result
    $row = pg_fetch_assoc($result);
    $averagePrice = $row['average_price'] ?? 0;

    return number_format($averagePrice, 2, ',', '');

}


function getTotalOfTickets() {
    global $connection;

    if (!$connection) {
        die("Connection failed: " . pg_last_error());
    }

    // SQL query to calculate the average car price
    $query = "SELECT COUNT(id) AS total_of_tickets FROM booking_ticket";
    $result = pg_query($connection, $query);

    if (!$result) {
        die("Query failed: " . pg_last_error());
    }

    // Fetch the result
    $row = pg_fetch_assoc($result);
    $total = $row['total_of_tickets'] ?? 0;

    return $total;

}





