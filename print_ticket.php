<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
include 'db.php';

$ticketNumber = $_GET['ticketNumber'];

$sql = "SELECT * FROM Tickets WHERE TicketNumber='$ticketNumber'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $ticket = $result->fetch_assoc();
} else {
    echo "No ticket found";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Ticket</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .ticket {
            border: 1px solid #000;
            padding: 20px;
            margin: 20px;
            width: 300px;
        }
        .ticket p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>Print Ticket</h1>
    <div class="ticket">
        <p><strong>Ticket Number:</strong> <?php echo $ticket['TicketNumber']; ?></p>
        <p><strong>Passenger ID:</strong> <?php echo $ticket['PassengerID']; ?></p>
        <p><strong>Date of Travel:</strong> <?php echo $ticket['DateOfTravel']; ?></p>
        <p><strong>Seat:</strong> <?php echo $ticket['Seat']; ?></p>
        <p><strong>Price:</strong> <?php echo $ticket['Price']; ?></p>
    </div>
    <button onclick="window.print()">Print</button>
</body>
</html>

<?php $conn->close(); ?>
