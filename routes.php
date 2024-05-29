<?php
include 'db.php';

// Define distances between locations
$distances = [
    'Dhaka-Chittagong' => 248,
    'Dhaka-Rajshahi' => 245,
    'Dhaka-Khulna' => 290,
    'Dhaka-Sylhet' => 238,
    'Dhaka-Barisal' => 169,
    'Dhaka-Rangpur' => 320,
    // Add more distances as needed
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startingPoint = isset($_POST['startingPoint']) ? $_POST['startingPoint'] : null;
    $destination = isset($_POST['destination']) ? $_POST['destination'] : null;
    $distanceCovered = isset($_POST['distanceCovered']) ? $_POST['distanceCovered'] : null;
    $driverID = isset($_POST['driverID']) ? $_POST['driverID'] : null;

    if ($startingPoint && $destination && $distanceCovered && $driverID) {
        // Check if DriverID exists
        $driverCheck = $conn->prepare("SELECT * FROM drivers WHERE DriverID = ?");
        $driverCheck->bind_param("i", $driverID);
        $driverCheck->execute();
        $driverCheckResult = $driverCheck->get_result();

        if ($driverCheckResult->num_rows == 0) {
            echo "Error: DriverID does not exist.";
        } else {
            if (isset($_POST['update'])) {
                $routeNumber = $_POST['routeNumber'];

                $sql = "UPDATE BusRoutes SET StartingPoint=?, Destination=?, DistanceCovered=?, DriverID=? WHERE RouteNumber=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssiii", $startingPoint, $destination, $distanceCovered, $driverID, $routeNumber);
                if ($stmt->execute() === TRUE) {
                    echo "Route updated successfully";
                } else {
                    echo "Error updating route: " . $stmt->error;
                }
            } else if (isset($_POST['delete'])) {
                $routeNumber = $_POST['routeNumber'];

                $sql = "DELETE FROM BusRoutes WHERE RouteNumber=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $routeNumber);
                if ($stmt->execute() === TRUE) {
                    echo "Route deleted successfully";
                } else {
                    echo "Error deleting route: " . $stmt->error;
                }
            } else {
                $sql = "INSERT INTO BusRoutes (StartingPoint, Destination, DistanceCovered, DriverID) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssii", $startingPoint, $destination, $distanceCovered, $driverID);
                if ($stmt->execute() === TRUE) {
                    echo "New route created successfully";
                } else {
                    echo "Error inserting new route: " . $stmt->error;
                }
            }
        }
        $driverCheck->close();
    } else {
        echo "Error: All fields are required.";
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
    <h1>Routes</h1>
    <form method="post">
        <input type="hidden" name="routeNumber" id="routeNumber">
        <select name="startingPoint" id="startingPoint" required onchange="calculateDistance()">
            <option value="">Select Starting Point</option>
            <option value="Dhaka">Dhaka</option>
            <option value="Chittagong">Chittagong</option>
            <option value="Rajshahi">Rajshahi</option>
            <option value="Khulna">Khulna</option>
            <option value="Sylhet">Sylhet</option>
            <option value="Barisal">Barisal</option>
            <option value="Rangpur">Rangpur</option>
            <!-- Add more locations as needed -->
        </select>
        <select name="destination" id="destination" required onchange="calculateDistance()">
            <option value="">Select Destination</option>
            <option value="Dhaka">Dhaka</option>
            <option value="Chittagong">Chittagong</option>
            <option value="Rajshahi">Rajshahi</option>
            <option value="Khulna">Khulna</option>
            <option value="Sylhet">Sylhet</option>
            <option value="Barisal">Barisal</option>
            <option value="Rangpur">Rangpur</option>
            <!-- Add more locations as needed -->
        </select>
        <input type="text" name="distanceCovered" id="distanceCovered" placeholder="Distance Covered" required readonly>
        <select name="driverID" id="driverID" required>
            <option value="">Select Driver</option>
            <?php
            $drivers = $conn->query("SELECT * FROM drivers");
            while ($driver = $drivers->fetch_assoc()) {
                echo "<option value='{$driver['DriverID']}'>{$driver['DriverName']}</option>";
            }
            ?>
        </select>
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
            <th>Driver ID</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['RouteNumber']; ?></td>
            <td><?php echo $row['StartingPoint']; ?></td>
            <td><?php echo $row['Destination']; ?></td>
            <td><?php echo $row['DistanceCovered']; ?></td>
            <td><?php echo $row['DriverID']; ?></td>
            <td>
                <button onclick="editRoute(<?php echo $row['RouteNumber']; ?>, '<?php echo $row['StartingPoint']; ?>', '<?php echo $row['Destination']; ?>', '<?php echo $row['DistanceCovered']; ?>', '<?php echo $row['DriverID']; ?>')">Edit</button>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="routeNumber" value="<?php echo $row['RouteNumber']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        const distances = <?php echo json_encode($distances); ?>;

        function calculateDistance() {
            const startingPoint = document.getElementById('startingPoint').value;
            const destination = document.getElementById('destination').value;
            const distanceCoveredInput = document.getElementById('distanceCovered');

            const key1 = startingPoint + '-' + destination;
            const key2 = destination + '-' + startingPoint;
            const distance = distances[key1] || distances[key2] || 'Distance not found';

            distanceCoveredInput.value = distance;
        }

        function editRoute(routeNumber, startingPoint, destination, distanceCovered, driverID) {
            document.getElementById('routeNumber').value = routeNumber;
            document.getElementById('startingPoint').value = startingPoint;
            document.getElementById('destination').value = destination;
            document.getElementById('distanceCovered').value = distanceCovered;
            document.getElementById('driverID').value = driverID;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
