<?php
session_start();
include("php/connection.php");
include("php/definemode.php");
include("php/nav.php");

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nav.css">
    <title>FF.Cars | Homepage</title>
</head>
<body>
<nav>
    <div class="top-nav">
        <a class="homepage-link-nav"><img alt="ff.cars logotype" src="/assets/ff_cars_logo.svg" /></a>
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
<script src="nav.js"></script>
</body>
</html>
