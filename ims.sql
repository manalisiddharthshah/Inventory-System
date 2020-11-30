-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 09, 2020 at 12:32 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `car_detail`
--

DROP TABLE IF EXISTS `car_detail`;
CREATE TABLE IF NOT EXISTS `car_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `model_type` varchar(10) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `model_color` varchar(20) NOT NULL,
  `no_of_seats` int(4) NOT NULL,
  `kilometers_driven` int(6) NOT NULL,
  `refurbished` enum('new car','old car') NOT NULL DEFAULT 'new car',
  `model_year` int(4) NOT NULL,
  `mileage` int(7) DEFAULT NULL,
  `fuel_type` varchar(7) DEFAULT NULL,
  `transmission` varchar(9) DEFAULT NULL,
  `fuel_tank_capacity` varchar(12) DEFAULT NULL,
  `power_steering` enum('no','yes') DEFAULT NULL,
  `air_conditioner` enum('no','yes') DEFAULT NULL,
  `airbag` enum('no','yes') DEFAULT NULL,
  `price` int(7) NOT NULL,
  `description` varchar(200) NOT NULL,
  `vin_number` varchar(19) DEFAULT NULL,
  `registration_number` varchar(15) NOT NULL,
  `sold` enum('not sold','sold') NOT NULL DEFAULT 'not sold',
  `deleted` enum('not deleted','deleted') NOT NULL DEFAULT 'not deleted',
  `image1` varchar(50) DEFAULT NULL,
  `image2` varchar(50) DEFAULT NULL,
  `created_date` date NOT NULL,
  `modified_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car_detail`
--

INSERT INTO `car_detail` (`id`, `user_id`, `manufacture_id`, `model_type`, `model_name`, `model_color`, `no_of_seats`, `kilometers_driven`, `refurbished`, `model_year`, `mileage`, `fuel_type`, `transmission`, `fuel_tank_capacity`, `power_steering`, `air_conditioner`, `airbag`, `price`, `description`, `vin_number`, `registration_number`, `sold`, `deleted`, `image1`, `image2`, `created_date`, `modified_date`) VALUES
(100, 89, 67, 'SUV', 'car', 'Red', 5, 0, 'new car', 2020, 30, 'dieasel', 'dfa', '13', 'no', 'no', 'no', 12345, 'bdcsandbJXNKJhahkjSHKJMJ', '', '5298', 'not sold', 'not deleted', 'manali.jpg', '', '2020-05-25', NULL),
(99, 83, 63, 'Basic', 'Wagonar', 'White', 5, 0, 'new car', 2020, 0, '', '', '', 'no', 'no', 'no', 50000, 'dsffg', '', '6788', 'not sold', 'not deleted', 'Wagonar.jpg', '', '2020-02-24', NULL),
(97, 84, 63, 'SUV', 'Brezza', 'Silver', 5, 0, 'new car', 2020, 15, 'dieasel', 'dfdrgdf', '', 'no', 'no', 'no', 955565, 'r3tbyh', '123456789012', '5298', 'sold', 'deleted', 'BREZZA.png', '', '2020-02-22', '2020-02-22'),
(98, 82, 66, 'Basic', 'NANO', 'Red', 4, 0, 'new car', 2020, 0, '', '', '', 'yes', 'no', 'no', 12345, 'qtnyhubj', 'ewqrxcfrgtvhy', '5298', 'sold', 'deleted', 'nano.jpg', '', '2020-02-22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_name` varchar(50) NOT NULL,
  `manufacturer_status` enum('unblock','block') NOT NULL DEFAULT 'unblock',
  `deleted` enum('not deleted','deleted') NOT NULL DEFAULT 'not deleted',
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `manufacturer_name`, `manufacturer_status`, `deleted`, `created_date`) VALUES
(68, 'suzuki', 'unblock', 'not deleted', '2020-08-11'),
(67, 'TOYOTO', 'unblock', 'not deleted', '2020-02-21'),
(66, 'TATA', 'unblock', 'not deleted', '2020-02-21'),
(65, 'NISSAN', 'unblock', 'not deleted', '2020-02-21'),
(64, 'SCODA', 'block', 'not deleted', '2020-02-21'),
(63, 'MARUTI', 'unblock', 'not deleted', '2020-02-21'),
(61, 'KIA', 'block', 'deleted', '2020-02-21'),
(60, 'HYUNDAI', 'unblock', 'not deleted', '2020-02-21'),
(59, 'Honda', 'unblock', 'not deleted', '2020-02-21');

-- --------------------------------------------------------

--
-- Table structure for table `transcation`
--

DROP TABLE IF EXISTS `transcation`;
CREATE TABLE IF NOT EXISTS `transcation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `transcation_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transcation`
--

INSERT INTO `transcation` (`id`, `user_id`, `model_id`, `transcation_date`) VALUES
(34, 83, 97, '2020-02-22'),
(36, 84, 98, '2020-02-22');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_phone` bigint(10) NOT NULL,
  `user_address` varchar(75) DEFAULT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_type` enum('admin','client') NOT NULL DEFAULT 'admin',
  `user_status` enum('active','inactive','block') NOT NULL DEFAULT 'inactive',
  `user_delete` enum('not deleted','deleted') NOT NULL DEFAULT 'not deleted',
  `created_date` date NOT NULL,
  `modified_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userEmail` (`user_email`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `user_email`, `user_phone`, `user_address`, `user_password`, `user_type`, `user_status`, `user_delete`, `created_date`, `modified_date`) VALUES
(88, 'MANALI', 'manalis.shah@thegatewaycorp.co.in', 9426247406, '', '25d55ad283aa400af464c76d713c07ad', 'client', 'inactive', 'not deleted', '2020-02-22', NULL),
(89, 'manalis shah', 'manalisiddh@gmail.com', 1234567890, 'asdfghjghjfvbnmtyuio', 'b14369e36639e9b0642faf9d693a5fcc', 'client', 'inactive', 'not deleted', '2020-05-25', NULL),
(86, 'Client', 'client@gmail.com', 9426759766, '', '25d55ad283aa400af464c76d713c07ad', 'client', 'block', 'deleted', '2020-02-21', NULL),
(85, 'Abcd', 'abcd@gmail.com', 8152034675, '', '25d55ad283aa400af464c76d713c07ad', 'client', 'block', 'not deleted', '2020-02-21', NULL),
(82, 'manali', 'manali@gmail.com', 9426247406, '', '25d55ad283aa400af464c76d713c07ad', 'client', 'inactive', 'not deleted', '2020-02-21', NULL),
(83, 'tbluser', 'tbluser@gmail.com', 9824322748, '', '25d55ad283aa400af464c76d713c07ad', 'client', 'inactive', 'not deleted', '2020-02-21', NULL),
(84, 'Manali Shah', 'manalishah98@gmail.com', 8152034666, '', '25d55ad283aa400af464c76d713c07ad', 'client', 'inactive', 'not deleted', '2020-02-21', '2020-02-22'),
(68, 'Gateway Group', 'thegatewacorp@gmail.com', 9824322748, '', '25d55ad283aa400af464c76d713c07ad', 'admin', 'inactive', 'not deleted', '2020-02-11', NULL),
(67, 'Test', 'test@gmail.com', 4567891259, '', '25d55ad283aa400af464c76d713c07ad', 'admin', 'inactive', 'not deleted', '2020-02-11', '2020-03-11');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
