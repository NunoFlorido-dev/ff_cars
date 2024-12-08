<?php
session_start();
include("../auth/connection.php");
include("../php/definemode.php");
include("../php/userinfo.php");
include("../php/stats.php");
include("../php/pageitems.php");


$id = htmlspecialchars(fetchID($_SESSION['email']));

$ticket_query = "SELECT * FROM booking_ticket WHERE client_user_web_id = $1";
$tickets_result = pg_query_params($GLOBALS['connection'], $ticket_query, [$id]);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/nav.css">
    <link rel="stylesheet" href="../assets/css/user.css">
    <link href="https://fonts.cdnfonts.com/css/zt-talk" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">
    <title>FF.Cars | User</title>
</head>
<body>
<nav>
    <div class="top-nav">
        <a class="homepage-link-nav" href="../index.php"><img alt="ff.cars logotype" src="/assets/icons/ff_cars_logo.svg" /></a>
        <?php if (isset($_SESSION['username'])): ?>
        <div class="nav-right-container">
            <?= renderNavLinksWithin($GLOBALS['alternateMode']);
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

    <section class="user-info">
        <?php ?>
      <img alt="user icon" src="/assets/icons/user_icon.svg">

        <div class="username_cont">
            <h1>Username</h1>
            <p><?= htmlspecialchars(fetchUsername($_SESSION['email'])); ?></p>
        </div>

        <div class="email_cont">
            <h1>Email</h1>
            <p><?= $_SESSION['email'] ?></p>

        </div>

        <div class="password_cont">
            <h1>Password</h1>
            <p><?= $_SESSION['password'] ?></p>
        </div>

        <div class="id_cont">
            <h1>ID</h1>
            <p><?= $id ?></p>
        </div>

        <?= seeIFAdmin(); ?>

    </section>

    <section class="booking-info">
    </section>


    <?php if (!$GLOBALS['alternateMode']): ?>
        <section class="user-ticket-history">
            <h2 class="bookings">Bookings</h2>
            <?php if ($tickets_result && pg_num_rows($tickets_result) > 0): ?>
                <ul>
                    <?php while ($ticket = pg_fetch_assoc($tickets_result)): ?>
                        <li>
                            <strong>License Plate:</strong> <?php echo htmlspecialchars($ticket['car_license_plate']); ?><br>
                            <strong>Begin Time:</strong> <?php echo htmlspecialchars($ticket['begin_time']); ?><br>
                            <strong>End Time:</strong> <?php echo htmlspecialchars($ticket['end_time']); ?><br>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No tickets found for this user.</p>
            <?php endif; ?>
        </section>
    <?php endif; ?>


</main>


<script src="../assets/js/nav.js"></script>
</body>
</html>
