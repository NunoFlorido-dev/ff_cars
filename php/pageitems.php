<?php

use JetBrains\PhpStorm\NoReturn;

include(__DIR__ . '/../auth/connection.php');

global $connection;
if (!$connection) {
    echo "Database connection failed.";
    exit();
}

// Ensure that session_start() is only called if the session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();  // Start session if not already started
}

// Function to safely trim a string and ensure it's not null
function trimString($string): string
{
    return is_string($string) ? trim($string, "'") : '';
}


// You can print and debug the values to make sure they are properly populated


#[NoReturn] function createBookingTicket($license_plate, $id, $begin_time, $end_time): void
{

    global $connection;

    // Check for empty or invalid data and handle accordingly
    if (empty($license_plate) || empty($id) || empty($begin_time) || empty($end_time)) {
        echo "Error: Missing required fields.";
        exit();
    }

    // Check database connection
    if (!$connection) {
        echo "Database connection error.";
        exit();
    }

    // Step 3: Insert a new record with the updated values and is_latest = true
    $create_ticket = "INSERT INTO booking_ticket (begin_time, end_time, car_license_plate, client_user_web_id) 
                             VALUES ($1, $2, $3, $4)";

    $result = pg_query_params($connection, $create_ticket, [
        $begin_time, $end_time, $license_plate, $id]);

    if (!$result) {
        echo "Error inserting new history record: " . pg_last_error($connection);
        exit();
    } else {
        echo "Successfully booked a car!";
    }

    header("Location: ../index.php");
}

?>

<?php
function changeLeftPart($alternateMode){
    global $car;
    if(!$alternateMode){
        global $license_plate;
        global $id;

        echo  <<<HTML
    <form method="post" action="../pages/cart.php">
        <input type="hidden" name="license_plate" value="{$license_plate}">
        <input type="hidden" name="id" value="{$id}">
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
        ;
    } else {
        echo '<form method="post" action="../pages/car_form.php">
         <input type="hidden" name="license_plate" value="' . htmlspecialchars($car['license_plate']) . '">
        
         <button class="editbut" type="submit" id="edit">Edit</button>
    </form>';
    }

}


function renderNavLinks($alternateMode)
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

function renderNavLinksResponsive($alternateMode)
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

function renderNavLinksWithin($alternateMode)
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

function renderNavLinksResponsiveWithin($alternateMode)
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