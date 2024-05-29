<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $driverID = $_POST['driverID'];
    $trainingDescription = $_POST['trainingDescription'];

    $sql = "INSERT INTO DriverTraining (DriverID, TrainingDescription) VALUES ('$driverID', '$trainingDescription')";
    if ($conn->query($sql) === TRUE) {
        echo "New training record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM DriverTraining");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Training</title>
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
    <h1>Driver Training</h1>
    <form method="post">
        <input type="text" name="driverID" placeholder="Driver ID" required>
        <textarea name="trainingDescription" placeholder="Training Description" required></textarea>
        <button type="submit">Add Training</button>
    </form>
    <h2>Training List</h2>
    <table>
        <tr>
            <th>Training ID</th>
            <th>Driver ID</th>
            <th>Training Description</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['TrainingID']; ?></td>
            <td><?php echo $row['DriverID']; ?></td>
            <td><?php echo $row['TrainingDescription']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
