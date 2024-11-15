<?php
session_start();
include("php/connection.php");
include("php/definemode.php");

function fetchUsername($email) {
    $query = pg_query($GLOBALS['connection'], "SELECT username FROM user_web WHERE email = '$email'");
    if ($query) {
        $row = pg_fetch_array($query);
        return $row['username'] ?? null;
    }
    return null;
}

function renderNavLinks($alternateMode) {
    if (!$alternateMode) {
        return '
            <a class="cart-link-nav normal-nav"> <img alt="cart icon" src="../assets/cart_icon.svg" /></a>
            <a class="wallet-link-nav normal-nav"> <img alt="wallet icon" src="../assets/wallet_icon.svg" /></a>
            <a class="user-link-nav normal-nav"> <img alt="user icon" src="../assets/user_icon.svg" /></a>
        ';
    } else {
        return '
            <a class="key-link-nav normal-nav"> <img alt="key icon" src="../assets/key_admin.svg" /></a>
            <a class="user-link-nav normal-nav"> <img alt="user icon" src="../assets/user_icon.svg" /></a>
        ';
    }
}

function renderNavLinksResponsive($alternateMode){
    if(!$alternateMode){
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="cart-link-nav">Cart</a>
                <a class="wallet-link-nav">Wallet</a>
                <a class="user-link-nav">User</a>
                </div>';
    }else{
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="key-link-nav">Admin Tools</a>
                <a class="user-link-nav">User</a>
                </div>';
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>FF.Cars | Homepage</title>
</head>
<body>
<nav>
    <div class="top-nav">
    <a class="homepage-link-nav"><img alt="ff.cars logotype" src="../assets/ff_cars_logo.svg" /></a>
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
<script src="script.js"></script>
</body>
</html>
