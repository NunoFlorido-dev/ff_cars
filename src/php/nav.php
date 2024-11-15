<?php
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
            <a class="cart-link-nav normal-nav"> <img alt="cart icon" src="/assets/cart_icon.svg" /></a>
            <a class="wallet-link-nav normal-nav"> <img alt="wallet icon" src="/assets/wallet_icon.svg" /></a>
            <a class="user-link-nav normal-nav" href="user.php"> <img alt="user icon" src="/assets/user_icon.svg" /></a>
        ';
    } else {
        return '
            <a class="key-link-nav normal-nav"> <img alt="key icon" src="/assets/key_admin.svg" /></a>
            <a class="user-link-nav normal-nav" href="user.php"> <img alt="user icon" src="/assets/user_icon.svg" /></a>
        ';
    }
}

function renderNavLinksResponsive($alternateMode){
    if(!$alternateMode){
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="cart-link-nav">Cart</a>
                <a class="wallet-link-nav">Wallet</a>
                <a class="user-link-nav" href="user.php">User</a>
                </div>';
    }else{
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="key-link-nav">Admin Tools</a>
                <a class="user-link-nav" href="user.php">User</a>
                </div>';
    }
}