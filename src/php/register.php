<?php
session_start();

include("connection.php");

if (isset($_POST['SignUp'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $checkDatabase = "SELECT * FROM user_web WHERE email = '$email'";
    $getData = pg_query($GLOBALS['connection'], $checkDatabase);

    if (pg_num_rows($getData) > 0) {
        echo "Email already exists!";
    } else {
        $balance = 0;
        $last_id_result = pg_query($GLOBALS['connection'], "SELECT MAX(id) FROM user_web");
        $last_id_row = pg_fetch_array($last_id_result);
        $last_id = $last_id_row[0] + 1;

        $insert = "INSERT INTO client (id, username, email, password, balance) VALUES ('$last_id', '$username', '$email', '$password', '$balance')";
        pg_query($GLOBALS['connection'], $insert);

        if ($GLOBALS['connection']) {
            // Destroy any existing session and start a new one
            session_unset();  // Unset all session variables
            session_destroy(); // Destroy the current session

            session_start();   // Start a new session
            $_SESSION['username'] = $username;  // Set session variables for the new user
            $_SESSION['email'] = $email;

            header("location: ../index.php");
            exit();
        } else {
            echo "Error: Connection Failed";
        }
    }
}

if (isset($_POST['LogIn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $checkDatabase = "SELECT * FROM user_web WHERE email = '$email' AND password = '$password'";
    $getData = pg_query($GLOBALS['connection'], $checkDatabase);

    if (pg_num_rows($getData) > 0) {
        $row = pg_fetch_array($getData);

        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        header('location: ../index.php');
        exit();
    } else {
        echo "Incorrect Email or Password";
    }
}

