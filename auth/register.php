<?php
session_start();

include("connection.php");

if (isset($_POST['SignUp'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkDatabase = "SELECT * FROM user_web WHERE email = '$email'";
    $getData = pg_query($GLOBALS['connection'], $checkDatabase);

    if (pg_num_rows($getData) > 0) {
        echo "Email already exists!";
    } else {
        // Insert into user_web table with RETURNING id to get the new user's id
        $insert = "INSERT INTO user_web (username, email, password) VALUES ('$username', '$email', '$password') RETURNING id";
        $result = pg_query($GLOBALS['connection'], $insert);

        if ($result) {
            // Fetch the returned id from the insert query
            $userId = pg_fetch_result($result, 0, 'id');

            // Insert into client table using the new user id
            $insertClient = "INSERT INTO client (balance, user_web_id) VALUES (0.00, $userId)";
            pg_query($GLOBALS['connection'], $insertClient);

            // Destroy and start a new session
            session_unset();
            session_destroy();

            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;


            header("location: ../index.php");
            exit();
        } else {
            echo "Error: User creation failed.";
        }
    }
}

if (isset($_POST['LogIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkDatabase = "SELECT * FROM user_web WHERE email = '$email' AND password = '$password'";
    $getData = pg_query($GLOBALS['connection'], $checkDatabase);

    if (pg_num_rows($getData) > 0) {
        $row = pg_fetch_array($getData);

        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['password'] = $row['password'];
        header('location: ../index.php');
        exit();
    } else {
        echo "Incorrect Email or Password";
    }
}
