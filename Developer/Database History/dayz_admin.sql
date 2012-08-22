-- MySQL Dump
--
-- Host: localhost    Database: dayz
-- ------------------------------------------------------
-- Server version	5.5.25a

USE `dayz`;



SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";




/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8 */;



--

-- Table structure for table `log_tool`

--



CREATE TABLE IF NOT EXISTS `log_tool` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,

  `action` varchar(255) DEFAULT NULL,

  `user` varchar(255) NOT NULL DEFAULT '',

  `timestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE KEY `id` (`id`)

) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=221 ;



-- 
-- Table structure for table `object_classes`

--



CREATE TABLE IF NOT EXISTS `object_classes` (

  `Classname` varchar(128) NOT NULL DEFAULT '',
  `Type` varchar(128) DEFAULT NULL,

  PRIMARY KEY (`Classname`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--

-- Dumping data for table `object_classes`

--



INSERT INTO `object_classes` (`Classname`, `Type`) VALUES 
('ATV_CZ_EP1', 'ATV'),
('ATV_US_EP1', 'ATV'),
('BAF_Offroad_W', 'Car'),
('car_hatchback', 'Car'),
('car_sedan', 'Car'),
('datsun1_civil_3_open', 'Car'),
('Fishing_Boat', 'large Boat'),
('Hedgehog_DZ', 'Hedgehog'),
('hilux1_civil_1_open', 'Car'),
('hilux1_civil_2_covered', 'Car'),
('hilux1_civil_3_open', 'Car'),
('HMMWV', 'Car'),
('Ikarus', 'Bus'),
('Ikarus_TK_CIV_EP1', 'Bus'),
('Kamaz', 'Truck'),
('LandRover_TK_CIV_EP1', 'Car'),
('MH6J_EP1', 'Helicopter'),
('Old_bike_TK_CIV_EP1', 'Bike'),
('Old_bike_TK_INS_EP1', 'Bike'),
('PBX', 'small Boat'),
('S1203_TK_CIV_EP1', 'Bus'),
('Skoda', 'Car'),
('SkodaBlue', 'Car'),
('SkodaGreen', 'Car'),
('Smallboat_1', 'medium Boat'),
('Smallboat_2', 'medium Boat'),
('SUV_TK_CIV_EP1', 'Car'),
('TentStorage', 'Tent'),
('Tractor', 'Farmvehicle'),
('TT650_Ins', 'Motorcycle'),
('TT650_TK_CIV_EP1', 'Motorcycle'),
('TT650_TK_EP1', 'Motorcycle'),
('UAZ_INS', 'Car'),
('UAZ_RU', 'Car'),
('UAZ_Unarmed_TK_CIV_EP1', 'Car'),
('UAZ_Unarmed_TK_EP1', 'Car'),
('UAZ_Unarmed_UN_EP1', 'Car'),
('UH1H_DZ', 'Helicopter'),
('UralCivil', 'Truck'),
('UralCivil2', 'Truck'),
('V3S_Civ', 'Truck'),
('V3S_Gue', 'Truck'),
('V3S_TK_GUE_EP1', 'Truck'),
('VolhaLimo_TK_CIV_EP1', 'Car'),
('Volha_1_TK_CIV_EP1', 'Car'),
('Volha_2_TK_CIV_EP1', 'Car'),
('VWGolf', 'Car'),
('Wire_cat1', 'Wire');



--
-- Table structure for table `users`

--



CREATE TABLE IF NOT EXISTS `users` (

  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,

  `login` varchar(50) NOT NULL DEFAULT '',

  `password` varchar(32) NOT NULL DEFAULT '',

  `salt` char(3) NOT NULL DEFAULT '',

  `lastlogin` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (`id`),

  UNIQUE KEY `login` (`login`)

) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;



--

-- Dumping data for table `users`

--



INSERT INTO `users` (`id`, `login`, `password`, `salt`, `lastlogin`) VALUES 
(1, 'admin', '4f749f2c908b8ead47c20db6da1b04aa', 'l=i', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
