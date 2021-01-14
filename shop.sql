-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2021 at 06:53 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'Hand made', 'Department responsible for sell and buy computers', 1, 1, 1, 1),
(2, 'Books', 'Read and buy books online', 3, 1, 1, 1),
(3, 'Electornics', 'The Department sell and by furniture with good quality', 2, 1, 1, 1),
(4, 'Fashion', 'Sell and buy new clothes with new models', 4, 1, 1, 1),
(5, 'Gift', 'You will be able to send gifts to your friends', 5, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Com_ID` int(11) NOT NULL,
  `Comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Com_Date` date NOT NULL,
  `Com_Status` tinyint(4) NOT NULL DEFAULT 0,
  `Com_User` int(11) NOT NULL,
  `Com_Item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `Approve` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Item_Name`, `Item_Date`, `Item_Price`, `Item_Country`, `Item_Description`, `Item_Status`, `Item_Rating`, `User_ID`, `Cat_ID`, `Approve`) VALUES
(12, 'Oppo Enco W51', '2021-01-13', 127, 'Egypt', 'Airpods From Oppo ', 4, 5, 39, 3, 1),
(13, 'Mouse', '2021-01-13', 127, 'Egypt', 'A 4Tech Mouse', 4, 4, 38, 3, 1),
(14, 'Dell G3', '2021-01-13', 127, 'Egypt', 'Laptop G3 Dell 16 GB', 4, 5, 36, 3, 1),
(15, 'Keyboard', '2021-01-13', 127, 'Egypt', 'Keyboard And Mouse From Hp', 3, 4, 38, 3, 1),
(16, 'Eloquent JS', '2021-01-13', 70, 'Egypt', 'Javascript Book Author Marijn Haverbeke', 2, 5, 36, 2, 1),
(17, 'Larvel Up', '2021-01-13', 90, 'Egypt', 'Strong book to learn larvel framwork', 3, 4, 39, 2, 1),
(18, 'Amazon Gift 50$', '2021-01-13', 127, 'Egypt', 'Gift card from amazon with balance 50$', 4, 5, 39, 5, 1),
(19, 'Walmart 20$', '2021-01-13', 127, 'Egypt', 'Gift card from walmart with 20$ balance', 4, 4, 40, 5, 1),
(20, 'Google play 30$', '2021-01-13', 127, 'Egypt', 'Gift card from google play with 30$ balance', 4, 5, 39, 5, 1),
(21, 'PRETTYGARDEN', '2021-01-13', 127, 'Egypt', 'Women’s Solid Color Two Piece Outfit Long', 4, 4, 39, 4, 1),
(22, 'Escalier', '2021-01-13', 127, 'Egypt', 'Women\'s Down Jacket Winter Long', 4, 4, 39, 4, 1),
(23, 'Leggings', '2021-01-13', 127, 'Egypt', 'Depot Women\'s Printed Solid Activewear Jogger', 4, 4, 38, 4, 1),
(24, 'Women\'s 2 Piece', '2021-01-13', 127, 'Egypt', 'Sportswear Suit and Sweatpants Long Sleeve', 4, 4, 39, 4, 1),
(25, 'Delicate Initial', '2021-01-13', 127, 'Egypt', 'Disc Necklace Rose Gold Initial Necklace Best Friend ', 4, 4, 36, 1, 1),
(26, 'Sweet Water', '2021-01-13', 127, 'Egypt', 'Best Mom Ever, Sea Salt, Jasmine, Cream', 4, 3, 38, 1, 1),
(27, 'Plant holder', '2021-01-13', 127, 'Egypt', 'Neko Atsume special edition', 4, 3, 39, 1, 1),
(28, 'Popular Sea', '2021-01-13', 127, 'Egypt', 'Foam Green Sea Glass Earrings with Charming', 3, 4, 38, 1, 1),
(29, 'Clean code Alige', '2021-01-13', 80, 'Egypt', 'Author Robert Martin', 3, 4, 38, 2, 1),
(30, 'Javascript Visual', '2021-01-13', 100, 'Egypt', 'Learn ease javascript', 4, 4, 38, 2, 1);

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
  `Permission` tinyint(1) NOT NULL DEFAULT 0,
  `Status` tinyint(1) NOT NULL DEFAULT 0,
  `RegStatus` tinyint(1) NOT NULL DEFAULT 0,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `Permission`, `Status`, `RegStatus`, `date`) VALUES
(36, 'Admin', '0f4dacc1203388b25e0fb2f3825b5772b9e9b811', 'admin@gmail.com', 'Mhamoud Hussieny', 0, 0, 1, '2021-01-13'),
(37, 'Reversed', '0f4dacc1203388b25e0fb2f3825b5772b9e9b811', 'Reversed@gmail.com', 'Hassan Ali', 0, 0, 1, '2021-01-13'),
(38, 'User0', '0f4dacc1203388b25e0fb2f3825b5772b9e9b811', 'user0@gmail.com', 'Osama Ahmed', 0, 0, 1, '2021-01-13'),
(39, 'User1', '0f4dacc1203388b25e0fb2f3825b5772b9e9b811', 'User1@gmail.com', 'Fawzy Osama', 0, 0, 1, '2021-01-13'),
(40, 'User2', '0f4dacc1203388b25e0fb2f3825b5772b9e9b811', 'User2@gmail.com', 'Khaled Mohsen ', 0, 0, 1, '2021-01-13');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Com_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
