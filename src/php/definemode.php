<?php
include("connection.php");

$alternateMode = null;

if ($GLOBALS['connection']) {
    if (isset($_SESSION['username'])) {
        $email = $_SESSION['email'];

        // Query to get the user ID
        $idUserResult = pg_query($GLOBALS['connection'], "SELECT id FROM user_web WHERE email = '$email'");

        if ($idUserResult) {
            while ($row = pg_fetch_array($idUserResult)) {
                $userId = $row['id']; // Extract the 'id' field from the row

                // Query to check if user is an admin
                $idAdminQuery = pg_query($GLOBALS['connection'], "SELECT user_web_id FROM user_admin WHERE user_web_id = '$userId'");
                // Query to check if user is a client
                $idClientQuery = pg_query($GLOBALS['connection'], "SELECT user_web_id FROM client WHERE user_web_id = '$userId'");

                // Fetch admin row and check if user is admin
                $adminRow = pg_fetch_array($idAdminQuery);
                if ($adminRow) {
                    $alternateMode = true;
                }

                // Fetch client row and check if user is client
                $clientRow = pg_fetch_array($idClientQuery);
                if ($clientRow) {
                    $alternateMode = false;
                }
            }
        }
    }
}