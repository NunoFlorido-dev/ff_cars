<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../../assets/css/login.css" rel="stylesheet">
    <title>FF.CARS | Sign In Page</title>
</head>
<body>

<div id="container_login">
    <img src="/assets/icons/ff_cars_logo.svg" alt="FF.CARS Logotype" />
    <div class="login_container">
        <h1>Log In</h1>
        <form method="POST" action="../auth/register.php">
            <div class="email">
                <label for="email_log">Email:</label> <br/>
                <input type="email" id="email_log" name="email" placeholder="Add email"> <br/>
            </div>

            <div class="password">
                <label for="password_log">Password:</label> <br/>
                <input type="password" id="password_log" name="password" placeholder="Create password"> <br/>
            </div>

            <input type="submit" value="Log In" name="LogIn">
        </form>
        <p>Don't have an account? <button id="register_button">Sign Up for one!</button></p>
    </div>
</div>

<!--   -->
<div id="container_register">
    <img src="/assets/icons/ff_cars_logo.svg" alt="FF.CARS Logotype" />
    <div class="login_container">
        <h1>Create Account</h1>
        <form method="POST" action="../auth/register.php">
            <div class="username">
                <label for="username">Username:</label> <br/>
                <input type="text" id="username" name="username" placeholder="Create username"> <br/>
            </div>

            <div class="email">
                <label for="email">Email:</label> <br/>
                <input type="email" id="email" name="email" placeholder="Add email"> <br/>
            </div>

            <div class="password">
                <label for="password">Password:</label> <br/>
                <input type="password" id="password" name="password" placeholder="Create password"> <br/>
            </div>

            <input type="submit" value="Sign Up" name="SignUp">
        </form>
        <button id="login_button">Return to Log In</button>
    </div>
</div>

<script src="../../assets/js/login.js"></script>
</body>
