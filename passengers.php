<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $passengerID = $_POST['passengerID'];
        $name = $_POST['name'];
        $contactInformation = $_POST['contactInformation'];

        $sql = "UPDATE Passengers SET Name='$name', ContactInformation='$contactInformation' WHERE PassengerID='$passengerID'";
        if ($conn->query($sql) === TRUE) {
            echo "Passenger updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else if (isset($_POST['delete'])) {
        $passengerID = $_POST['passengerID'];

        $sql = "DELETE FROM Passengers WHERE PassengerID='$passengerID'";
        if ($conn->query($sql) === TRUE) {
            echo "Passenger deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $name = $_POST['name'];
        $contactInformation = $_POST['contactInformation'];

        $sql = "INSERT INTO Passengers (Name, ContactInformation) VALUES ('$name', '$contactInformation')";
        if ($conn->query($sql) === TRUE) {
            echo "New passenger created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$result = $conn->query("SELECT * FROM Passengers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passengers</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="drivers.php">Drivers</a></li>
                <li><a href="buses.php">Buses</a></li>
                <li><a href="routes.php">Routes</a></li>
                <li><a href="schedules.php">Schedules</a></li>
                <li><a href="tickets.php">Tickets</a></li>
                <li><a href="bookings.php">Bookings</a></li>
                <li><a href="driver_training.php">Driver Training</a></li>
                <li><a href="travel_cards.php">Travel Cards</a></li>
            </ul>
        </nav>
    </header>
    <h1>Passengers</h1>
    <form method="post">
        <input type="hidden" name="passengerID" id="passengerID">
        <input type="text" name="name" id="name" placeholder="Name" required>
        <input type="text" name="contactInformation" id="contactInformation" placeholder="Contact Information" required>
        <button type="submit">Add Passenger</button>
        <button type="submit" name="update">Update Passenger</button>
    </form>
    <h2>Passenger List</h2>
    <table>
        <tr>
            <th>Passenger ID</th>
            <th>Name</th>
            <th>Contact Information</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['PassengerID']; ?></td>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['ContactInformation']; ?></td>
            <td>
                <button onclick="editPassenger(<?php echo $row['PassengerID']; ?>, '<?php echo $row['Name']; ?>', '<?php echo $row['ContactInformation']; ?>')">Edit</button>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="passengerID" value="<?php echo $row['PassengerID']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        function editPassenger(id, name, contactInformation) {
            document.getElementById('passengerID').value = id;
            document.getElementById('name').value = name;
            document.getElementById('contactInformation').value = contactInformation;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
