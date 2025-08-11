-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 11, 2025 at 12:23 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ar_shopping`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `adminID` int NOT NULL AUTO_INCREMENT,
  `fullName` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `companyEmail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`adminID`),
  UNIQUE KEY `companyEmail` (`companyEmail`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `fullName`, `username`, `companyEmail`, `password`) VALUES
(1, 'John Pork', 'John123', '', '$2y$10$s.YkiXfFNO/a0rYHKrcIUuC3/HQdTnTSwTZM3UjmoIsHGRETY7RHa');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cartID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `productID` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`cartID`),
  KEY `productID` (`productID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `userID`, `productID`, `quantity`) VALUES
(12, 11, 3, 2),
(13, 11, 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `productID` int NOT NULL AUTO_INCREMENT COMMENT 'product ID',
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `name`, `price`, `image`, `category`, `description`, `stock`) VALUES
(2, 'radio', 20.99, 'https://images.pexels.com/photos/18311093/pexels-photo-18311093.jpeg', 'electronics', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo dolor tempora odio rerum corporis voluptate reiciendis odit molestias aliquid cumque asperiores, adipisci voluptas nihil, esse iure. Hic ducimus aliquid odit.\r\n', 5),
(3, 'Smart Watch', 20.99, 'https://images.pexels.com/photos/8839887/pexels-photo-8839887.jpeg', 'electronics', 'A smart watch', 5),
(12, 'Gaming Controller', 90.99, 'https://images.pexels.com/photos/14642112/pexels-photo-14642112.jpeg', 'electronics', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Non nesciunt voluptas nemo sint blanditiis, quod sed in aliquid eum, tempora est eaque architecto ratione iste autem repudiandae ea optio officiis.', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int NOT NULL AUTO_INCREMENT COMMENT 'unique ID',
  `fullName` varchar(255) NOT NULL COMMENT 'user full name',
  `username` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL COMMENT 'user email',
  `password` varchar(255) NOT NULL COMMENT 'password',
  PRIMARY KEY (`userID`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `fullName`, `username`, `email`, `password`) VALUES
(4, 'Andre Ragbir', 'andreragbir', 'andreragbir122@gmail.com', '$2y$10$E/kpSAhK85hyPDyv5UBX4.BLrYInyyye0jC5kqxyroVn6rNVvYq/C'),
(5, 'Andre Ragbir', 'andreragbir123', 'andreragbir121@gmail.com', '$2y$10$RwyrFGhTBSrEkDe/K84SFO.594sz43GZFWABJSygbLAIxkuow/F.6'),
(7, 'dontel', 'dontel1', 'don@gmail.com', 'don123'),
(10, 'Jared Li', 'jared123', 'jared123@gmail.com', '$2y$10$sFjiDOH979Y2vpM/FKZ3uOD4fdMYqwh4hG5j9xR7cFXfUZ3CvU.4q'),
(11, 'Johnny Abraham', 'Johnny123', 'Johnny123@mail.com', '$2y$10$KwuFo/Yntvranuj0tH.SIuvcKygL6/m/TinRlOKuMGqOERMtPTqvG');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
