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