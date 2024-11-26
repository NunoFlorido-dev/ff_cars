<?php
session_start();
include("../auth/connection.php");
include("../php/nav.php");
include("../php/userinfo.php");
include("../php/carpage_var.php");


if (!isset($_GET['license_plate'])) {
    echo "Car License Plate is missing.";
    exit;
}

$license_plate = pg_escape_literal($GLOBALS['connection'], $_GET['license_plate']);
$query = "SELECT * FROM car WHERE license_plate = $license_plate";

$result = pg_query($GLOBALS['connection'], $query);
if (!$result || pg_num_rows($result) === 0) {
    echo "Car not found.";
    exit;
}

$car = pg_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/nav.css">
    <link rel="stylesheet" href="../assets/css/car_info.css">
    <link href="https://fonts.cdnfonts.com/css/zt-talk" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">
    <title>FF.Cars | Car Info</title>
</head>
<body>

<nav>
    <div class="top-nav">
        <a class="homepage-link-nav" href="../index.php"><img alt="ff.cars logotype" src="/assets/icons/ff_cars_logo.svg" /></a>
        <?php if (isset($_SESSION['username'])): ?>
        <div class="nav-right-container">
            <?=renderNavLinksWithin($GLOBALS['alternateMode']);
            ?>
            <p class="username-checkout-nav"><?= htmlspecialchars(fetchUsername($_SESSION['email'])); ?>
            </p>
            <img class="burger-button invisibility nav-mobile" alt="burger menu icon" src="/assets/icons/burger_icon.svg" />

        </div>
    </div>
    <div class="bottom-nav">
        <?= renderNavLinksResponsiveWithin($GLOBALS['alternateMode']); ?>
    </div>
    <?php endif; ?>
</nav>

<main>
<div class="car-container">
<div class="left-part">
<img alt="car image" src="" />
    <div class="variable_part">
    <?= changeLeftPart($GLOBALS['alternateMode']);  ?>
    </div>
    </div>
<div class="text">
<h1><?php echo htmlspecialchars($car['brand']) . " " .  htmlspecialchars($car['segment']) . " " .  htmlspecialchars($car['model']); ?></h1>
<p>License Plate: <?php echo htmlspecialchars($car['license_plate']); ?></p>
<p>Brand: <?php echo htmlspecialchars($car['brand']); ?></p>
<p>Segment: <?php echo htmlspecialchars($car['segment']); ?></p>
<p>Fuel Type: <?php echo htmlspecialchars($car['fuel_type']); ?></p>
<p>Year: <?php echo htmlspecialchars($car['year_from']); ?></p>
<p>KM: <?php echo htmlspecialchars($car['km']); ?></p>
<p>Seats: <?php echo htmlspecialchars($car['seats']); ?></p>
<p>Gearshift: <?php echo htmlspecialchars($car['gearshift']); ?></p>
<p>CV: <?php echo htmlspecialchars($car['cv']); ?></p>
<p>Price per day: X</p>
</div>
</div>
</main>
</body>
<script src="../assets/js/nav.js"></script>
</html>