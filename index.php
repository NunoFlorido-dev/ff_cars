<?php
global $connection;

use PgSql\Result;

session_start();
include("auth/connection.php");
include("php/definemode.php");
include("php/userinfo.php");
include("php/stats.php");
include("php/pageitems.php");
include("php/carinfo.php");

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

function getVariableData($connection, $values): Result|false|null
{

    if (empty($values)) {
        $query = "SELECT * FROM car_variables";
    } else {
        $query = "SELECT price_per_day FROM car_variables WHERE brand = '$values'";
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
        <link rel="stylesheet" href="assets/css/nav.css">
        <link rel="stylesheet" href="assets/css/index.css">
        <link href="https://fonts.cdnfonts.com/css/zt-talk" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">
        <title>FF.Cars | Homepage</title>
    </head>
    <body>
    <nav>
        <div class="top-nav">
            <a class="homepage-link-nav" href="index.php"><img alt="ff.cars logotype" src="assets/icons/ff_cars_logo.svg" /></a>
            <?php if (isset($_SESSION['username'])): ?>
            <div class="nav-right-container">
                <?= renderNavLinks($GLOBALS['alternateMode']); ?>
                <p class="username-checkout-nav"><?= htmlspecialchars(fetchUsername($_SESSION['email'])); ?>
                </p>
                <img class="burger-button invisibility nav-mobile" alt="burger menu icon" src="assets/icons/burger_icon.svg" />

            </div>
        </div>
        <div class="bottom-nav">
            <?= renderNavLinksResponsive($GLOBALS['alternateMode']); ?>
        </div>
        <?php endif; ?>
    </nav>

    <p class="title">Find the best cars to rent!</p>

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

    <div class="car_list">
        <?php
        function extracted($rows): void
        {
            $license_plate = htmlspecialchars($rows['license_plate']);
            $model = htmlspecialchars($rows['model']);
            $brand = htmlspecialchars($rows['brand']);
            $segment = htmlspecialchars($rows['segment']);
            $fuel_type = htmlspecialchars($rows['fuel_type']);
            $year_from = htmlspecialchars($rows['year_from']);
            $km = htmlspecialchars($rows['km']);
            $price = fetchCarPrice($license_plate); // Fetch the price
            echo "
           <a href='pages/carpage.php?license_plate=$license_plate'>
                    <div class='car_list_part'>
                        <div class='img_wrapper'>Imagem</div>
                        <p class='car_name' >$brand $segment $model</p>
                        <div class='car_info'>
                            <p>$year_from</p>
                            <p>•</p>
                            <p>$km</p>
                            <p>•</p>
                            <p>$fuel_type</p>
                        </div>
                        <p class='car-price'>$price €</p>
                    </div>
                    </a>";
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
    </div>

    <form method ="post" class="car_list_page">
        <button type = "submit" name="button1" <?php if($_SESSION["page"]==0){?>disabled<?php }?> class="car_list_page_button">
            <img src="/assets/icons/ff_cars_left_arrow.svg" alt="left_arrow" />
        </button>
        <p><?php echo $_SESSION["page"]+1 ?></p>
        <button type="submit" name="button2" <?php if($rows != null){if(count($rows) <= $_SESSION["page"]*4+4){?>disabled<?php }}else{?>disabled<?php }?> class="car_list_page_button">
            <img src="/assets/icons/ff_cars_right_arrow.svg" alt="right_arrow" />
        </button>
    </form>

    <script src="assets/js/nav.js"></script>
    </body>
<?php


pg_close($connection);
?>
</html>
