-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 10:19 AM
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
-- Database: `hr_3&4_leave_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `leavebalances`
--

CREATE TABLE `leavebalances` (
  `BalanceID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `EmployeeName` varchar(255) NOT NULL,
  `LeaveName` varchar(255) NOT NULL,
  `LeaveTypeID` int(11) NOT NULL,
  `RemainingDays` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leavebalances`
--

INSERT INTO `leavebalances` (`BalanceID`, `EmployeeID`, `EmployeeName`, `LeaveName`, `LeaveTypeID`, `RemainingDays`) VALUES
(1, 1, 'LEMAR ABAD', 'sipon', 3, 0),
(2, 1, 'LEMAR ABAD', 'LAG UBO SIPON', 4, 0),
(3, 69, 'TANG INAMO', 'JABOL', 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `leaverequests`
--

CREATE TABLE `leaverequests` (
  `RequestID` int(11) NOT NULL,
  `LeaveName` varchar(255) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `ProgramName` varchar(255) NOT NULL,
  `LeaveTypeID` int(11) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `Status` enum('Pending','Approved','Rejected','') NOT NULL,
  `RequestDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaverequests`
--

INSERT INTO `leaverequests` (`RequestID`, `LeaveName`, `EmployeeID`, `ProgramName`, `LeaveTypeID`, `StartDate`, `EndDate`, `Status`, `RequestDate`) VALUES
(3, 'BUNTIS', 69, 'HR', 3, '2025-02-04', '2025-02-26', 'Approved', '2025-02-16 18:49:50'),
(4, 'sipon', 1, 'bisaya', 3, '2025-02-18', '2025-02-18', 'Approved', '2025-02-16 22:44:33'),
(5, 'GALIS', 1, 'JASON', 3, '2025-02-19', '2025-02-21', 'Approved', '2025-02-16 22:55:23'),
(6, 'BAKASYON', 1, 'bisaya', 3, '2025-02-22', '2025-02-25', 'Approved', '2025-02-16 23:11:12'),
(7, 'LAG UBO SIPON', 1, 'KUPAL', 4, '2025-02-17', '2025-02-21', 'Approved', '2025-02-16 23:31:41'),
(8, 'JABOL', 69, 'BOSSABOS', 3, '2025-02-18', '2025-02-19', 'Approved', '2025-02-17 14:16:14'),
(9, 'NAPATIKOL', 688, 'TAGAHUGAS', 4, '2025-02-18', '2025-02-19', 'Rejected', '2025-02-17 15:02:25');

-- --------------------------------------------------------

--
-- Table structure for table `leavetypes`
--

CREATE TABLE `leavetypes` (
  `LeaveTypeID` int(11) NOT NULL,
  `LeaveTypeName` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `MaxDaysAllowed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leavetypes`
--

INSERT INTO `leavetypes` (`LeaveTypeID`, `LeaveTypeName`, `Description`, `MaxDaysAllowed`) VALUES
(3, 'MATERNITY', 'UHM', 7),
(4, 'sipon', 'yesdaddy', 5),
(5, 'NASAGASAAN', 'BUHAY DAPAT', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leavebalances`
--
ALTER TABLE `leavebalances`
  ADD PRIMARY KEY (`BalanceID`),
  ADD KEY `EmployeeID` (`EmployeeID`),
  ADD KEY `LeaveTypeID` (`LeaveTypeID`);

--
-- Indexes for table `leaverequests`
--
ALTER TABLE `leaverequests`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `EmployeeID` (`EmployeeID`),
  ADD KEY `LeaveTypeID` (`LeaveTypeID`);

--
-- Indexes for table `leavetypes`
--
ALTER TABLE `leavetypes`
  ADD PRIMARY KEY (`LeaveTypeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leavebalances`
--
ALTER TABLE `leavebalances`
  MODIFY `BalanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leaverequests`
--
ALTER TABLE `leaverequests`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `leavetypes`
--
ALTER TABLE `leavetypes`
  MODIFY `LeaveTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leavebalances`
--
ALTER TABLE `leavebalances`
  ADD CONSTRAINT `leavebalances_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `hr_1&2_new_hire_onboarding_and_employee_self-service`.`employees` (`EmployeeID`),
  ADD CONSTRAINT `leavebalances_ibfk_2` FOREIGN KEY (`LeaveTypeID`) REFERENCES `leavetypes` (`LeaveTypeID`);

--
-- Constraints for table `leaverequests`
--
ALTER TABLE `leaverequests`
  ADD CONSTRAINT `leaverequests_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `hr_1&2_new_hire_onboarding_and_employee_self-service`.`employees` (`EmployeeID`),
  ADD CONSTRAINT `leaverequests_ibfk_2` FOREIGN KEY (`LeaveTypeID`) REFERENCES `leavetypes` (`LeaveTypeID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
