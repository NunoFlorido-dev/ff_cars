<?php
session_start();
include("../auth/connection.php");
include("../php/definemode.php");
include("../php/userinfo.php");
include("../php/stats.php");
include("../php/pageitems.php");
include("../php/carinfo.php");

$license_plate = $_POST['license_plate'] ?? null;

$email = $_SESSION['email'];

// Only call updateValues() if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['license_plate_change'])) {
    updateValues();
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/nav.css">
    <link rel="stylesheet" href="../assets/css/car_form.css">
    <title>FF.Cars | Car Form</title>
</head>
<body>
<nav>
    <div class="top-nav">
        <a class="homepage-link-nav" href="../index.php"><img alt="ff.cars logotype" src="/assets/icons/ff_cars_logo.svg" /></a>
        <?php if (isset($_SESSION['username'])): ?>
        <div class="nav-right-container">
            <?= renderNavLinksWithin($GLOBALS['alternateMode']); ?>
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
            <img class="car_image" alt="car image" src="" />
        </div>
        <div class="right-part">
            <form method="POST" action="<?= $_SERVER['PHP_SELF'];  ?>">
                <label for="license_plate_change">License Plate:</label>
                <input type="text" name="license_plate_change" id="license_plate_change" value="<?= htmlspecialchars($license_plate ?? '') ?>">

                <label for="brand_change">Brand:</label>
                <input type="text" name="brand_change" id="brand_change" value="<?= getCarDetail('brand') ?>">

                <label for="model_change">Model:</label>
                <input type="text" name="model_change" id="model_change" value="<?= getCarDetail('model') ?>">

                <label for="segment_change">Segment:</label>
                <input type="text" name="segment_change" id="segment_change" value="<?= getCarDetail('segment') ?>">

                <label for="fuel_type_change">Fuel Type:</label>
                <input type="text" name="fuel_type_change" id="fuel_type_change" value="<?= getCarDetail('fuel_type') ?>">

                <label for="seats_change">Seats:</label>
                <input type="number" name="seats_change" id="seats_change" value="<?= getCarDetail('seats') ?>">

                <label for="year_change">Year:</label>
                <input type="number" name="year_change" id="year_change" value="<?= getCarDetail('year_from') ?>">

                <label for="gearshift_change">Gearshift:</label>
                <input type="text" name="gearshift_change" id="gearshift_change" value="<?= getCarDetail('gearshift') ?>">

                <label for="km_change">KM:</label>
                <input type="number" name="km_change" id="km_change" value="<?= getCarDetail('km') ?>">

                <label for="cv_change">CV:</label>
                <input type="number" name="cv_change" id="cv_change" value="<?= getCarDetail('cv') ?>">

                <label for="price_per_day_change">Price per Day:</label>
                <input type="number" name="price_per_day_change" id="price_per_day_change" value="<?= getVariableDetail('price_per_day') ?>">

                <label for="availability_change">Availability:</label>
                <input type="checkbox" name="availability_change" id="availability_change" <?= getVariableDetail('availability') == 't' ? 'checked' : '' ?>>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</main>

</body>
<script src="../assets/js/nav.js"></script>
<script src="../assets/js/carimages.js"></script>
</html>