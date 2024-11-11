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

        $insert = "INSERT INTO user_web (username, email, password) VALUES ('$username', '$email', '$password')";
        pg_query($GLOBALS['connection'], $insert);

        if ($GLOBALS['connection']) {
            // destroy  and start new session
            session_unset();
            session_destroy();

            session_start();
            $_SESSION['username'] = $username;
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

