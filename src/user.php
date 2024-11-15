<?php
session_start();
include("php/connection.php");
include("php/definemode.php");
include("php/nav.php");
include("php/userinfo.php");

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="user.css">
    <title>FF.Cars | User</title>
</head>
<body>
<nav>
    <div class="top-nav">
        <a class="homepage-link-nav" href="index.php"><img alt="ff.cars logotype" src="/assets/ff_cars_logo.svg" /></a>
        <?php if (isset($_SESSION['username'])): ?>
        <div class="nav-right-container">
            <?= renderNavLinks($GLOBALS['alternateMode']); ?>
            <p class="username-checkout-nav"><?= htmlspecialchars(fetchUsername($_SESSION['email'])); ?>
            </p>
            <img class="burger-button invisibility nav-mobile" alt="burger menu icon" src="/assets/burger_icon.svg" />

        </div>
    </div>
    <div class="bottom-nav">
        <?= renderNavLinksResponsive($GLOBALS['alternateMode']); ?>
    </div>
    <?php endif; ?>
</nav>

<main>

    <section class="user-info">
        <?php if (isset($_SESSION['username']) && isset($_SESSION['email']) && isset($_SESSION['password'])); ?>
      <img alt="user icon" src="/assets/user_icon.svg">

        <div class="username_cont">
            <h1>Username</h1>
            <p><?= htmlspecialchars(fetchUsername($_SESSION['email'])); ?></p>
        </div>

        <div class="email_cont">
            <h1>Email</h1>
            <p><?= $_SESSION['email'] ?></p>

        </div>

        <div class="password_cont">
            <h1>Password</h1>
            <p><?= $_SESSION['password'] ?></p>
        </div>

    </section>

    <section class="booking-info">
    </section>


</main>


<script src="nav.js"></script>
</body>
</html>
