<?php
session_start();
include("../auth/connection.php");
include("../php/definemode.php");
include("../php/userinfo.php");
include("../php/stats.php");
include("../php/pageitems.php");
include("../php/bookingticket.php");

// Handle setting the session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_session'])) {
    $_SESSION['booking_ticket'] = [
        'license_plate' => trimString($_POST['license_plate']),
        'id' => (int) $_POST['id'],
        'begin_time' => $_POST['begin-time'],
        'end_time' => $_POST['end-time'],
    ];
}

// Check if the ticket exists in the session
$ticket = $_SESSION['booking_ticket'] ?? null;

// Handle the booking confirmation if needed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_booking']) && $ticket) {
    $license_plate = $ticket['license_plate'];
    $id = $ticket['id'];
    $begin_time = $ticket['begin_time'];
    $end_time = $ticket['end_time'];

    createBookingTicket($license_plate, $id, $begin_time, $end_time);

    // Clear the session after successful booking
    unset($_SESSION['booking_ticket']);
    echo "Booking successful!";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/nav.css">
    <title>FF.Cars | Cart</title>
</head>
<body>
<nav>
    <div class="top-nav">
        <a class="homepage-link-nav" href="../index.php"><img alt="ff.cars logotype" src="/assets/icons/ff_cars_logo.svg" /></a>
        <?php if (isset($_SESSION['username'])): ?>
        <div class="nav-right-container">
            <?= renderNavLinksWithin($GLOBALS['alternateMode']); ?>
            <p class="username-checkout-nav"><?= htmlspecialchars(fetchUsername($_SESSION['email'])); ?></p>
            <img class="burger-button invisibility nav-mobile" alt="burger menu icon" src="/assets/icons/burger_icon.svg" />
        </div>
    </div>
    <div class="bottom-nav">
        <?= renderNavLinksResponsiveWithin($GLOBALS['alternateMode']); ?>
    </div>
    <?php endif; ?>
</nav>

<main>
    <?php if ($ticket): ?>
        <div class="ticket-container">
            <h2>Booking Ticket Summary</h2>
            <p>License Plate: <?= htmlspecialchars($ticket['license_plate']); ?></p>
            <p>User ID: <?= htmlspecialchars($ticket['id']); ?></p>
            <p>Begin Time: <?= htmlspecialchars($ticket['begin_time']); ?></p>
            <p>End Time: <?= htmlspecialchars($ticket['end_time']); ?></p>
            <form action="cart.php" method="POST">
                <input type="hidden" name="confirm_booking" value="1">
                <button type="submit">Confirm Booking</button>
            </form>
        </div>
    <?php else: ?>
        <p>No items in the cart.</p>
    <?php endif; ?>
</main>
</body>
<script src="../assets/js/nav.js"></script>
</html>
