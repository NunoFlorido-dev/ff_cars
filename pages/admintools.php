<?php
global $connection;

use PgSql\Result;

session_start();
include("../auth/connection.php");
include("../php/definemode.php");
include("../php/pageitems.php");
include("../php/userinfo.php");
include("../php/carinfo.php");
include("../php/stats.php");


if(!isset($_SESSION["page"])){
    $_SESSION["page"] = 0;
}

if(isset($_POST['button1'])){
    $_SESSION["page"]--;
}elseif (isset($_POST['button2'])){
    $_SESSION["page"]++;
}

$values = $_GET['search'] ?? null;
$variableValues = $_GET['search'] ?? null;
$rows = null;
$varRows = null;

function getData($connection, $values): Result|false|null
{
    $sortField = $_GET['sort'] ?? null;
    $allowedSortFields = ['segment', 'km', 'seats', 'year_from', 'gearshift', 'model', 'fuel_type', 'brand'];

    if (empty($values)) {
        $query = "SELECT * FROM car";
    } else {
        $query = "SELECT * FROM car WHERE brand = '$values'";
    }

    if ($sortField && in_array($sortField, $allowedSortFields)) {
        $query .= " ORDER BY $sortField ASC";
    }

    try {
        return pg_query($connection, $query);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    return null;
}


$values = getData($connection, $values);
if(pg_num_rows($values) > 0){
    $rows = pg_fetch_all($values);
}

$variableValues = getData($connection, $variableValues);
if(pg_num_rows($variableValues) > 0){
    $varRows = pg_fetch_all($variableValues);
}

$currentSort = $_GET['sort'] ?? null;



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/nav.css">
    <link rel="stylesheet" href="../assets/css/admintools.css">
    <link href="https://fonts.cdnfonts.com/css/zt-talk" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">

    <title>FF.Cars | Admin Tools</title>
</head>
<body>
<nav>
    <div class="top-nav">
        <a class="homepage-link-nav" href="../index.php"><img alt="ff.cars logotype" src="../assets/icons/ff_cars_logo.svg" /></a>
        <?php if (isset($_SESSION['username'])): ?>
        <div class="nav-right-container">
            <?= renderNavLinksWithin($GLOBALS['alternateMode']); ?>
            <p class="username-checkout-nav"><?= htmlspecialchars(fetchUsername($_SESSION['email'])); ?>
            </p>
            <img class="burger-button invisibility nav-mobile" alt="burger menu icon" src="../assets/icons/burger_icon.svg" />

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

    <div class="general-page-cont">
        <div class="total-cars">
            <h2>Total Number of Cars</h2>
            <?= fetchTotalCarNumber(); ?>
        </div>

        <div class="total-users">
            <h2>Total Number of Users</h2>
            <?= fetchTotalUserNumber(); ?>
        </div>

        <div class="average-car-price">
            <h2>Average Car Price</h2>
            <?= getAverageCarPrice(); ?> €
        </div>

        <div class="average-car-price">
            <h2>Total Number of Tickets</h2>
            <?= getTotalOfTickets(); ?>
        </div>
    </div>

    <div class="cars-page-cont">


        <div class="search">
            <form class="search_top" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
                <label for="name"></label>
                <input class="search_top_textinput" type="text" id="name" name="search" placeholder="Search car..."
                       value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" />
                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($_GET['sort'] ?? ''); ?>" />

                <!-- This toggles the sorting order -->
                <input type="hidden" name="order" value="<?php echo (($_GET['order'] ?? 'ASC') === 'ASC') ? 'DESC' : 'ASC'; ?>" />

                <div class="search_buttons">
                    <button class="search_top_button search-icon" type="submit">
                        <img src="/assets/icons/search_icon.svg" alt="search icon" />
                    </button>
                </div>
            </form>

            <div class="search_bottom">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" />
                    <input type="hidden" name="order" value="<?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? 'DESC' : 'ASC'; ?>" />

                    <!-- Segment Button -->
                    <button class="search_bottom_button segment-button <?php echo $currentSort === 'segment' ? 'active' : ''; ?>"
                            name="sort" value="segment">
                        Segment
                        <?php if ($currentSort === 'segment') { ?>
                            <span><?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? '↑' : '↓'; ?></span>
                        <?php } ?>
                    </button>

                    <!-- KM Button -->
                    <button class="search_bottom_button km-button <?php echo $currentSort === 'km' ? 'active' : ''; ?>"
                            name="sort" value="km">
                        KM
                        <?php if ($currentSort === 'km') { ?>
                            <span><?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? '↑' : '↓'; ?></span>
                        <?php } ?>
                    </button>

                    <!-- Seats Button -->
                    <button class="search_bottom_button seats-button <?php echo $currentSort === 'seats' ? 'active' : ''; ?>"
                            name="sort" value="seats">
                        Nº Seats
                        <?php if ($currentSort === 'seats') { ?>
                            <span><?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? '↑' : '↓'; ?></span>
                        <?php } ?>
                    </button>

                    <!-- Year Button -->
                    <button class="search_bottom_button year-button <?php echo $currentSort === 'year_from' ? 'active' : ''; ?>"
                            name="sort" value="year_from">
                        Year
                        <?php if ($currentSort === 'year_from') { ?>
                            <span><?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? '↑' : '↓'; ?></span>
                        <?php } ?>
                    </button>

                    <!-- Gearshift Button -->
                    <button class="search_bottom_button gearshift-button <?php echo $currentSort === 'gearshift' ? 'active' : ''; ?>"
                            name="sort" value="gearshift">
                        Gearshift
                        <?php if ($currentSort === 'gearshift') { ?>
                            <span><?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? '↑' : '↓'; ?></span>
                        <?php } ?>
                    </button>

                    <!-- Model Button -->
                    <button class="search_bottom_button model-button <?php echo $currentSort === 'model' ? 'active' : ''; ?>"
                            name="sort" value="model">
                        Model
                        <?php if ($currentSort === 'model') { ?>
                            <span><?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? '↑' : '↓'; ?></span>
                        <?php } ?>
                    </button>

                    <!-- Fuel Type Button -->
                    <button class="search_bottom_button fuel-button <?php echo $currentSort === 'fuel_type' ? 'active' : ''; ?>"
                            name="sort" value="fuel_type">
                        Fuel Type
                        <?php if ($currentSort === 'fuel_type') { ?>
                            <span><?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? '↑' : '↓'; ?></span>
                        <?php } ?>
                    </button>

                    <!-- CV Button -->
                    <button class="search_bottom_button cv-button <?php echo $currentSort === 'cv' ? 'active' : ''; ?>"
                            name="sort" value="cv">
                        CV
                        <?php if ($currentSort === 'cv') { ?>
                            <span><?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? '↑' : '↓'; ?></span>
                        <?php } ?>
                    </button>

                    <!-- Brand Button -->
                    <button class="search_bottom_button brand-button <?php echo $currentSort === 'brand' ? 'active' : ''; ?>"
                            name="sort" value="brand">
                        Brand
                        <?php if ($currentSort === 'brand') { ?>
                            <span><?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? '↑' : '↓'; ?></span>
                        <?php } ?>
                    </button>
                </form>
            </div>


        </div>
        <a href="addcar.php" class ="add_button">
          <button><img src="../assets/icons/plus_icon.svg" alt="plus icon"></button>
        </a>

        <div class="list-container">

            <?php

            function extracted($rows): void
            {
                $license_plate = htmlspecialchars($rows['license_plate']);
                $change_date = fetchChangeDate($license_plate); // Fetch the change date using the function

              if($license_plate && $change_date) {
                  echo "<div class='cartool_container'>
        <div class='cartool_item'>
           <div class='image_container'><img alt='car image' class='car_image' /></div>
            <p class='car_plate'>" . htmlspecialchars($license_plate) . "</p>
            <p class='car_change'>" . htmlspecialchars($change_date) . "</p> 
            <div class='car_info'>
                
                <a href='carpage.php?license_plate=" . urlencode($license_plate) . "'>
                    <img src='../assets/icons/arrow.svg' alt='Edit car' />
                </a>
            </div>
        </div>
    </div>";
              }else{
                  echo "<div class='cartool_container'>
        <div class='cartool_item' class='car_image'>
           <div class='image_container'><img alt='car image' class='car_image' /></div>
            <p class='car_plate'>" . htmlspecialchars($license_plate) . "</p>
            <div class='car_info'>
                
                <a href='carpage.php?license_plate=" . urlencode($license_plate) . "'>
                    <img src='../assets/icons/arrow.svg' alt='Edit car' />
                </a>
            </div>
        </div>
    </div>";
              }
            }

            if($values != null) {
                if (pg_num_rows($values) > 0) {
                    if (count($rows) >= $_SESSION["page"] * 4 + 4) {
                        for ($i = $_SESSION["page"] * 4; $i < $_SESSION["page"] * 4 + 4; $i++) {
                            extracted($rows[$i]);
                        }
                    } else {
                        for ($i = $_SESSION["page"] * 4; $i < count($rows); $i++) {
                            extracted($rows[$i]);
                        }
                    }

                } else {
                    echo "<p>No cars found for this search</p>";
                }
            }
            ?>
            <form method ="post" class="car_list_page">
                <button type = "submit" name="button1" <?php if($_SESSION["page"]==0){?>disabled<?php }?> class="car_list_page_button">
                    <img src="/assets/icons/ff_cars_left_arrow.svg" alt="left_arrow" />
                </button>
                <p><?php echo $_SESSION["page"]+1 ?></p>
                <button type="submit" name="button2" <?php if($rows != null){if(count($rows) <= $_SESSION["page"]*4+4){?>disabled<?php }}else{?>disabled<?php }?> class="car_list_page_button">
                    <img src="/assets/icons/ff_cars_right_arrow.svg" alt="right_arrow" />
                </button>
            </form>


        </div>
    </div>

</main>



<script src="../assets/js/nav.js"></script>
<script src="../assets/js/admintools.js"></script>
<script src="../assets/js/availablestyle.js"></script>
<script src="../assets/js/carimages.js"></script>


</body>
</html>