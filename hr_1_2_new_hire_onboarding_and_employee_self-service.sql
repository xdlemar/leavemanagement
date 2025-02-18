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
-- Database: `hr_1&2_new_hire_onboarding_and_employee_self-service`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `DepartmentID` int(11) NOT NULL,
  `DepartmentName` varchar(100) NOT NULL,
  `Location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`DepartmentID`, `DepartmentName`, `Location`) VALUES
(1, 'I.T', ''),
(69, 'SENIOR', '');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EmployeeID` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `HireDate` date DEFAULT NULL,
  `DepartmentID` int(11) NOT NULL,
  `JobRoleID` int(11) NOT NULL,
  `Status` enum('''Active''','''Inactive''','''Terminated''','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmployeeID`, `FirstName`, `LastName`, `Email`, `Phone`, `DateOfBirth`, `HireDate`, `DepartmentID`, `JobRoleID`, `Status`) VALUES
(1, 'LEMAR', 'ABAD', 'xdlemar@gmail.com', '09393632131', '2002-05-11', '2025-02-10', 1, 1, '\'Active\''),
(69, 'TANG', 'INAMO', 'TANGINAMO@GMAIL.COM', '0912345647', '1997-02-26', '2024-11-01', 69, 1, '\'Active\''),
(688, 'boss', 'kupal', 'kupal@gmail.com', '09393635141', '1996-02-21', '2006-02-01', 69, 2, '\'Active\'');

-- --------------------------------------------------------

--
-- Table structure for table `jobroles`
--

CREATE TABLE `jobroles` (
  `JobRoleID` int(11) NOT NULL,
  `RoleName` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `SalaryRange` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobroles`
--

INSERT INTO `jobroles` (`JobRoleID`, `RoleName`, `Description`, `SalaryRange`) VALUES
(1, 'HR', '', 0.00),
(2, 'STAFF', '', 0.00),
(22, 'STAFF', '', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `onboardingtasks`
--

CREATE TABLE `onboardingtasks` (
  `TaskID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `Employee Name` varchar(255) NOT NULL,
  `TaskName` varchar(255) NOT NULL,
  `DueDate` date DEFAULT NULL,
  `Status` enum('''Pending''','''Completed''','''Overdue''','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `onboardingtasks`
--

INSERT INTO `onboardingtasks` (`TaskID`, `EmployeeID`, `Employee Name`, `TaskName`, `DueDate`, `Status`) VALUES
(1, 1, '', '', NULL, '\'Pending\'');

-- --------------------------------------------------------

--
-- Table structure for table `selfservicerequests`
--

CREATE TABLE `selfservicerequests` (
  `RequestID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `Employee Name` varchar(255) NOT NULL,
  `RequestType` varchar(100) NOT NULL,
  `RequestDetails` text NOT NULL,
  `RequestDate` datetime NOT NULL DEFAULT current_timestamp(),
  `Status` enum('''Pending''','''Approved''','''Rejected''','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `selfservicerequests`
--

INSERT INTO `selfservicerequests` (`RequestID`, `EmployeeID`, `Employee Name`, `RequestType`, `RequestDetails`, `RequestDate`, `Status`) VALUES
(1, 1, '', '', '', '2025-02-05 17:41:33', '\'Pending\'');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`DepartmentID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD KEY `JobRoleID` (`JobRoleID`),
  ADD KEY `DepartmentID` (`DepartmentID`);

--
-- Indexes for table `jobroles`
--
ALTER TABLE `jobroles`
  ADD PRIMARY KEY (`JobRoleID`);

--
-- Indexes for table `onboardingtasks`
--
ALTER TABLE `onboardingtasks`
  ADD PRIMARY KEY (`TaskID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `selfservicerequests`
--
ALTER TABLE `selfservicerequests`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `DepartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=689;

--
-- AUTO_INCREMENT for table `jobroles`
--
ALTER TABLE `jobroles`
  MODIFY `JobRoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `onboardingtasks`
--
ALTER TABLE `onboardingtasks`
  MODIFY `TaskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `selfservicerequests`
--
ALTER TABLE `selfservicerequests`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`JobRoleID`) REFERENCES `jobroles` (`JobRoleID`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`);

--
-- Constraints for table `onboardingtasks`
--
ALTER TABLE `onboardingtasks`
  ADD CONSTRAINT `onboardingtasks_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`);

--
-- Constraints for table `selfservicerequests`
--
ALTER TABLE `selfservicerequests`
  ADD CONSTRAINT `selfservicerequests_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
