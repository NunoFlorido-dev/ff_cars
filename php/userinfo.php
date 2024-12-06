<?php
include("definemode.php");
include(__DIR__ . '/../auth/connection.php');

global $connection;

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

function removeBalance($email, $impact) {
    $connection = $GLOBALS['connection'];

    // Sanitize the input
    $email = pg_escape_string($connection, $email);

    // Query to get the user ID
    $queryID = pg_query($connection, "SELECT id FROM user_web WHERE email = '$email'");

    if ($queryID) {
        $row = pg_fetch_assoc($queryID);

        if ($row && isset($row['id'])) {
            $userWebID = (int)$row['id'];

            // Query to get the current balance
            $queryBalance = pg_query($connection, "SELECT balance FROM client WHERE user_web_id = $userWebID");

            if ($queryBalance) {
                $rowBalance = pg_fetch_assoc($queryBalance);
                $currentBalance = (int)$rowBalance['balance'];
                $removeValue = (int)$impact;

                $newBalance = $currentBalance - $removeValue;

                // Update the balance
                $updateBalance = pg_query($connection,
                    "UPDATE client SET balance = $newBalance WHERE user_web_id = $userWebID");

                if ($updateBalance) {
                    return "Balance updated successfully.";
                } else {
                    return "Failed to update balance.";
                }
            }
        }
    }

    return "User not found or failed to update balance.";
}
