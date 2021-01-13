-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2021 at 01:03 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Description` text CHARACTER SET utf8 NOT NULL,
  `Ordering` int(11) NOT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(8, 'Phones', 'This section responsible for buy and sell phones ', 2, 1, 1, 0),
(10, 'Cars', 'This is responsible for buy and sell cards ', 4, 0, 1, 1),
(14, 'Computer', 'This section for sell and buy computers online', 8, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Com_ID` int(11) NOT NULL,
  `Comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Com_Date` date NOT NULL,
  `Com_Status` tinyint(4) NOT NULL DEFAULT '0',
  `Com_User` int(11) NOT NULL,
  `Com_Item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Com_ID`, `Comment`, `Com_Date`, `Com_Status`, `Com_User`, `Com_Item`) VALUES
(1, 'Thank dude for this product', '2021-01-11', 0, 32, 10),
(3, 'I hate iphones phones', '2021-01-08', 0, 35, 9),
(4, 'The car is too expansive dude', '2021-01-11', 1, 35, 11);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Item_Name` varchar(255) NOT NULL,
  `Item_Date` date NOT NULL,
  `Item_Price` tinyint(4) NOT NULL,
  `Item_Country` varchar(255) NOT NULL,
  `Item_Description` varchar(255) NOT NULL,
  `Item_Status` tinyint(4) NOT NULL,
  `Item_Rating` tinyint(4) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Item_Name`, `Item_Date`, `Item_Price`, `Item_Country`, `Item_Description`, `Item_Status`, `Item_Rating`, `User_ID`, `Cat_ID`, `Approve`) VALUES
(8, 'Lancer', '2021-01-10', 120, 'Cairo', 'Lance Model 2008', 3, 3, 35, 10, 1),
(9, 'Iphone 11', '2021-01-10', 10, 'Tanta', 'Iphone 11,\r\n128G\r\n4GB Ram', 4, 3, 35, 8, 1),
(10, 'Laptop G3', '2021-01-10', 16, 'Alexanderia', 'Laptop G3, 16GB , Hard 1TB', 3, 5, 32, 14, 1),
(11, 'C180', '2021-01-10', 127, 'Alexanderia', 'New car model 2021 , used 1 week', 4, 3, 24, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(1) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Permission` tinyint(1) NOT NULL DEFAULT '0',
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  `RegStatus` tinyint(1) NOT NULL DEFAULT '0',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `Permission`, `Status`, `RegStatus`, `date`) VALUES
(24, 'Admin', '0f4dacc1203388b25e0fb2f3825b5772b9e9b811', 'admin@gmail.com', 'Mahmoud Hussieny', 1, 0, 1, '0000-00-00'),
(32, 'User5415', '52e152d69ad5cc4347498b5feed5db9f88aaa32c', 'admin@gmail.com', 'Ibrahim Ahmed', 0, 0, 1, '2020-12-10'),
(35, 'User45858', '7e26df4315c040ca7935e519f6a4ae276b90d4f3', 'admin1@gmail.com', 'Galal Ahmed', 0, 0, 1, '2020-12-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD UNIQUE KEY `Ordering` (`Ordering`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Com_ID`),
  ADD KEY `com_user` (`Com_User`),
  ADD KEY `com_items` (`Com_Item`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `cat_cons` (`Cat_ID`),
  ADD KEY `member_const` (`User_ID`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Com_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `com_items` FOREIGN KEY (`Com_Item`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `com_user` FOREIGN KEY (`Com_User`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_cons` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_const` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
