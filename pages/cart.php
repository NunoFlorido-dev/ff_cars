<?php
session_start();  // Start the session

// Make sure that no output is sent before this
include("../auth/connection.php");
include("../php/pageitems.php");
include("../php/bookingticket.php");

$email = $_SESSION['email'];
$balance = (int)fetchBalance($email);

// Set up the booking ticket session
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

// Calculate the total price if ticket exists
$total_price = 0;
if ($ticket) {
    $begin_time = $ticket['begin_time'];
    $end_time = $ticket['end_time'];
    $car_price = (int)fetchCarPrice($ticket['license_plate']);

    // Calculate the number of days
    $start_date = new DateTime($begin_time);
    $end_date = new DateTime($end_time);
    $current_date = new DateTime();

    if ($start_date < $current_date || $end_date < $current_date) {
        echo "Error: You cannot book dates that are in the past.";
        exit;
    }

// Check if the end date is after the begin date
    if ($end_date <= $start_date) {
        echo "Error: End date must be after the begin date.";
        exit;
    }



    $interval = $start_date->diff($end_date);
    $days = max(1, $interval->days); // Ensure at least 1 day is charged

    $total_price = $car_price * $days;
}

// Handle booking confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_booking']) && $ticket) {
    if ($balance >= $total_price) {
        removeBalance($email, $total_price);
        createBookingTicket($ticket['license_plate'], $ticket['id'], $ticket['begin_time'], $ticket['end_time']);
        unset($_SESSION['booking_ticket']);  // Clear the session ticket
        header("Location: ../index.php");
        exit;
    } else {
        echo "Not enough funds";
    }
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
            <p><?= fetchBrand(htmlspecialchars($ticket['license_plate'])); ?> <?= fetchSegment(htmlspecialchars($ticket['license_plate'])); ?>
                <?= fetchModel(htmlspecialchars($ticket['license_plate'])); ?></p>
            <p>License Plate: <?= htmlspecialchars($ticket['license_plate']); ?></p>
            <p>User ID: <?= htmlspecialchars($ticket['id']); ?></p>
            <p>Begin Time: <?= htmlspecialchars($ticket['begin_time']); ?></p>
            <p>End Time: <?= htmlspecialchars($ticket['end_time']); ?></p>
            <p>Total Price: <?= htmlspecialchars($total_price); ?> €</p>
            <form action="cart.php" method="POST">
                <input type="hidden" name="confirm_booking" value="1">
                <button type="submit">Confirm Booking</button>
            </form>
        </div>
        <div class="pay">
            <p>Balance: <?= htmlspecialchars($balance); ?> €</p>
        </div>
    <?php else: ?>
        <p>No items in the cart.</p>
    <?php endif; ?>
</main>
<script src="../assets/js/nav.js"></script>
</body>
</html>
