<?php
function renderNavLinks($alternateMode) {
    if (!$alternateMode) {
        return '
            <a class="cart-link-nav normal-nav" href="pages/cart.php"> <img alt="cart icon" src="/assets/icons/cart_icon.svg" /></a>
            <a class="wallet-link-nav normal-nav" href="pages/wallet.php"> <img alt="wallet icon" src="/assets/icons/wallet_icon.svg" /></a>
            <a class="user-link-nav normal-nav" href="pages/user.php"> <img alt="user icon" src="/assets/icons/user_icon.svg" /></a>
        ';
    } else {
        return '
            <a class="key-link-nav normal-nav" href="pages/admintools.php"> <img alt="key icon" src="/assets/icons/key_admin.svg" /></a>
            <a class="user-link-nav normal-nav" href="pages/user.php"> <img alt="user icon" src="/assets/icons/user_icon.svg" /></a>
        ';
    }
}

function renderNavLinksResponsive($alternateMode){
    if(!$alternateMode){
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="cart-link-nav">Cart</a>
                <a class="wallet-link-nav" href="pages/wallet.php">Wallet</a>
                <a class="user-link-nav" href="pages/user.php">User</a>
                </div>';
    }else{
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="key-link-nav" href="pages/admintools.php">Admin Tools</a>
                <a class="user-link-nav" href="pages/user.php">User</a>
                </div>';
    }
}

function renderNavLinksWithin($alternateMode) {
    if (!$alternateMode) {
        return '
            <a class="cart-link-nav normal-nav" href="cart.php"> <img alt="cart icon" src="/assets/icons/cart_icon.svg" /></a>
            <a class="wallet-link-nav normal-nav" href="wallet.php"> <img alt="wallet icon" src="/assets/icons/wallet_icon.svg" /></a>
            <a class="user-link-nav normal-nav" href="user.php"> <img alt="user icon" src="/assets/icons/user_icon.svg" /></a>
        ';
    } else {
        return '
            <a class="key-link-nav normal-nav" href="admintools.php"> <img alt="key icon" src="/assets/icons/key_admin.svg" /></a>
            <a class="user-link-nav normal-nav" href="user.php"> <img alt="user icon" src="/assets/icons/user_icon.svg" /></a>
        ';
    }
}

function renderNavLinksResponsiveWithin($alternateMode){
    if(!$alternateMode){
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="cart-link-nav" href="cart.php">Cart</a>
                <a class="wallet-link-nav" href="wallet.php">Wallet</a>
                <a class="user-link-nav" href="user.php">User</a>
                </div>';
    }else{
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="key-link-nav" href="admintools.php">Admin Tools</a>
                <a class="user-link-nav" href="user.php">User</a>
                </div>';
    }
}
