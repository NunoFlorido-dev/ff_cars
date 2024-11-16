<?php
include("definemode.php");

function fetchUsername($email) {
    $query = pg_query($GLOBALS['connection'], "SELECT username FROM user_web WHERE email = '$email'");
    if ($query) {
        $row = pg_fetch_array($query);
        return $row['username'] ?? null;
    }
    return null;
}

function fetchID($email) {
    $query = pg_query($GLOBALS['connection'], "SELECT id FROM user_web WHERE email = '$email'");
    if ($query) {
        $row = pg_fetch_array($query);
        return $row['id'] ?? null;
    }
    return null;
}

function seeIFAdmin(): void
{
    if($GLOBALS['alternateMode']){
        echo '<div class="admin-cont"> 
        <h1>Admin?</h1>
        <p>Yes</p>
        </div>
';
    }
}