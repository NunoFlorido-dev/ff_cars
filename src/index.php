<?php
session_start();
include("php/definemode.php");
include("php/userinfo.php");
include("php/gentools.php");
include("php/nav.php");

if(!isset($_SESSION["page"])){
    $_SESSION["page"] = 0;
}

if(isset($_POST['button1'])){
    $_SESSION["page"]--;
}elseif (isset($_POST['button2'])){
    $_SESSION["page"]++;
}

$values = isset($_GET['search']) ? $_GET['search'] : null;
$rows = null;

$connection = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres");

function getData($connection, $values){

    if(empty($values)) {

        $query = "SELECT * FROM car";
        try {
            return pg_query($connection, $query);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }else{
        $query = "SELECT * FROM car WHERE brand = '$values'";

        try {
            return pg_query($connection, $query);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    return null;

}
$values = getData($connection, $values);
if(pg_num_rows($values) > 0){
    $rows = pg_fetch_all($values);
}


?>

    <style>
        <?php include 'index.css'; ?>
        <?php include 'css/nav.css'; ?>
    </style>


    <body>

    <nav>
        <div class="top-nav">
            <a class="homepage-link-nav" href="index.php"><img alt="ff.cars logotype" src="../assets/ff_cars_logo.svg" /></a>
            <?php if (isset($_SESSION['username'])): ?>
            <div class="nav-right-container">
                <?= renderNavLinks($GLOBALS['alternateMode']); ?>
                <p class="username-checkout-nav"><?= htmlspecialchars(fetchUsername($_SESSION['email'])); ?>
                </p>
                <img class="burger-button invisibility nav-mobile" alt="burger menu icon" src="../assets/burger_icon.svg" />

            </div>
        </div>
        <div class="bottom-nav">
            <?= renderNavLinksResponsive($GLOBALS['alternateMode']); ?>
        </div>
        <?php endif; ?>
    </nav>

    <p class="title">Find the best cars to rent!</p>

    <div class="search">
        <form class="search_top" action= "<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="get">
            <input class="search_top_textinput" type="text" id="name" name="search" placeholder="Search car..."/>
            <div>
                <button class="search_top_button" type="submit">.</button>
                <button class="search_top_button">-</button>
            </div>
        </form>
        <div class="search_bottom">
            <button class="search_bottom_button">Segment</button>
            <button class="search_bottom_button">KM</button>
            <button class="search_bottom_button">NºSeats</button>
            <button class="search_bottom_button">Year</button>
            <button class="search_bottom_button">Gearshift</button>
        </div>
        <div class="search_bottom">
            <button class="search_bottom_button">Model</button>
            <button class="search_bottom_button">Fuel Type</button>
            <button class="search_bottom_button">Brand</button>
        </div>
    </div>

    <div class="car_list">
        <?php
        function extracted($rows)
        {
            $text = htmlspecialchars($rows['license_plate']);
            $model = htmlspecialchars($rows['model']);
            $brand = htmlspecialchars($rows['brand']);
            $fuel_type = htmlspecialchars($rows['fuel_type']);
            $year_from = htmlspecialchars($rows['year_from']);
            $km = htmlspecialchars($rows['km']);
            echo "
                    <div class='car_list_part'>
                        <div class='img_wrapper'>Imagem</div>
                        <p class='car_name' >$brand $model</p>
                        <div class='car_info'>
                            <p>year_from&nbsp;</p>
                            <p>km&nbsp;</p>
                            <p>fuel_type&nbsp;</p>
                            <p>text</p>
                        </div>
                        <p>X / day</p>
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
    </div>

    <form method ="post" class="car_list_page">
        <button type = "submit" name="button1" <?php if($_SESSION["page"]==0){?>disabled<?php }?> class="car_list_page_button">-</button>
        <p><?php echo $_SESSION["page"]+1 ?></p>
        <button type="submit" name="button2" <?php if($rows != null){if(count($rows) <= $_SESSION["page"]*4+4){?>disabled<?php }}else{?>disabled<?php }?> class="car_list_page_button">-</button>
    </form>

    <script src="js/nav.js"></script>
    </body>
<?php


pg_close($connection);
?>