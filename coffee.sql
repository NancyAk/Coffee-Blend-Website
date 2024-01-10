-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2023 at 10:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`ID`, `username`, `pwd`, `phone_number`, `address`) VALUES
(1, 'nancy', '123', '76793469', 'LAU Beirut');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `feedback`) VALUES
(7, 'John Doe', 'john@example.com', 'Great service!'),
(8, 'Jane Smith', 'jane@example.com', 'Very helpful staff.'),
(9, 'Bob Johnson', 'bob@example.com', 'Improvement suggestions.'),
(10, 'kvdpkvpdk', 'kvpdkvpdk@gmail.com', 'kvpdkvpdkvpd');

-- --------------------------------------------------------

--
-- Table structure for table `lookupitems`
--

CREATE TABLE `lookupitems` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `lookup_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lookupitems`
--

INSERT INTO `lookupitems` (`ID`, `name`, `price`, `lookup_id`) VALUES
(1, 'Caramel Drizzle', 0.50, 1),
(2, 'Whipped Cream', 0.75, 1),
(3, 'Chocolate Shavings', 1.00, 1),
(4, 'Hazelnut Syrup', 0.60, 1),
(5, 'Vanilla Powder', 0.70, 1),
(6, 'Cinnamon Sprinkle', 0.45, 1),
(7, 'Small', 2.00, 0),
(8, 'Medium', 2.50, 0),
(9, 'Large', 3.00, 0),
(10, 'Extra Large', 3.50, 0),
(11, 'Kids', 1.75, 0),
(12, 'no topping', 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lookups`
--

CREATE TABLE `lookups` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lookups`
--

INSERT INTO `lookups` (`ID`, `name`) VALUES
(0, 'size'),
(1, 'Topping');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `ID` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`ID`, `item_name`, `description`, `price`) VALUES
(0, 'Espresso', 'Strong and concentrated coffee', 2.50),
(1, 'Americano', 'Diluted espresso with hot water', 3.00),
(2, 'Latte', 'Espresso with steamed milk', 4.00),
(3, 'Cappuccino', 'Espresso with equal parts of steamed milk and milk foam', 4.50),
(4, 'Macchiato', 'Espresso with a small amount of frothed milk', 3.50),
(5, 'Mocha', 'Espresso with chocolate and steamed milk', 5.00),
(6, 'Flat White', 'Similar to a latte but with microfoam', 4.50),
(7, 'Iced Coffee', 'Chilled coffee with ice', 3.50),
(8, 'Cold Brew', 'Coffee brewed with cold water over an extended period', 4.50),
(9, 'Affogato', 'Espresso poured over a scoop of vanilla ice cream', 5.50),
(10, 'Irish Coffee', 'Coffee with Irish whiskey and cream', 6.00),
(11, 'Decaf Coffee', 'Coffee without caffeine', 3.00),
(12, 'Vanilla Latte', 'Latte with vanilla flavoring', 4.50),
(13, 'Hazelnut Cappuccino', 'Cappuccino with hazelnut flavor', 5.00),
(14, 'Caramel Macchiato', 'Espresso with steamed milk and caramel drizzle', 5.50),
(15, 'Peppermint Mocha', 'Mocha with peppermint flavor and whipped cream', 5.50);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `toppings` varchar(255) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ID`, `customer_id`, `menu_id`, `toppings`, `size`) VALUES
(60, 1, 0, 'Caramel Drizzle', 'Small'),
(61, 1, 0, 'Cinnamon Sprinkle', 'Small'),
(62, 1, 3, 'Vanilla Powder', 'Extra Large');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lookupitems`
--
ALTER TABLE `lookupitems`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `lookup_id` (`lookup_id`);

--
-- Indexes for table `lookups`
--
ALTER TABLE `lookups`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `FK_orders_customer` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lookupitems`
--
ALTER TABLE `lookupitems`
  ADD CONSTRAINT `lookupitems_ibfk_1` FOREIGN KEY (`lookup_id`) REFERENCES `lookups` (`ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_orders_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`ID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
