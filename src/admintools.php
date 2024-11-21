<?php
session_start();
include("php/connection.php");
include("php/definemode.php");
include("php/nav.php");
include("php/userinfo.php");
include("php/gentools.php");

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/admintools.css">
    <title>FF.Cars | Admin Tools</title>
</head>
<body>
<nav>
    <div class="top-nav">
        <a class="homepage-link-nav" href="index.php"><img alt="ff.cars logotype" src="../assets/ff_cars_logo.svg" /></a>
        <?php if (isset($_SESSION['username'])): ?>
        <div class="nav-right-container">
            <?= renderNavLinks($GLOBALS['alternateMode']); ?>
            <p class="username-checkout-nav"><?= htmlspecialchars(fetchUsername($_SESSION['email'])); ?>
            </p>
            <img class="burger-button invisibility nav-mobile" alt="burger menu icon" src="../assets/burger_icon.svg" />

        </div>
    </div>
    <div class="bottom-nav">
        <?= renderNavLinksResponsive($GLOBALS['alternateMode']); ?>
    </div>
    <?php endif; ?>
</nav>

<main>
    <div class="select-page">
        <button id="general-page">General</button>
        <button id="cars-page">Cars</button>
    </div>

    <div class="general-page-cont">
        <div class="total-cars">
            <h2>Total Number of Cars</h2>
            <?= fetchTotalCarNumber(); ?>
        </div>

        <div class="total-users">
            <h2>Total Number of Users</h2>
            <?= fetchTotalUserNumber(); ?>
        </div>
    </div>

    <div class="cars-page-cont">
<p>cars</p>
    </div>

</main>

<script src="js/nav.js"></script>
<script src="js/admintools.js"></script>


</body>
</html>
