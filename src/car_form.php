<?php
session_start();
include("php/connection.php");
include("php/definemode.php");
include("php/userinfo.php");
include("php/carpage_var.php");
include("php/nav.php");

?>

<!doctype html>
<html lang="en">
<link>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/nav.css">
    <title>FF.Cars | Car Form</title>
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


</main>

</body>
<script src="js/nav.js"
</html>