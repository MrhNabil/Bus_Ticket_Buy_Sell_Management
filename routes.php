<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $routeNumber = $_POST['routeNumber'];
        $startingPoint = $_POST['startingPoint'];
        $destination = $_POST['destination'];
        $distanceCovered = $_POST['distanceCovered'];

        $sql = "UPDATE BusRoutes SET StartingPoint='$startingPoint', Destination='$destination', DistanceCovered='$distanceCovered' WHERE RouteNumber='$routeNumber'";
        if ($conn->query($sql) === TRUE) {
            echo "Route updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else if (isset($_POST['delete'])) {
        $routeNumber = $_POST['routeNumber'];

        $sql = "DELETE FROM BusRoutes WHERE RouteNumber='$routeNumber'";
        if ($conn->query($sql) === TRUE) {
            echo "Route deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $startingPoint = $_POST['startingPoint'];
        $destination = $_POST['destination'];
        $distanceCovered = $_POST['distanceCovered'];

        $sql = "INSERT INTO BusRoutes (StartingPoint, Destination, DistanceCovered) 
                VALUES ('$startingPoint', '$destination', '$distanceCovered')";
        if ($conn->query($sql) === TRUE) {
            echo "New route created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$result = $conn->query("SELECT * FROM BusRoutes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Routes</title>
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
                <li><a href="schedules.php">Schedules</a></li>
                <li><a href="tickets.php">Tickets</a></li>
                <li><a href="bookings.php">Bookings</a></li>
                <li><a href="driver_training.php">Driver Training</a></li>
                <li><a href="travel_cards.php">Travel Cards</a></li>
            </ul>
        </nav>
    </header>
    <h1>Routes</h1>
    <form method="post">
        <input type="hidden" name="routeNumber" id="routeNumber">
        <input type="text" name="startingPoint" id="startingPoint" placeholder="Starting Point" required>
        <input type="text" name="destination" id="destination" placeholder="Destination" required>
        <input type="text" name="distanceCovered" id="distanceCovered" placeholder="Distance Covered" required>
        <button type="submit">Add Route</button>
        <button type="submit" name="update">Update Route</button>
    </form>
    <h2>Route List</h2>
    <table>
        <tr>
            <th>Route Number</th>
            <th>Starting Point</th>
            <th>Destination</th>
            <th>Distance Covered</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['RouteNumber']; ?></td>
            <td><?php echo $row['StartingPoint']; ?></td>
            <td><?php echo $row['Destination']; ?></td>
            <td><?php echo $row['DistanceCovered']; ?></td>
            <td>
                <button onclick="editRoute(<?php echo $row['RouteNumber']; ?>, '<?php echo $row['StartingPoint']; ?>', '<?php echo $row['Destination']; ?>', '<?php echo $row['DistanceCovered']; ?>')">Edit</button>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="routeNumber" value="<?php echo $row['RouteNumber']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        function editRoute(routeNumber, startingPoint, destination, distanceCovered) {
            document.getElementById('routeNumber').value = routeNumber;
            document.getElementById('startingPoint').value = startingPoint;
            document.getElementById('destination').value = destination;
            document.getElementById('distanceCovered').value = distanceCovered;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
