<?php
session_start();  // Start the session

// Make sure that no output is sent before this
include("../auth/connection.php");
include("../php/pageitems.php");
include("../php/bookingticket.php");

$email = $_SESSION['email'];
$balance = (int)fetchBalance($email);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_session'])) {
    $_SESSION['booking_ticket'] = [
        'license_plate' => trimString($_POST['license_plate']),
        'id' => (int)$_POST['id'],
        'begin_time' => $_POST['begin-time'],
        'end_time' => $_POST['end-time'],
    ];
}

// Check if the ticket exists in the session
$ticket = $_SESSION['booking_ticket'] ?? null;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_booking']) && $ticket) {
    $license_plate = $ticket['license_plate'];
    $id = $ticket['id'];
    $begin_time = $ticket['begin_time'];
    $end_time = $ticket['end_time'];
    $car_price = (int)fetchCarPrice($ticket['license_plate']);


    if ($balance >= $car_price) {
        removeBalance($email, $car_price);
        // Call your booking function
        createBookingTicket($license_plate, $id, $begin_time, $end_time);
    } else {
        echo "Not enough funds";
    }
    // Clear the session after successful booking
    unset($_SESSION['booking_ticket']);  // Removes only the booking_ticket session variable
    // Or, if you want to clear all session variables, you can use:
    // session_unset();

    // Optionally, you can destroy the session entirely (useful if you want to log out the user)
    // session_destroy();

    // Redirect to another page (e.g., homepage)
    header("Location: ../index.php");
}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/nav.css">
    <link rel="stylesheet" href="../assets/css/cart.css">
    <title>FF.Cars | Cart</title>
</head>
<body>
<nav>
    <div class="top-nav">
        <a class="homepage-link-nav" href="../index.php"><img alt="ff.cars logotype"
                                                              src="/assets/icons/ff_cars_logo.svg"/></a>
        <?php if (isset($_SESSION['username'])): ?>
        <div class="nav-right-container">
            <?= renderNavLinksWithin($GLOBALS['alternateMode']); ?>
            <p class="username-checkout-nav"><?= htmlspecialchars(fetchUsername($_SESSION['email'])); ?></p>
            <img class="burger-button invisibility nav-mobile" alt="burger menu icon"
                 src="/assets/icons/burger_icon.svg"/>
        </div>
    </div>
    <div class="bottom-nav">
        <?= renderNavLinksResponsiveWithin($GLOBALS['alternateMode']); ?>
    </div>
    <?php endif; ?>
</nav>

<main>
    <?php if ($ticket): ?>
    <div class="cart_page">
        <div class="tickets">
            <div class="ticket-container">
                <div class='img_wrapper'><img alt='car image'></div>
                <div class="ticket-container_part">
                    <div class="car_info_top">
                        <p><?= fetchBrand(htmlspecialchars($ticket['license_plate'])); ?> <?= fetchSegment(htmlspecialchars($ticket['license_plate'])); ?>
                            <?= fetchModel(htmlspecialchars($ticket['license_plate'])); ?></p>
                    </div>
                    <div class="car_info_mid">
                        <p><?= htmlspecialchars($ticket['begin_time']); ?></p>
                    </div>
                    <div class="car_info_bot">
                        <div class="car_info_bot_part">
                            <p><?= fetchCarPrice(htmlspecialchars($ticket['license_plate'])); ?> €</p>
                            <p><?= htmlspecialchars($ticket['license_plate']); ?></p>
                        </div>
                        <p><?= htmlspecialchars($ticket['end_time']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="pay">
            <p><?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_booking']) && $ticket) {
                    echo $car_price;
                } ?> </p>
            <p><?= $balance ?> €</p>
            <form action="cart.php" method="POST">
                <input type="hidden" name="confirm_booking" value="1">
                <button type="submit">Book!</button>
            </form>
        </div>
        <?php else: ?>
            <p>No items in the cart.</p>
        <?php endif; ?>
    </div>
</main>
</body>
<script src="../assets/js/nav.js"></script>
<script src="../assets/js/carimages.js"></script>
</html>