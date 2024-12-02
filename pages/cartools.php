<?php
session_start();
include("../auth/connection.php");
include("../php/nav.php");
include("../php/userinfo.php");
include("../php/carpage_var.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/nav.css">
    <link rel="stylesheet" href="../assets/css/cartools.css">
    <link href="https://fonts.cdnfonts.com/css/zt-talk" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">
    <title>FF.Cars | Car Tools</title>
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
    <div class="select-page">
        <button id="general-page">General</button>
        <button id="cars-page">Cars</button>
    </div>

    <div class="search">
        <form class="search_top" action= "<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="GET">

            <label for="name"></label>
            <input class="search_top_textinput" type="text" id="name" name="search" placeholder="Search car..."
                   value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" />
            <input type="hidden" name="sort" value="<?php echo htmlspecialchars($_GET['sort'] ?? ''); ?>" />

            <div>
                <button class="search_top_button search-icon" type="submit">
                    <img src="/assets/icons/search_icon.svg" alt="search icon" />
                </button>
            </div>

        </form>

        <div class="search_bottom">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
                <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" />
                <button class="search_bottom_button segment-button <?php echo $currentSort === 'segment' ? 'active' : ''; ?>" name="sort" value="segment">Segment</button>
                <button class="search_bottom_button km-button <?php echo $currentSort === 'km' ? 'active' : ''; ?>" name="sort" value="km">KM</button>
                <button class="search_bottom_button seats-button <?php echo $currentSort === 'seats' ? 'active' : ''; ?>" name="sort" value="seats">NºSeats</button>
                <button class="search_bottom_button year-button <?php echo $currentSort === 'year_from' ? 'active' : ''; ?>" name="sort" value="year_from">Year</button>
                <button class="search_bottom_button gearshift-button <?php echo $currentSort === 'gearshift' ? 'active' : ''; ?>" name="sort" value="gearshift">Gearshift</button>
                <button class="search_bottom_button model-button <?php echo $currentSort === 'model' ? 'active' : ''; ?>" name="sort" value="model">Model</button>
                <button class="search_bottom_button fuel-button <?php echo $currentSort === 'fuel_type' ? 'active' : ''; ?>" name="sort" value="fuel_type">Fuel Type</button>
                <button class="search_bottom_button brand-button <?php echo $currentSort === 'brand' ? 'active' : ''; ?>" name="sort" value="brand">Brand</button>
                <button class="search_bottom_button brand-button <?php echo $currentSort === 'cv' ? 'active' : ''; ?>" name="sort" value="brand">CV</button>

            </form>
        </div>

    </div>

    <div class ="add_button">

    </div>

    <div class="cartool_container">
        <?php
        $licenseplate = "P1-33-5D";
        $lastChange = "26/10/2024";
        $admin = "admin";
        for ($i = 0; $i < 4; $i++): ?>
        <div class="cartool_item">
            <div class="img_wrapper">Imagem</div>
            <p class="car_plate"><?= $licenseplate; ?></p>
            <p class="car_change">Last change: <?= $lastChange; ?> by <?= $admin; ?></p>
            <div class="car_info">
                <button><img src="/assets/icons/see.svg" alt="View details" /></button>
                <button><img src="/assets/icons/Seta.svg" alt="Edit car" /></button>
            </div>
        </div>
  <?php endfor; ?>

    </div>
</main>

</body>
</html>
