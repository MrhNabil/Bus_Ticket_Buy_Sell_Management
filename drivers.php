<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $driverID = $_POST['driverID'];
        $name = $_POST['name'];
        $contactDetails = $_POST['contactDetails'];
        $licenseNumber = $_POST['licenseNumber'];
        $workingShifts = $_POST['workingShifts'];
        $educationalQualifications = $_POST['educationalQualifications'];
        $trainingDetails = $_POST['trainingDetails'];
        $awards = $_POST['awards'];

        $sql = "UPDATE Drivers SET Name='$name', ContactDetails='$contactDetails', LicenseNumber='$licenseNumber', WorkingShifts='$workingShifts', EducationalQualifications='$educationalQualifications', TrainingDetails='$trainingDetails', Awards='$awards' WHERE DriverID='$driverID'";
        if ($conn->query($sql) === TRUE) {
            echo "Driver updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else if (isset($_POST['delete'])) {
        $driverID = $_POST['driverID'];

        $sql = "DELETE FROM Drivers WHERE DriverID='$driverID'";
        if ($conn->query($sql) === TRUE) {
            echo "Driver deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $name = $_POST['name'];
        $contactDetails = $_POST['contactDetails'];
        $licenseNumber = $_POST['licenseNumber'];
        $workingShifts = $_POST['workingShifts'];
        $educationalQualifications = $_POST['educationalQualifications'];
        $trainingDetails = $_POST['trainingDetails'];
        $awards = $_POST['awards'];

        $sql = "INSERT INTO Drivers (Name, ContactDetails, LicenseNumber, WorkingShifts, EducationalQualifications, TrainingDetails, Awards) 
                VALUES ('$name', '$contactDetails', '$licenseNumber', '$workingShifts', '$educationalQualifications', '$trainingDetails', '$awards')";
        if ($conn->query($sql) === TRUE) {
            echo "New driver created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$result = $conn->query("SELECT * FROM Drivers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drivers</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="passengers.php">Passengers</a></li>
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
    <h1>Drivers</h1>
    <form method="post">
        <input type="hidden" name="driverID" id="driverID">
        <input type="text" name="name" id="name" placeholder="Name" required>
        <input type="text" name="contactDetails" id="contactDetails" placeholder="Contact Details" required>
        <input type="text" name="licenseNumber" id="licenseNumber" placeholder="License Number" required>
        <select name="workingShifts" id="workingShifts" required>
            <option value="">Select Shift</option>
            <option value="Morning">Morning</option>
            <option value="Noon">Noon</option>
            <option value="Evening">Evening</option>
            <option value="Night">Night</option>
        </select>
        <br>
        <select name="educationalQualifications" id="educationalQualifications" required>
            <option value="">Select Educational Qualification</option>
            <option value="SSC">SSC</option>
            <option value="HSC">HSC</option>
        </select>
        <input type="text" name="trainingDetails" id="trainingDetails" placeholder="Training Details" required>
        <input type="text" name="awards" id="awards" placeholder="Awards" required>
        <button type="submit">Add Driver</button>
        <button type="submit" name="update">Update Driver</button>
    </form>
    <h2>Driver List</h2>
    <table>
        <tr>
            <th>Driver ID</th>
            <th>Name</th>
            <th>Contact Details</th>
            <th>License Number</th>
            <th>Working Shifts</th>
            <th>Educational Qualifications</th>
            <th>Training Details</th>
            <th>Awards</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['DriverID']; ?></td>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['ContactDetails']; ?></td>
            <td><?php echo $row['LicenseNumber']; ?></td>
            <td><?php echo $row['WorkingShifts']; ?></td>
            <td><?php echo $row['EducationalQualifications']; ?></td>
            <td><?php echo $row['TrainingDetails']; ?></td>
            <td><?php echo $row['Awards']; ?></td>
            <td>
                <button onclick="editDriver(<?php echo $row['DriverID']; ?>, '<?php echo $row['Name']; ?>', '<?php echo $row['ContactDetails']; ?>', '<?php echo $row['LicenseNumber']; ?>', '<?php echo $row['WorkingShifts']; ?>', '<?php echo $row['EducationalQualifications']; ?>', '<?php echo $row['TrainingDetails']; ?>', '<?php echo $row['Awards']; ?>')">Edit</button>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="driverID" value="<?php echo $row['DriverID']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        function editDriver(id, name, contactDetails, licenseNumber, workingShifts, educationalQualifications, trainingDetails, awards) {
            document.getElementById('driverID').value = id;
            document.getElementById('name').value = name;
            document.getElementById('contactDetails').value = contactDetails;
            document.getElementById('licenseNumber').value = licenseNumber;
            document.getElementById('workingShifts').value = workingShifts;
            document.getElementById('educationalQualifications').value = educationalQualifications;
            document.getElementById('trainingDetails').value = trainingDetails;
            document.getElementById('awards').value = awards;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
