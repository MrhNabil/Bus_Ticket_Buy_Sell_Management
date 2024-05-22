<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $busNumber = isset($_POST['busNumber']) ? $_POST['busNumber'] : null;
    $seatingCapacity = $_POST['seatingCapacity'];
    $model = $_POST['model'];
    $driverID = $_POST['driverID'];

    // Check if DriverID exists
    $driverCheck = $conn->prepare("SELECT * FROM drivers WHERE DriverID = ?");
    $driverCheck->bind_param("i", $driverID);
    $driverCheck->execute();
    $driverCheckResult = $driverCheck->get_result();

    if ($driverCheckResult->num_rows == 0) {
        echo "Error: DriverID does not exist.";
    } else {
        if (isset($_POST['update']) && $busNumber) {
            // Update existing bus
            $sql = "UPDATE Buses SET SeatingCapacity=?, Model=?, DriverID=? WHERE BusNumber=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isii", $seatingCapacity, $model, $driverID, $busNumber);
            if ($stmt->execute() === TRUE) {
                echo "Bus updated successfully";
            } else {
                echo "Error updating bus: " . $stmt->error;
            }
        } else if (isset($_POST['delete']) && $busNumber) {
            // Delete bus
            $sql = "DELETE FROM Buses WHERE BusNumber=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $busNumber);
            if ($stmt->execute() === TRUE) {
                echo "Bus deleted successfully";
            } else {
                echo "Error deleting bus: " . $stmt->error;
            }
        } else {
            // Insert new bus
            $sql = "INSERT INTO Buses (SeatingCapacity, Model, DriverID) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isi", $seatingCapacity, $model, $driverID);
            if ($stmt->execute() === TRUE) {
                echo "New bus created successfully";
            } else {
                echo "Error inserting new bus: " . $stmt->error;
            }
        }
    }
    $driverCheck->close();
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
        <select name="busType" id="busType" onchange="updateModelOptions()" required>
            <option value="">Select Bus Type</option>
            <option value="Intra-City">Intra-City</option>
            <option value="Inter-City">Inter-City</option>
            <option value="Luxury">Luxury</option>
            <option value="Local">Local</option>
        </select>
        <br>
        <select name="model" id="model" onchange="setSeatingCapacity()" required>
            <option value="">Select Model</option>
        </select>
        <br>
        <input type="text" name="seatingCapacity" id="seatingCapacity" placeholder="Seating Capacity" required>
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
        function updateModelOptions() {
            const busType = document.getElementById('busType').value;
            const modelSelect = document.getElementById('model');
            modelSelect.innerHTML = '<option value="">Select Model</option>'; // Reset options

            const models = {
                'Intra-City': ['Ashok Leyland Viking', 'Ashok Leyland Cheetah', 'Tata Marcopolo', 'Tata Starbus', 'Hino AK Series', 'Hino RM Series', 'Eicher Skyline Pro'],
                'Inter-City': ['Volvo B9R', 'Volvo B11R', 'Scania K410', 'Scania Higer A30', 'Mercedes-Benz 0500R', 'Hyundai Universe', 'Isuzu Giga', 'Isuzu LT134', 'Daewoo BH120F'],
                'Luxury': ['Volvo B8R', 'Scania Irizar i8', 'MAN Lions Coach'],
                'Local': ['Ifad Ashok Leyland', 'Hino AK1J', 'Runner RT Series']
            };

            if (models[busType]) {
                models[busType].forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.text = model;
                    modelSelect.appendChild(option);
                });
            }
        }

        function setSeatingCapacity() {
            const busType = document.getElementById('busType').value;
            const model = document.getElementById('model').value;
            const seatingCapacityInput = document.getElementById('seatingCapacity');

            if (busType === 'Inter-City') {
                seatingCapacityInput.value = 60;
            } else if (busType === 'Intra-City') {
                seatingCapacityInput.value = 45;
            } else if (busType === 'Luxury') {
                // Set seating capacity for luxury models with a range
                if (['Volvo B8R', 'Scania Irizar i8', 'MAN Lions Coach'].includes(model)) {
                    seatingCapacityInput.value = Math.floor(Math.random() * 31) + 40; // random between 40 and 70
                }
            } else if (busType === 'Local') {
                seatingCapacityInput.value = 30;
            }
        }

        function editBus(busNumber, seatingCapacity, model, driverID) {
            document.getElementById('busNumber').value = busNumber;
            document.getElementById('seatingCapacity').value = seatingCapacity;
            document.getElementById('model').value = model;
            document.getElementById('driverID').value = driverID;
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
