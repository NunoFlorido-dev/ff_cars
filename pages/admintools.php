<?php
include("../php/definemode.php");
include("../php/userinfo.php");
include("../php/stats.php");
include("../php/pageitems.php");

global $connection;

use PgSql\Result;

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

function getCombinedData($connection, $values, $type = 'car'): ?Result
{
    $sortField = $_GET['sort'] ?? null;
    $allowedSortFields = ['segment', 'km', 'seats', 'year_from', 'gearshift', 'model', 'fuel_type', 'brand'];

    // Base query based on type ('car' or 'car_variables')
    if ($type === 'car') {
        $query = empty($values) ? "SELECT * FROM car" : "SELECT * FROM car WHERE brand = $1";
    } elseif ($type === 'car_variables') {
        $query = empty($values) ? "SELECT * FROM car_variables" : "SELECT price_per_day FROM car_variables WHERE car_license_plate IN (SELECT license_plate FROM car WHERE brand = $1)";
    } else {
        echo "Invalid query type specified.";
        return null;
    }

    // Add sorting for 'car' data
    if ($type === 'car' && $sortField && in_array($sortField, $allowedSortFields)) {
        $query .= " ORDER BY $sortField ASC";
    }

    try {
        // Use parameters only if $values is set
        return empty($values) ? pg_query($connection, $query) : pg_query_params($connection, $query, [$values]);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    return null;
}

// Fetch data from the 'car' table
$carResults = getCombinedData($connection, $values, 'car');
if ($carResults && pg_num_rows($carResults) > 0) {
    $rows = pg_fetch_all($carResults);
}

// Fetch data from the 'car_variables' table
$carVariableResults = getCombinedData($connection, $variableValues, 'car_variables');
if ($carVariableResults && pg_num_rows($carVariableResults) > 0) {
    $varRows = pg_fetch_all($carVariableResults);
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
    </div>

    <div class="cars-page-cont">
        <div class="search">
            <form class="search_top" action= "<?php ?>" method="GET">

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

        <div class="list-container">

            <?php

            function extracted($rows): void
            {
                $license_plate = htmlspecialchars($rows['license_plate']);
                $change_date = fetchChangeDate($license_plate); // Fetch the change date using the function

                echo "<div class='cartool_container'>
    <div class='cartool_item'>
        <img alt='car image' />
        <p class='car_plate'>$license_plate</p>
        <p class='car_change'>" . htmlspecialchars($change_date) . "</p> 
        <div class='car_info'>
   
           <button><img src='../assets/icons/see.svg' alt='View details' /></button>
           
                      <a href='carpage.php?license_plate=$license_plate'>
 <img src='../assets/icons/arrow.svg' alt='Edit car' /></a> 
 </a>
        </div>
    </div>
</a>
</div>";
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


</body>
</html>
