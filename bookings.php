<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $busNumber = $_POST['busNumber'];
    $seat = $_POST['seat'];
    $bookedBy = $_POST['bookedBy'];
    $bookingTime = $_POST['bookingTime'];
    $expiryTime = $_POST['expiryTime'];

    $sql = "INSERT INTO Bookings (BusNumber, Seat, BookedBy, BookingTime, ExpiryTime) 
            VALUES ('$busNumber', '$seat', '$bookedBy', '$bookingTime', '$expiryTime')";
    if ($conn->query($sql) === TRUE) {
        echo "New booking created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM Bookings");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
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
            </ul>
        </nav>
    </header>  
    <h1>Bookings</h1>
    <form method="post">
        <input type="text" name="busNumber" placeholder="Bus Number" required>
        <input type="text" name="seat" placeholder="Seat" required>
        <input type="text" name="bookedBy" placeholder="Booked By (Passenger ID)" required>
        <label for="bookingTime">Booking Time:</label>
        <input type="datetime-local" name="bookingTime" placeholder="Booking Time" required>
        <label for="expiryTime">Expiry Time:</label>
        <input type="datetime-local" name="expiryTime" placeholder="Expiry Time" required>
        <button type="submit">Add Booking</button>
    </form>
    <h2>Booking List</h2>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>Bus Number</th>
            <th>Seat</th>
            <th>Booked By</th>
            <th>Booking Time</th>
            <th>Expiry Time</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['BookingID']; ?></td>
            <td><?php echo $row['BusNumber']; ?></td>
            <td><?php echo $row['Seat']; ?></td>
            <td><?php echo $row['BookedBy']; ?></td>
            <td><?php echo $row['BookingTime']; ?></td>
            <td><?php echo $row['ExpiryTime']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
