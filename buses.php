<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $busNumber = $_POST['busNumber'];
        $seatingCapacity = $_POST['seatingCapacity'];
        $model = $_POST['model'];
        $driverID = $_POST['driverID'];

        $sql = "UPDATE Buses SET SeatingCapacity='$seatingCapacity', Model='$model', DriverID='$driverID' WHERE BusNumber='$busNumber'";
        if ($conn->query($sql) === TRUE) {
            echo "Bus updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else if (isset($_POST['delete'])) {
        $busNumber = $_POST['busNumber'];

        $sql = "DELETE FROM Buses WHERE BusNumber='$busNumber'";
        if ($conn->query($sql) === TRUE) {
            echo "Bus deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $seatingCapacity = $_POST['seatingCapacity'];
        $model = $_POST['model'];
        $driverID = $_POST['driverID'];

        $sql = "INSERT INTO Buses (SeatingCapacity, Model, DriverID) 
                VALUES ('$seatingCapacity', '$model', '$driverID')";
        if ($conn->query($sql) === TRUE) {
            echo "New bus created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$result = $conn->query("SELECT * FROM Buses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buses</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="passengers.php">Passengers</a></li>
                <li><a href="drivers.php">Drivers</a></li>
                <li><a href="routes.php">Routes</a></li>
                <li><a href="schedules.php">Schedules</a></li>
                <li><a href="tickets.php">Tickets</a></li>
                <li><a href="bookings.php">Bookings</a></li>
                <li><a href="driver_training.php">Driver Training</a></li>
                <li><a href="travel_cards.php">Travel Cards</a></li>
            </ul>
        </nav>   
    </header> 
    <h1>Buses</h1>
    <form method="post">
        <input type="hidden" name="busNumber" id="busNumber">
        <input type="text" name="seatingCapacity" id="seatingCapacity" placeholder="Seating Capacity" required>
        <input type="text" name="model" id="model" placeholder="Model" required>
        <input type="text" name="driverID" id="driverID" placeholder="Driver ID" required>
        <button type="submit">Add Bus</button>
        <button type="submit" name="update">Update Bus</button>
    </form>
    <h2>Bus List</h2>
    <table>
        <tr>
            <th>Bus Number</th>
            <th>Seating Capacity</th>
            <th>Model</th>
            <th>Driver ID</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['BusNumber']; ?></td>
            <td><?php echo $row['SeatingCapacity']; ?></td>
            <td><?php echo $row['Model']; ?></td>
            <td><?php echo $row['DriverID']; ?></td>
            <td>
                <button onclick="editBus(<?php echo $row['BusNumber']; ?>, '<?php echo $row['SeatingCapacity']; ?>', '<?php echo $row['Model']; ?>', '<?php echo $row['DriverID']; ?>')">Edit</button>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="busNumber" value="<?php echo $row['BusNumber']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        function editBus(busNumber, seatingCapacity, model, driverID) {
            document.getElementById('busNumber').value = busNumber;
            document.getElementById('seatingCapacity').value = seatingCapacity;
            document.getElementById('model').value = model;
            document.getElementById('driverID').value = driverID;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
