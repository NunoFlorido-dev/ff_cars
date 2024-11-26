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

function fetchBalance($email) {
    $queryID = pg_query($GLOBALS['connection'], "SELECT id FROM user_web WHERE email = '$email'");

    if ($queryID) {
        $row = pg_fetch_array($queryID);

        if ($row && isset($row['id'])) {
            $userWebID = $row['id'];

            $queryBalance = pg_query($GLOBALS['connection'], "SELECT balance FROM client WHERE user_web_id = $userWebID");

            if ($queryBalance) {
                $rowBalance = pg_fetch_array($queryBalance);

                return $rowBalance['balance'] ?? null;
            }
        }
    }

    return null;
}

