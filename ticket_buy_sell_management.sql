-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 10:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticket_buy_sell_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `BookingID` int(11) NOT NULL,
  `BusNumber` int(11) DEFAULT NULL,
  `Seat` int(11) DEFAULT NULL,
  `BookedBy` int(11) DEFAULT NULL,
  `BookingTime` datetime DEFAULT NULL,
  `ExpiryTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`BookingID`, `BusNumber`, `Seat`, `BookedBy`, `BookingTime`, `ExpiryTime`) VALUES
(1, 1, 2, 1, '2222-01-02 11:11:00', '2222-12-02 15:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `BusNumber` int(11) NOT NULL,
  `SeatingCapacity` int(11) DEFAULT NULL,
  `Model` varchar(255) DEFAULT NULL,
  `DriverID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`BusNumber`, `SeatingCapacity`, `Model`, `DriverID`) VALUES
(1, 40, 'Ena', 1),
(3, 40, 'Ena', 1);

-- --------------------------------------------------------

--
-- Table structure for table `busroutes`
--

CREATE TABLE `busroutes` (
  `RouteNumber` int(11) NOT NULL,
  `StartingPoint` varchar(255) DEFAULT NULL,
  `Destination` varchar(255) DEFAULT NULL,
  `DistanceCovered` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `busroutes`
--

INSERT INTO `busroutes` (`RouteNumber`, `StartingPoint`, `Destination`, `DistanceCovered`) VALUES
(1, 'Dhaka', 'Chattogram', 400);

-- --------------------------------------------------------

--
-- Table structure for table `busschedules`
--

CREATE TABLE `busschedules` (
  `ScheduleID` int(11) NOT NULL,
  `RouteNumber` int(11) DEFAULT NULL,
  `DepartureTime` datetime DEFAULT NULL,
  `ArrivalTime` datetime DEFAULT NULL,
  `BusNumber` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `DriverID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `ContactDetails` varchar(255) DEFAULT NULL,
  `LicenseNumber` varchar(255) DEFAULT NULL,
  `WorkingShifts` varchar(255) DEFAULT NULL,
  `EducationalQualifications` varchar(255) DEFAULT NULL,
  `TrainingDetails` varchar(255) DEFAULT NULL,
  `Awards` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`DriverID`, `Name`, `ContactDetails`, `LicenseNumber`, `WorkingShifts`, `EducationalQualifications`, `TrainingDetails`, `Awards`) VALUES
(1, 'josim', '11111', '44231423', 'Morning', 'HSC ', 'ww', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `drivertraining`
--

CREATE TABLE `drivertraining` (
  `TrainingID` int(11) NOT NULL,
  `DriverID` int(11) DEFAULT NULL,
  `TrainingDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `PassengerID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `ContactInformation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`PassengerID`, `Name`, `ContactInformation`) VALUES
(1, 'nabil', '1111111');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `TicketNumber` int(11) NOT NULL,
  `PassengerID` int(11) DEFAULT NULL,
  `DateOfTravel` date DEFAULT NULL,
  `Seat` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`TicketNumber`, `PassengerID`, `DateOfTravel`, `Seat`, `Price`) VALUES
(1, 1, '2222-02-02', 2, 99.00);

-- --------------------------------------------------------

--
-- Table structure for table `travelcards`
--

CREATE TABLE `travelcards` (
  `CardNumber` int(11) NOT NULL,
  `PassengerID` int(11) DEFAULT NULL,
  `TravelFrom` varchar(255) DEFAULT NULL,
  `TravelTo` varchar(255) DEFAULT NULL,
  `Cost` decimal(10,2) DEFAULT NULL,
  `Balance` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `travelcards`
--

INSERT INTO `travelcards` (`CardNumber`, `PassengerID`, `TravelFrom`, `TravelTo`, `Cost`, `Balance`) VALUES
(1, 1, 'Dhaka', 'Chattogram', 999.00, 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`) VALUES
(1, 'testuser', 'testpassword');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `BusNumber` (`BusNumber`),
  ADD KEY `BookedBy` (`BookedBy`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`BusNumber`),
  ADD KEY `DriverID` (`DriverID`);

--
-- Indexes for table `busroutes`
--
ALTER TABLE `busroutes`
  ADD PRIMARY KEY (`RouteNumber`);

--
-- Indexes for table `busschedules`
--
ALTER TABLE `busschedules`
  ADD PRIMARY KEY (`ScheduleID`),
  ADD KEY `RouteNumber` (`RouteNumber`),
  ADD KEY `BusNumber` (`BusNumber`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`DriverID`);

--
-- Indexes for table `drivertraining`
--
ALTER TABLE `drivertraining`
  ADD PRIMARY KEY (`TrainingID`),
  ADD KEY `DriverID` (`DriverID`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`PassengerID`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`TicketNumber`),
  ADD KEY `PassengerID` (`PassengerID`);

--
-- Indexes for table `travelcards`
--
ALTER TABLE `travelcards`
  ADD PRIMARY KEY (`CardNumber`),
  ADD KEY `PassengerID` (`PassengerID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `BusNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `busroutes`
--
ALTER TABLE `busroutes`
  MODIFY `RouteNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `busschedules`
--
ALTER TABLE `busschedules`
  MODIFY `ScheduleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `DriverID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drivertraining`
--
ALTER TABLE `drivertraining`
  MODIFY `TrainingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `PassengerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `TicketNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `travelcards`
--
ALTER TABLE `travelcards`
  MODIFY `CardNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`BusNumber`) REFERENCES `buses` (`BusNumber`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`BookedBy`) REFERENCES `passengers` (`PassengerID`);

--
-- Constraints for table `buses`
--
ALTER TABLE `buses`
  ADD CONSTRAINT `buses_ibfk_1` FOREIGN KEY (`DriverID`) REFERENCES `drivers` (`DriverID`);

--
-- Constraints for table `busschedules`
--
ALTER TABLE `busschedules`
  ADD CONSTRAINT `busschedules_ibfk_1` FOREIGN KEY (`RouteNumber`) REFERENCES `busroutes` (`RouteNumber`),
  ADD CONSTRAINT `busschedules_ibfk_2` FOREIGN KEY (`BusNumber`) REFERENCES `buses` (`BusNumber`);

--
-- Constraints for table `drivertraining`
--
ALTER TABLE `drivertraining`
  ADD CONSTRAINT `drivertraining_ibfk_1` FOREIGN KEY (`DriverID`) REFERENCES `drivers` (`DriverID`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`PassengerID`) REFERENCES `passengers` (`PassengerID`);

--
-- Constraints for table `travelcards`
--
ALTER TABLE `travelcards`
  ADD CONSTRAINT `travelcards_ibfk_1` FOREIGN KEY (`PassengerID`) REFERENCES `passengers` (`PassengerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
