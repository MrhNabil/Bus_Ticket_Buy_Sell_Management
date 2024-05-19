<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Buy Sell Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to Ticket Buy Sell Management</h1>
        <nav>
            <ul>
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="passengers.php">Passengers</a></li>
                    <li><a href="drivers.php">Drivers</a></li>
                    <li><a href="buses.php">Buses</a></li>
                    <li><a href="routes.php">Routes</a></li>
                    <li><a href="schedules.php">Schedules</a></li>
                    <li><a href="tickets.php">Tickets</a></li>
                    <li><a href="bookings.php">Bookings</a></li>
                    <li><a href="driver_training.php">Driver Training</a></li>
                    <li><a href="travel_cards.php">Travel Cards</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <img src="photos/background.jpg" alt="background image">
</body>
</html>
