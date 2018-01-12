-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2018 at 12:09 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webapp_project`
--
CREATE DATABASE IF NOT EXISTS `webapp_project` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `webapp_project`;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `cardId` int(11) NOT NULL,
  `element` enum('Earth','Fire','Water','Thunder','Magic') NOT NULL,
  `name` varchar(50) NOT NULL,
  `attack` int(11) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`cardId`, `element`, `name`, `attack`, `image`) VALUES
(1, 'Fire', 'Tiger', 2000, '../images/Monster Cards/Fire/tiger.png'),
(2, 'Fire', 'Phoenix', 3200, '../images/Monster Cards/Fire/phoenix.png'),
(3, 'Fire', 'Hellhound', 1550, '../images/Monster Cards/Fire/hellhound.png'),
(4, 'Fire', 'Fire Dragon', 3200, '../images/Monster Cards/Fire/fireDragon.png'),
(5, 'Fire', 'Salamder', 950, '../images/Monster Cards/Fire/salamander.png'),
(6, 'Earth', 'Desert dragon', 2800, '../images/Monster Cards/Earth/desertDragon.png'),
(7, 'Earth', 'Goblin', 550, '../images/Monster Cards/Earth/goblin.png'),
(8, 'Earth', 'Golem', 3100, '../images/Monster Cards/Earth/golem.png'),
(9, 'Earth', 'Kong', 990, '../images/Monster Cards/Earth/kong.png'),
(10, 'Earth', 'Ogre', 1800, '../images/Monster Cards/Earth/ogre.png'),
(11, 'Thunder', 'Eagle', 1700, '../images/Monster Cards/Thunder/eagle.png'),
(12, 'Thunder', 'Raiju', 2900, '../images/Monster Cards/Thunder/raiju.png'),
(13, 'Thunder', 'Ghost', 2500, '../images/Monster Cards/Thunder/ghost.png'),
(14, 'Thunder', 'Spider', 1000, '../images/Monster Cards/Thunder/spider.png'),
(15, 'Thunder', 'Thunder Dragon', 3250, '../images/Monster Cards/Thunder/thunderDragon.png'),
(16, 'Water', 'Kraken', 3300, '../images/Monster Cards/Water/kraken.png'),
(17, 'Water', 'Shark', 2200, '../images/Monster Cards/Water/shark.png'),
(18, 'Water', 'Sea Serpent', 1800, '../images/Monster Cards/Water/seaSerpent.png'),
(19, 'Water', 'Water Dragon', 3500, '../images/Monster Cards/Water/waterDragon.png'),
(20, 'Water', 'Piranha', 975, '../images/Monster Cards/Water/piranha.png');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `playerId` int(11) NOT NULL,
  `playerName` varchar(30) NOT NULL,
  `highestWinningHp` int(11) NOT NULL,
  `lastDatePlayed` date NOT NULL,
  `wins` int(11) NOT NULL,
  `losses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`playerId`, `playerName`, `highestWinningHp`, `lastDatePlayed`, `wins`, `losses`) VALUES
(1, 'Darrel', 4000, '2018-01-12', 24, 9),
(16, 'JDoe', 4000, '2017-10-09', 1, 0),
(17, 'Pete', 2450, '2017-10-10', 4, 1),
(18, 'mikiiii', 400, '2017-10-10', 1, 1),
(19, 'abe', 2600, '2017-11-09', 1, 0),
(20, 'Neri', 0, '2018-01-04', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`cardId`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`playerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `cardId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `playerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
