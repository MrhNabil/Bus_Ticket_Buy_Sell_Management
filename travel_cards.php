<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passengerID = $_POST['passengerID'];
    $travelFrom = $_POST['travelFrom'];
    $travelTo = $_POST['travelTo'];
    $cost = $_POST['cost'];
    $balance = $_POST['balance'];

    $sql = "INSERT INTO TravelCards (PassengerID, TravelFrom, TravelTo, Cost, Balance) 
            VALUES ('$passengerID', '$travelFrom', '$travelTo', '$cost', '$balance')";
    if ($conn->query($sql) === TRUE) {
        echo "New travel card created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM TravelCards");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Cards</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="passengers.php">Passengers</a></li>
                <li><a href="drivers.php">Drivers</a></li>
                <li><a href="buses.php">Buses</a></li>
                <li><a href="routes.php">Routes</a></li>
                <li><a href="schedules.php">Schedules</a></li>
                <li><a href="tickets.php">Tickets</a></li>
                <li><a href="bookings.php">Bookings</a></li>
                <li><a href="driver_training.php">Driver Training</a></li>
            </ul>
        </nav>  
    </header>      
    <h1>Travel Cards</h1>
    <form method="post">
        <input type="text" name="passengerID" placeholder="Passenger ID" required>
        <input type="text" name="travelFrom" placeholder="Travel From" required>
        <input type="text" name="travelTo" placeholder="Travel To" required>
        <input type="text" name="cost" placeholder="Cost" required>
        <input type="text" name="balance" placeholder="Balance" required>
        <button type="submit">Add Travel Card</button>
    </form>
    <h2>Travel Card List</h2>
    <table>
        <tr>
            <th>Card Number</th>
            <th>Passenger ID</th>
            <th>Travel From</th>
            <th>Travel To</th>
            <th>Cost</th>
            <th>Balance</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['CardNumber']; ?></td>
            <td><?php echo $row['PassengerID']; ?></td>
            <td><?php echo $row['TravelFrom']; ?></td>
            <td><?php echo $row['TravelTo']; ?></td>
            <td><?php echo $row['Cost']; ?></td>
            <td><?php echo $row['Balance']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
