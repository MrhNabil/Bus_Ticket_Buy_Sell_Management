<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $ticketNumber = $_POST['ticketNumber'];
        $passengerID = $_POST['passengerID'];
        $dateOfTravel = $_POST['dateOfTravel'];
        $seat = $_POST['seat'];
        $price = $_POST['price'];

        $sql = "UPDATE Tickets SET PassengerID='$passengerID', DateOfTravel='$dateOfTravel', Seat='$seat', Price='$price' WHERE TicketNumber='$ticketNumber'";
        if ($conn->query($sql) === TRUE) {
            echo "Ticket updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else if (isset($_POST['delete'])) {
        $ticketNumber = $_POST['ticketNumber'];

        $sql = "DELETE FROM Tickets WHERE TicketNumber='$ticketNumber'";
        if ($conn->query($sql) === TRUE) {
            echo "Ticket deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else if (isset($_POST['print'])) {
        $ticketNumber = $_POST['ticketNumber'];
        header("Location: print_ticket.php?ticketNumber=$ticketNumber");
        exit();
    } else {
        $passengerID = $_POST['passengerID'];
        $dateOfTravel = $_POST['dateOfTravel'];
        $seat = $_POST['seat'];
        $price = $_POST['price'];

        $sql = "INSERT INTO Tickets (PassengerID, DateOfTravel, Seat, Price) 
                VALUES ('$passengerID', '$dateOfTravel', '$seat', '$price')";
        if ($conn->query($sql) === TRUE) {
            echo "New ticket created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$result = $conn->query("SELECT * FROM Tickets");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tickets</title>
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
    <h1>Tickets</h1>
    <form method="post">
        <input type="hidden" name="ticketNumber" id="ticketNumber">
        <input type="text" name="passengerID" id="passengerID" placeholder="Passenger ID" required>
        <label for="dateofTravel">Date of Travel:</label>
        <input type="date" name="dateOfTravel" id="dateOfTravel" placeholder="Date of Travel" required>
        <input type="text" name="seat" id="seat" placeholder="Seat" required>
        <input type="text" name="price" id="price" placeholder="Price" required>
        <button type="submit">Add Ticket</button>
        <button type="submit" name="update">Update Ticket</button>
    </form>
    <h2>Ticket List</h2>
    <table>
        <tr>
            <th>Ticket Number</th>
            <th>Passenger ID</th>
            <th>Date of Travel</th>
            <th>Seat</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['TicketNumber']; ?></td>
            <td><?php echo $row['PassengerID']; ?></td>
            <td><?php echo $row['DateOfTravel']; ?></td>
            <td><?php echo $row['Seat']; ?></td>
            <td><?php echo $row['Price']; ?></td>
            <td>
                <button onclick="editTicket(<?php echo $row['TicketNumber']; ?>, '<?php echo $row['PassengerID']; ?>', '<?php echo $row['DateOfTravel']; ?>', '<?php echo $row['Seat']; ?>', '<?php echo $row['Price']; ?>')">Edit</button>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="ticketNumber" value="<?php echo $row['TicketNumber']; ?>">
                    <button type="submit" name="delete">Delete</button>
                    <button type="submit" name="print">Print</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        function editTicket(ticketNumber, passengerID, dateOfTravel, seat, price) {
            document.getElementById('ticketNumber').value = ticketNumber;
            document.getElementById('passengerID').value = passengerID;
            document.getElementById('dateOfTravel').value = dateOfTravel;
            document.getElementById('seat').value = seat;
            document.getElementById('price').value = price;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
