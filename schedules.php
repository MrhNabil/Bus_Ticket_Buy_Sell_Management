<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $routeNumber = $_POST['routeNumber'];
    $departureTime = $_POST['departureTime'];
    $arrivalTime = $_POST['arrivalTime'];
    $busNumber = $_POST['busNumber'];
    
    // Check if RouteNumber exists
    $routeCheck = $conn->prepare("SELECT * FROM BusRoutes WHERE RouteNumber = ?");
    $routeCheck->bind_param("i", $routeNumber);
    $routeCheck->execute();
    $routeCheckResult = $routeCheck->get_result();
    
    // Check if BusNumber exists
    $busCheck = $conn->prepare("SELECT * FROM Buses WHERE BusNumber = ?");
    $busCheck->bind_param("i", $busNumber);
    $busCheck->execute();
    $busCheckResult = $busCheck->get_result();
    
    if ($routeCheckResult->num_rows == 0) {
        echo "Error: RouteNumber does not exist.";
    } elseif ($busCheckResult->num_rows == 0) {
        echo "Error: BusNumber does not exist.";
    } else {
        if (isset($_POST['update'])) {
            $scheduleID = $_POST['scheduleID'];
            $sql = "UPDATE BusSchedules SET RouteNumber=?, DepartureTime=?, ArrivalTime=?, BusNumber=? WHERE ScheduleID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issii", $routeNumber, $departureTime, $arrivalTime, $busNumber, $scheduleID);
            if ($stmt->execute() === TRUE) {
                echo "Schedule updated successfully";
            } else {
                echo "Error updating schedule: " . $stmt->error;
            }
        } elseif (isset($_POST['delete'])) {
            $scheduleID = $_POST['scheduleID'];
            $sql = "DELETE FROM BusSchedules WHERE ScheduleID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $scheduleID);
            if ($stmt->execute() === TRUE) {
                echo "Schedule deleted successfully";
            } else {
                echo "Error deleting schedule: " . $stmt->error;
            }
        } else {
            $sql = "INSERT INTO BusSchedules (RouteNumber, DepartureTime, ArrivalTime, BusNumber) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issi", $routeNumber, $departureTime, $arrivalTime, $busNumber);
            if ($stmt->execute() === TRUE) {
                echo "New schedule created successfully";
            } else {
                echo "Error inserting new schedule: " . $stmt->error;
            }
        }
    }
    $routeCheck->close();
    $busCheck->close();
}

$result = $conn->query("SELECT * FROM BusSchedules");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules</title>
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
    <h1>Schedules</h1>
    <form method="post">
        <input type="hidden" name="scheduleID" id="scheduleID">
        <input type="text" name="routeNumber" id="routeNumber" placeholder="Route Number" required>
        <input type="datetime-local" name="departureTime" id="departureTime" placeholder="Departure Time" required>
        <input type="datetime-local" name="arrivalTime" id="arrivalTime" placeholder="Arrival Time" required>
        <input type="text" name="busNumber" id="busNumber" placeholder="Bus Number" required>
        <button type="submit">Add Schedule</button>
        <button type="submit" name="update">Update Schedule</button>
    </form>
    <h2>Schedule List</h2>
    <table>
        <tr>
            <th>Schedule ID</th>
            <th>Route Number</th>
            <th>Departure Time</th>
            <th>Arrival Time</th>
            <th>Bus Number</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['ScheduleID']; ?></td>
            <td><?php echo $row['RouteNumber']; ?></td>
            <td><?php echo $row['DepartureTime']; ?></td>
            <td><?php echo $row['ArrivalTime']; ?></td>
            <td><?php echo $row['BusNumber']; ?></td>
            <td>
                <button onclick="editSchedule(<?php echo $row['ScheduleID']; ?>, '<?php echo $row['RouteNumber']; ?>', '<?php echo $row['DepartureTime']; ?>', '<?php echo $row['ArrivalTime']; ?>', '<?php echo $row['BusNumber']; ?>')">Edit</button>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="scheduleID" value="<?php echo $row['ScheduleID']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        function editSchedule(scheduleID, routeNumber, departureTime, arrivalTime, busNumber) {
            document.getElementById('scheduleID').value = scheduleID;
            document.getElementById('routeNumber').value = routeNumber;
            document.getElementById('departureTime').value = departureTime;
            document.getElementById('arrivalTime').value = arrivalTime;
            document.getElementById('busNumber').value = busNumber;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
