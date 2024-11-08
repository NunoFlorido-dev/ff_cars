<?php
include("php/connection.php");

session_start();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FF.Cars | Homepage</title>
</head>
<body>

<div style="text-align:center; padding:15%;">
    <p style="font-size:50px; font-weight:bold;">
        Hello
        <?php
        if (isset($_SESSION['username'])) {
            $email = $_SESSION['email'];
            $query = pg_query($GLOBALS['connection'], "SELECT username FROM client WHERE email = '$email'");

            if ($query) {
                while ($row = pg_fetch_array($query)) {
                    echo $row['username'];
                }
            } else {
                echo "Error: " . pg_last_error($GLOBALS['connection']);
            }
        }
        ?>
    </p>
</div>

</body>
</html>
