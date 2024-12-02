<?php

function fetchCarPrice($license_plate) {
    $query = pg_query($GLOBALS['connection'], "SELECT price_per_day FROM car_variables WHERE car_license_plate = '$license_plate'");
    if ($query) {
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