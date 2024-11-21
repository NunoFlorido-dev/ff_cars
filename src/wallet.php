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
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/wallet.css">
    <title>FF.Cars | Wallet</title>
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
    <div class="wallet-cont">
        <h1>Balance</h1>
        <p><?= fetchBalance($_SESSION['email']); ?>€</p>
        <button id="add-funds-button">Add funds</button>

        <form method="POST" action="php/funds.php" class="form-display">
            <label for="add-funds">Add Funds</label> <br>
            <input type="number" id="add-funds" name="add-funds">

            <input type="submit" value="Add">
        </form>

    </div>
</main>

<script src="js/nav.js"></script>
<script src="js/funds.js"></script>
</body>
</html>
