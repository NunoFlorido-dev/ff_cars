<?php
session_start();
include("connection.php");
include("definemode.php");


if (isset($_POST['add-funds'])) {
    // Get the amount to add and the user email
    $addedFunds = $_POST['add-funds'];
    $email = $_SESSION['email'];

    // Securely fetch user ID based on email
    $queryID = pg_query_params($GLOBALS['connection'], 'SELECT id FROM user_web WHERE email = $1', [$email]);

    if ($queryID) {
        $row_maindb = pg_fetch_array($queryID);

        if ($row_maindb && isset($row_maindb['id'])) {
            $id = $row_maindb['id'];

            // Fetch the current balance securely
            $query = pg_query_params($GLOBALS['connection'], 'SELECT balance FROM client WHERE user_web_id = $1', [$id]);

            if ($query) {
                $row = pg_fetch_array($query);

                if ($row && isset($row['balance'])) {
                    $currentBalance = $row['balance'];
                    $newBalance = $currentBalance + $addedFunds;

                    $updateQuery = pg_query_params(
                        $GLOBALS['connection'],
                        'UPDATE client SET balance = $1 WHERE user_web_id = $2',
                        [$newBalance, $id]
                    );

                    if ($updateQuery) {
                        header("location: ../wallet.php");
                        exit();
                    } else {
                        echo "Error updating balance.";
                    }
                } else {
                    echo "Account not found.";
                }
            } else {
                echo "Error fetching current balance.";
            }
        } else {
            echo "User ID not found.";
        }
    } else {
        echo "Error fetching user ID.";
    }
}else{
    echo "Funds not added";
}
