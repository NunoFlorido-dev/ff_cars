<?php
function changeLeftPart($alternateMode): void
{
global $car;
    if(!$alternateMode){
        global $license_plate;
        global $id;

        echo  <<<HTML
    <form method="post" action="../pages/cart.php">
        <input type="hidden" name="license_plate" value="$license_plate">
        <input type="hidden" name="id" value="$id">
         <input type="hidden" name="set_session" value="1">

<div class = "dates">
        <div class="begindate">
        
            <label for="begin-time">Begin Time</label>
            <div class = "calendar">
            <input type="date" id="begin-time" name="begin-time">
            </div>
            </div>
            <div class="enddate">
            <label for="end-time">End Time</label>
            <div class = "calendar">
            <input type="date" id="end-time" name="end-time">
            </div>
        </div>
        </div>

        <br>
        <div class ="buttons">
        <button type="submit" id="add-pay" class="button1" formaction="cart.php">Add to Cart & Pay</button>
        <br>
        <button type="submit" class="button2"  id="add-continue" formaction="../index.php">Add to Cart & Continue Search</button>
        </div>
    </form>
HTML;
    } else {
        echo '<form method="post" action="../pages/car_form.php">
         <input type="hidden" name="license_plate" value="' . htmlspecialchars($car['license_plate']) . '">
        
         <button class="editbut" type="submit" id="edit">Edit</button>
    </form>';
    }

}


function renderNavLinks($alternateMode): string
{
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

function renderNavLinksResponsive($alternateMode): string
{
    if (!$alternateMode) {
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="cart-link-nav">Cart</a>
                <a class="wallet-link-nav" href="pages/wallet.php">Wallet</a>
                <a class="user-link-nav" href="pages/user.php">User</a>
                </div>';
    } else {
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="key-link-nav" href="pages/admintools.php">Admin Tools</a>
                <a class="user-link-nav" href="pages/user.php">User</a>
                </div>';
    }
}

function renderNavLinksWithin($alternateMode): string
{
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

function renderNavLinksResponsiveWithin($alternateMode): string
{
    if (!$alternateMode) {
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="cart-link-nav" href="cart.php">Cart</a>
                <a class="wallet-link-nav" href="wallet.php">Wallet</a>
                <a class="user-link-nav" href="user.php">User</a>
                </div>';
    } else {
        return '<div class="mobile-nav invisibility nav-responsive">
                <a class="key-link-nav" href="admintools.php">Admin Tools</a>
                <a class="user-link-nav" href="user.php">User</a>
                </div>';
    }
}
