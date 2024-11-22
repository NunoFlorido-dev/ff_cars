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
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/index.css">
    <title>FF.Cars | Homepage</title>
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
<script src="js/nav.js"></script>

<p class="title">Find the best cars to rent!</p>

<div class="search">
    <div class="search_top">
        <input class="search_top_textinput" type="text" id="name" name="name" placeholder="Search car..."/>
        <div>
            <button class="search_top_button">-</button>
            <button class="search_top_button">-</button>
        </div>
    </div>
    <div class="search_bottom">
        <button class="search_bottom_button">Segment</button>
        <button class="search_bottom_button">KM</button>
        <button class="search_bottom_button">NºSeats</button>
        <button class="search_bottom_button">Year</button>
        <button class="search_bottom_button">Gearshift</button>
    </div>
    <div class="search_bottom">
        <button class="search_bottom_button">Model</button>
        <button class="search_bottom_button">Fuel Type</button>
        <button class="search_bottom_button">Brand</button>
    </div>
</div>

<div class="car_list">
    <div class="car_list_part">
        <div class="img_wrapper">biiiig image here</div>
        <p class="car_name">car name</p>
        <div class="car_info">
            <p>year&nbsp;</p>
            <p>&#x2022; KM&nbsp;</p>
            <p>&#x2022; FUEL&nbsp;</p>
            <p>&#x2022; Matricula</p>
        </div>
        <p>X / day</p>
    </div>
</div>

</body>
</html>
