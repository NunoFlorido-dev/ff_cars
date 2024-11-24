<?php
session_start();
include("php/connection.php");
include("php/definemode.php");
include("php/userinfo.php");
include("php/nav.php");

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
    <link rel="stylesheet" href="css/nav.css">
    <link href="https://fonts.cdnfonts.com/css/zt-talk" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">
    <title>FF.Cars | Car Info</title>
</head>
<body>

<nav>
    <div class="top-nav">
        <a class="homepage-link-nav" href="index.php"><img alt="ff.cars logotype" src="/assets/ff_cars_logo.svg" /></a>
        <?php if (isset($_SESSION['username'])): ?>
        <div class="nav-right-container">
            <?= renderNavLinks($GLOBALS['alternateMode']); ?>
            <p class="username-checkout-nav"><?= htmlspecialchars(fetchUsername($_SESSION['email'])); ?>
            </p>
            <img class="burger-button invisibility nav-mobile" alt="burger menu icon" src="/assets/burger_icon.svg" />

        </div>
    </div>
    <div class="bottom-nav">
        <?= renderNavLinksResponsive($GLOBALS['alternateMode']); ?>
    </div>
    <?php endif; ?>
</nav>

<main>
<h1><?php echo htmlspecialchars($car['brand']) . " " . htmlspecialchars($car['model']); ?></h1>
<p>Segment: <?php echo htmlspecialchars($car['segment']); ?></p>
<p>Fuel Type: <?php echo htmlspecialchars($car['fuel_type']); ?></p>
<p>Year: <?php echo htmlspecialchars($car['year_from']); ?></p>
<p>KM: <?php echo htmlspecialchars($car['km']); ?></p>
<p>Price per day: X</p>
</main>
</body>
</html>
