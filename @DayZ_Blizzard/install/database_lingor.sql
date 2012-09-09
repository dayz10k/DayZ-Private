-- Fresh database dump for Crosire's DayZ Server Controlcenter (dayz_lingor)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `dayz_lingor`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `dayz_lingor` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `dayz_lingor`;

--
-- Table structure for table `instances`
--

DROP TABLE IF EXISTS `instances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instances` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `instance` int(2) unsigned NOT NULL COMMENT 'Identification number for instance',
  `offset` int(1) NOT NULL DEFAULT '0',
  `loadout` varchar(1024) NOT NULL DEFAULT '[]' COMMENT 'Starting inventory for every player. Has to be a valid inventory string to work',
  `mvisibility` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Sets which messages will be executed by the scheduler',
  `whitelist` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instances`
--

LOCK TABLES `instances` WRITE;
/*!40000 ALTER TABLE `instances` DISABLE KEYS */;
INSERT INTO `instances` VALUES (1,1,0,'[]',0,0),(2,2,0,'[]',0,0),(3,3,0,'[]',0,0),(4,4,0,'[]',0,0),(5,5,0,'[]',0,0);
/*!40000 ALTER TABLE `instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_code`
--

DROP TABLE IF EXISTS `log_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_code` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_log_code` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_code`
--

LOCK TABLES `log_code` WRITE;
/*!40000 ALTER TABLE `log_code` DISABLE KEYS */;
INSERT INTO `log_code` VALUES (1,'Login','Player has logged in'),(2,'Logout','Player has logged out'),(3,'Ban','Player was banned'),(4,'Connect','Player has connected'),(5,'Disconnect','Player has disconnected');
/*!40000 ALTER TABLE `log_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_entry`
--

DROP TABLE IF EXISTS `log_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_entry` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(128) NOT NULL DEFAULT '',
  `log_code_id` int(11) unsigned NOT NULL,
  `text` varchar(1024) DEFAULT '',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `instance_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk1_log_entry` (`log_code_id`),
  CONSTRAINT `fk1_log_entry` FOREIGN KEY (`log_code_id`) REFERENCES `log_code` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_entry`
--

LOCK TABLES `log_entry` WRITE;
/*!40000 ALTER TABLE `log_entry` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_entry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_tool`
--

DROP TABLE IF EXISTS `log_tool`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_tool` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) DEFAULT NULL,
  `user` varchar(255) NOT NULL DEFAULT '',
  `timestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_tool`
--

LOCK TABLES `log_tool` WRITE;
/*!40000 ALTER TABLE `log_tool` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_tool` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_schema_log`
--

DROP TABLE IF EXISTS `migration_schema_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_schema_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `schema_name` varchar(255) NOT NULL,
  `event_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `old_version` varchar(255) NOT NULL,
  `new_version` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_schema_log`
--

LOCK TABLES `migration_schema_log` WRITE;
/*!40000 ALTER TABLE `migration_schema_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `migration_schema_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_schema_version`
--

DROP TABLE IF EXISTS `migration_schema_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_schema_version` (
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_schema_version`
--

LOCK TABLES `migration_schema_version` WRITE;
/*!40000 ALTER TABLE `migration_schema_version` DISABLE KEYS */;
INSERT INTO `migration_schema_version` VALUES ('Bliss','0.130000');
/*!40000 ALTER TABLE `migration_schema_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objects`
--

DROP TABLE IF EXISTS `objects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) NOT NULL DEFAULT '0' COMMENT 'Object game generated ID',
  `pos` varchar(255) NOT NULL DEFAULT '[]' COMMENT 'Postition of the object',
  `inventory` varchar(2048) NOT NULL DEFAULT '[]',
  `health` varchar(1024) NOT NULL DEFAULT '[]' COMMENT 'Broken parts of the object',
  `fuel` double NOT NULL DEFAULT '0' COMMENT 'Ammount of fuel. 0-1',
  `damage` double NOT NULL DEFAULT '0' COMMENT 'Overall damage value. 0-1',
  `otype` varchar(255) NOT NULL DEFAULT 'none' COMMENT 'Type of the object',
  `oid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Owner of the object. Only relevant for tents',
  `instance` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Instance number in which object resides',
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last update to the object',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx1_objects` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objects`
--

LOCK TABLES `objects` WRITE;
/*!40000 ALTER TABLE `objects` DISABLE KEYS */;
/*!40000 ALTER TABLE `objects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objects_classes`
--

DROP TABLE IF EXISTS `objects_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objects_classes` (
  `Classname` varchar(128) NOT NULL DEFAULT '',
  `Type` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`Classname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objects_classes`
--

LOCK TABLES `objects_classes` WRITE;
/*!40000 ALTER TABLE `objects_classes` DISABLE KEYS */;
INSERT INTO `objects_classes` VALUES ('ATV_CZ_EP1','ATV'),('ATV_US_EP1','ATV'),('BAF_Offroad_W','Car'),('car_hatchback','Car'),('car_sedan','Car'),('datsun1_civil_3_open','Car'),('Fishing_Boat','large Boat'),('Hedgehog_DZ','Hedgehog'),('hilux1_civil_1_open','Car'),('hilux1_civil_2_covered','Car'),('hilux1_civil_3_open','Car'),('HMMWV','Car'),('Ikarus','Bus'),('Ikarus_TK_CIV_EP1','Bus'),('Kamaz','Truck'),('LandRover_TK_CIV_EP1','Car'),('MH6J_EP1','Helicopter'),('Old_bike_TK_CIV_EP1','Bike'),('Old_bike_TK_INS_EP1','Bike'),('PBX','small Boat'),('S1203_TK_CIV_EP1','Bus'),('Skoda','Car'),('SkodaBlue','Car'),('SkodaGreen','Car'),('Smallboat_1','medium Boat'),('Smallboat_2','medium Boat'),('SUV_TK_CIV_EP1','Car'),('TentStorage','Tent'),('Tractor','Farmvehicle'),('TT650_Ins','Motorcycle'),('TT650_TK_CIV_EP1','Motorcycle'),('TT650_TK_EP1','Motorcycle'),('UAZ_INS','Car'),('UAZ_RU','Car'),('UAZ_Unarmed_TK_CIV_EP1','Car'),('UAZ_Unarmed_TK_EP1','Car'),('UAZ_Unarmed_UN_EP1','Car'),('UH1H_DZ','Helicopter'),('UralCivil','Truck'),('UralCivil2','Truck'),('V3S_Civ','Truck'),('V3S_Gue','Truck'),('V3S_TK_GUE_EP1','Truck'),('VolhaLimo_TK_CIV_EP1','Car'),('Volha_1_TK_CIV_EP1','Car'),('Volha_2_TK_CIV_EP1','Car'),('VWGolf','Car'),('Wire_cat1','Wire');
/*!40000 ALTER TABLE `objects_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(128) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT '',
  `humanity` int(6) NOT NULL DEFAULT '2500',
  `survival_attempts` int(3) unsigned NOT NULL DEFAULT '1',
  `total_survival_time` int(5) unsigned NOT NULL DEFAULT '0',
  `total_survivor_kills` int(4) unsigned NOT NULL DEFAULT '0',
  `total_bandit_kills` int(4) unsigned NOT NULL DEFAULT '0',
  `total_zombie_kills` int(5) unsigned NOT NULL DEFAULT '0',
  `total_headshots` int(5) unsigned NOT NULL DEFAULT '0',
  `is_whitelisted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_profile` (`unique_id`),
  KEY `idx2_profile` (`is_whitelisted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduler`
--

DROP TABLE IF EXISTS `scheduler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scheduler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(1024) NOT NULL COMMENT 'Text of the message',
  `mtype` varchar(1) NOT NULL DEFAULT 'm' COMMENT 'Type of the message: g Global, m Side, l Logic, s Script',
  `looptime` int(3) unsigned NOT NULL DEFAULT '0' COMMENT 'The time delay before the message is executed again. 0 means message will be executed only ones',
  `mstart` int(3) unsigned NOT NULL DEFAULT '10' COMMENT 'The time before the message is processed in seconds',
  `visibility` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Set on which instance message will be executed',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduler`
--

LOCK TABLES `scheduler` WRITE;
/*!40000 ALTER TABLE `scheduler` DISABLE KEYS */;
INSERT INTO `scheduler` VALUES (1,'This Server is managed through Crosires Private Server Controlcenter! Have fun!','l',0,3,0);
/*!40000 ALTER TABLE `scheduler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spawns`
--

DROP TABLE IF EXISTS `spawns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spawns` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `pos` varchar(128) NOT NULL COMMENT 'Spawn location',
  `otype` varchar(128) NOT NULL DEFAULT 'Smallboat_1' COMMENT 'Type of the spawning object',
  `uuid` int(2) unsigned NOT NULL,
  `world` varchar(50) NOT NULL DEFAULT 'chernarus',
  `chance` decimal(4,4) unsigned NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=196 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spawns`
--

LOCK TABLES `spawns` WRITE;
/*!40000 ALTER TABLE `spawns` DISABLE KEYS */;
INSERT INTO `spawns` VALUES (248,'[137,[3800.27,2307.3,4.6834]]','Fishing_Boat',7636081,'lingor',0.5500),(247,'[4,[4401.8,1702.02,0.121414]]','V3S_Civ',7632814,'lingor',0.5500),(246,'[167,[13367.5,6601.11,0.0126638]]','S1203_TK_CIV_EP1',7575100,'lingor',0.5500),(245,'[3,[5796.71,4721.43,0.00143814]]','S1203_TK_CIV_EP1',7535863,'lingor',0.5500),(244,'[5,[4198.66,4442.61,0.00143814]]','S1203_TK_CIV_EP1',7497356,'lingor',0.5500),(243,'[285,[4290.23,4935.53,0.00152206]]','S1203_TK_CIV_EP1',7469049,'lingor',0.5500),(242,'[317,[2645.8,6945.16,0.00143909]]','Tractor',7339114,'lingor',0.7500),(241,'[89,[7971.34,1091.71,0.00143909]]','Tractor',7311582,'lingor',0.7500),(240,'[272,[2837.28,5328.06,0.373938]]','TT650_TK_CIV_EP1',7235098,'lingor',0.7000),(239,'[9,[6472.64,5970.13,0]]','Ikarus_TK_CIV_EP1',7016936,'lingor',0.5500),(238,'[9,[6572.64,5970.13,0]]','Ikarus',6638577,'lingor',0.5500),(237,'[209,[835.536,5520.96,7.97942]]','Ikarus_TK_CIV_EP1',6511235,'lingor',0.5500),(236,'[180,[5775.69,4724.98,0.00143814]]','Ikarus',6492547,'lingor',0.5500),(235,'[79,[3572.71,1374.62,0.00143909]]','Ikarus',6320860,'lingor',0.5500),(234,'[79,[3472.71,1374.62,0.00143909]]','Ikarus_TK_CIV_EP1',6093204,'lingor',0.5500),(233,'[274,[6863.03,4451.83,0.00143814]]','UH1H_DZ',5825353,'lingor',0.2500),(232,'[89,[6597.37,6767.08,0]]','UH1H_DZ',5769153,'lingor',0.2500),(231,'[168,[602.249,4686.56,6.81655]]','UH1H_DZ',5688809,'lingor',0.2500),(230,'[18,[3956.76,4229.46,0.00143433]]','UH1H_DZ',5640172,'lingor',0.2500),(229,'[5,[3360.08,1126.39,0.00143862]]','UH1H_DZ',5591243,'lingor',0.2500),(228,'[94,[621.466,4631.81,0.00143814]]','Volha_2_TK_CIV_EP1',5574573,'lingor',0.5500),(227,'[9,[6593.81,5728.57,0]]','SUV_TK_CIV_EP1',5499609,'lingor',0.4500),(226,'[0,[969.451,1275.39,0.00255895]]','ATV_CZ_EP1',5468412,'lingor',0.7000),(225,'[0,[5671.37,796.868,0.00129175]]','Old_bike_TK_CIV_EP1',5222930,'lingor',0.9500),(224,'[279,[5796.81,4688.25,0.00143814]]','Old_bike_TK_INS_EP1',5172558,'lingor',0.9500),(223,'[10,[8819.02,8023.86,0.00143814]]','Old_bike_TK_CIV_EP1',5146500,'lingor',0.9500),(222,'[163,[5985.63,5351.37,0.00143909]]','hilux1_civil_3_open_EP1',5075087,'lingor',0.5500),(221,'[184,[3551.31,3739.72,0.0010376]]','Old_bike_TK_INS_EP1',5004305,'lingor',0.9500),(220,'[254,[3933.37,4220.77,0.00143433]]','Old_bike_TK_INS_EP1',4917659,'lingor',0.9500),(219,'[310,[1967.18,9147.22,0.00106812]]','LandRover_CZ_EP1',4913990,'lingor',0.5500),(218,'[90,[6821.08,2497.89,0.00143909]]','UralCivil2',4885355,'lingor',0.5500),(217,'[271,[6424,6777.25,0.00143909]]','hilux1_civil_3_open_EP1',4839368,'lingor',0.5500),(216,'[97,[4589.57,2616.75,0.00136948]]','TT650_TK_CIV_EP1',4631620,'lingor',0.7000),(215,'[179,[5802.9,4712.73,0.00143814]]','TT650_TK_CIV_EP1',3281806,'lingor',0.7000),(214,'[-209,[6592.686, 2906.8245,0]]','TT650_TK_EP1',3224021,'lingor',0.7000),(213,'[267,[4080.74,1130.51,0.00143909]]','TT650_Ins',3094055,'lingor',0.7000),(212,'[323,[1199.85,5270.49,10.8326]]','ATV_US_EP1',3032853,'lingor',0.7000),(211,'[208,[1748.81,642.642,14.1062]]','UH1H_DZ',2889931,'lingor',0.2500),(210,'[0,[6115.49,5859.39,0]]','Skoda',2819485,'lingor',0.6500),(209,'[3,[5805.57,4727.47,0.00143814]]','SkodaBlue',2732512,'lingor',0.6500),(208,'[51,[5927.38,6616.12,0.00140476]]','ATV_CZ_EP1',2097619,'lingor',0.7000),(207,'[75,[3287.92,6434.28,0.00110245]]','ATV_US_EP1',1817908,'lingor',0.7000),(206,'[186,[3546.66,3740.02,0.00143433]]','ATV_CZ_EP1',1704164,'lingor',0.7000),(205,'[17,[5968.15,6595.98,0.00117016]]','ATV_US_EP1',1624318,'lingor',0.7000),(204,'[355,[6888.25,3147.13,0.00132751]]','ATV_US_EP1',1620134,'lingor',0.7000),(203,'[9,[6457.83,6660.57,0]]','SUV_TK_CIV_EP1',1600270,'lingor',0.4500),(202,'[177,[4073.41,5156.29,0.00143814]]','UAZ_INS',1597984,'lingor',0.6500),(201,'[87,[2476.24,4105.05,0.00119781]]','UAZ_Unarmed_TK_CIV_EP1',1461138,'lingor',0.6500),(200,'[5,[4150.78,1426.02,0.0821762]]','UAZ_RU',1418552,'lingor',0.6500),(199,'[271,[6424,6777.25,0.00143909]]','UAZ_Unarmed_UN_EP1',1391556,'lingor',0.6500),(198,'[3,[7107.41,5825.43,0]]','UAZ_Unarmed_TK_CIV_EP1',1379054,'lingor',0.6500),(197,'[130,[13129.8,11560,0.0706997]]','UAZ_Unarmed_TK_EP1',1303114,'lingor',0.6500),(249,'[137,[3700.27,2307.3,4.6834]]','Fishing_Boat',7931058,'lingor',0.5500),(250,'[291,[5873.05,5326.02,0.00148487]]','PBX',8076073,'lingor',0.5500),(251,'[147,[8433.71,7797.2,2.1895]]','Smallboat_1',8083737,'lingor',0.5500),(252,'[310,[3822.1,2299.23,0.000923157]]','Smallboat_1',8387143,'lingor',0.5500),(253,'[94,[621.466,4631.81,0.00143814]]','Volha_2_TK_CIV_EP1',8560255,'lingor',0.5500),(254,'[272,[6827.53,5927.34,0.00143909]]','Volha_1_TK_CIV_EP1',8611345,'lingor',0.5500),(255,'[356,[8039.13,2916.39,0.00257635]]','Volha_1_TK_CIV_EP1',8625660,'lingor',0.5500),(256,'[274,[3697.02,1404.02,0.00143909]]','Volha_2_TK_CIV_EP1',8875184,'lingor',0.5500),(257,'[260,[8299.95,2358.95,1.28169]]','Volha_1_TK_CIV_EP1',9212090,'lingor',0.5500),(258,'[47,[4149.76,1537.27,0.0821762]]','Volha_2_TK_CIV_EP1',9575283,'lingor',0.5500),(259,'[183,[5784.84,4712.17,0.00143814]]','SUV_TK_CIV_EP1',9642843,'lingor',0.4500),(260,'[222,[12360.468,10817.882,0]]','car_sedan',9752273,'lingor',0.7500),(261,'[273,[8842.5,921.916,0.00130701]]','Fishing_Boat',9791945,'lingor',0.5500),(262,'[249,[7563.33,1693.72,0.00143909]]','UAZ_Unarmed_TK_EP1',9936994,'lingor',0.6500),(263,'[195,[6800.51,2828.05,0.00150663]]','Fishing_Boat',9938094,'lingor',0.5500);
/*!40000 ALTER TABLE `spawns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survivor`
--

DROP TABLE IF EXISTS `survivor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `survivor` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(128) NOT NULL,
  `pos` varchar(255) NOT NULL DEFAULT '[]' COMMENT 'Position of the player. [] means random at the beach',
  `inventory` varchar(2048) NOT NULL DEFAULT '[]',
  `backpack` varchar(2048) NOT NULL DEFAULT '[]',
  `medical` varchar(255) NOT NULL DEFAULT '[false,false,false,false,false,false,false,12000,[],[0,0],0]',
  `is_dead` int(1) unsigned NOT NULL DEFAULT '0',
  `model` varchar(128) NOT NULL DEFAULT 'Survivor2_DZ' COMMENT 'Model of the player',
  `state` varchar(128) NOT NULL DEFAULT '["","aidlpercmstpsnonwnondnon_player_idlesteady04",36]',
  `survivor_kills` int(3) unsigned NOT NULL DEFAULT '0',
  `bandit_kills` int(3) unsigned NOT NULL DEFAULT '0',
  `zombie_kills` int(4) unsigned NOT NULL DEFAULT '0',
  `headshots` int(4) unsigned NOT NULL DEFAULT '0',
  `last_ate` int(3) unsigned NOT NULL DEFAULT '0',
  `last_drank` int(3) unsigned NOT NULL DEFAULT '0',
  `survival_time` int(3) unsigned NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `start_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx1_main` (`unique_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survivor`
--

LOCK TABLES `survivor` WRITE;
/*!40000 ALTER TABLE `survivor` DISABLE KEYS */;
/*!40000 ALTER TABLE `survivor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `salt` char(3) NOT NULL DEFAULT '',
  `permissions` varchar(50) NOT NULL DEFAULT 'map,list,control,user',
  `lastlogin` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','4f749f2c908b8ead47c20db6da1b04aa','l=i','map,list,control,user',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'dayz_chernarus'
--
/*!50003 DROP PROCEDURE IF EXISTS `proc_checkWhitelist` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_checkWhitelist`(in p_instanceId int, in p_uniqueId varchar(128))
begin
  select
    if(i.whitelist = 1, is_whitelisted, 1)
  from
    profile p
    join instances i on i.instance = p_instanceId
  where
    p.unique_id = p_uniqueId; --
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_deleteObject` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_deleteObject`(in `p_uniqueId` varchar(128))
begin
  delete from objects where uid = p_uniqueid; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_getInstanceLoadout` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_getInstanceLoadout`(in `p_instanceId` int)
begin
  select loadout from instances where instance = p_instanceId; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_getInstanceTime` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_getInstanceTime`(in `p_instanceId` int)
begin
  declare server_time datetime default now(); 
  select now() + interval (offset) hour into server_time from instances where instance = p_instanceid; 
  select date_format(server_time,'%d-%m-%y'), time_format(server_time, '%T'); 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_getObjectPageCount` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_getObjectPageCount`(in `p_instanceId` int)
begin
  declare itemsPerPage int default 5; 
  select floor(count(*) / itemsPerPage) + if((count(*) mod itemsPerPage) > 0, 1, 0) from objects where instance = p_instanceId; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_getObjects` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_getObjects`(in `p_instanceId` int, in `p_currentPage` int)
begin
  set @instance = p_instanceId; 
  set @page = greatest(((p_currentPage - 1) * 5), 0); 
  prepare stmt from 'select id,otype,oid,pos,inventory,health,fuel,damage from objects where instance = ? limit ?, 5'; 
  execute stmt using @instance, @page; 
  deallocate prepare stmt; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_getSchedulerTaskPageCount` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_getSchedulerTaskPageCount`(in `p_instanceId` int)
begin
  declare itemsPerPage int default 10; 
  select
    floor(count(*) / itemsPerPage) + if((count(*) mod itemsPerPage) > 0, 1, 0)
  from
    scheduler
    join instances on instances.mvisibility = scheduler.visibility
  where
    instances.instance = p_instanceId; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_getSchedulerTasks` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_getSchedulerTasks`(in `p_instanceId` int, in `p_currentPage` int)
begin
  set @instance = p_instanceId; 
  set @page = greatest(((p_currentPage - 1) * 10), 0); 
  prepare stmt from 'select message,mtype,looptime,mstart from scheduler s join instances i on i.mvisibility = s.visibility where i.instance = ? limit ?, 10'; 
  execute stmt using @instance, @page; 
  deallocate prepare stmt; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_getSurvivorStats` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_getSurvivorStats`(in `p_survivorId` int)
begin
  select
    medical, pos, zombie_kills, state, p.humanity, headshots, survivor_kills, bandit_kills
  from
    survivor s
    inner join profile p on s.unique_id = p.unique_id
  where
    s.id = p_survivorId
    and s.is_dead = 0; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_insertObject` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_insertObject`(in `p_uniqueId` varchar(255), in `p_type` varchar(255), in `p_health` varchar(1024), in `p_damage` double, in `p_fuel` double, in `p_owner` int, in `p_position` varchar(255), in `p_instanceId` int)
begin
  insert into objects
    (uid,otype,health,damage,oid,pos,fuel,instance,created)
  values
    (p_uniqueId, p_type, p_health, p_damage, p_owner, p_position, p_fuel, p_instanceId, CURRENT_TIMESTAMP()); --
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_insertSurvivor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_insertSurvivor`(in `p_uniqueId` varchar(128), in `p_playerName` varchar(255))
begin
  insert into profile
    (unique_id, name)
  values
    (p_uniqueId, p_playerName)
  on duplicate key update name = p_playerName; 
  insert into survivor
    (unique_id, start_time)
  values
    (p_uniqueId, now()); 
  select last_insert_id(); 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_killSurvivor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_killSurvivor`(in `p_survivorId` int)
begin
  update survivor set is_dead = 1 where id = p_survivorId; 
  update
    profile
    left join survivor on survivor.unique_id = profile.unique_id
  set
    survival_attempts=survival_attempts+1,
    total_survivor_kills=total_survivor_kills+survivor_kills,
    total_bandit_kills=total_bandit_kills+bandit_kills,
    total_zombie_kills=total_zombie_kills+zombie_kills,
    total_headshots=total_headshots+headshots,
    total_survival_time=total_survival_time+survival_time
  where
    survivor.id = p_survivorId; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_loginSurvivor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_loginSurvivor`(in `p_uniqueId` varchar(128), in `p_playerName` varchar(128))
begin 
  update profile set name = p_playerName where unique_id = p_uniqueId; --
  update survivor set state = '["","aidlpercmstpsnonwnondnon_player_idlesteady04",36]' where unique_id = p_uniqueId and state like '%_driver"' or state like '%_pilot"'; --
  select
    id, inventory, backpack, floor(time_to_sec(timediff(now(), start_time)) / 60), model, last_ate, last_drank
  from survivor
  where
    survivor.unique_id = p_uniqueId
    and is_dead = 0; --
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_loglogin` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_loglogin`(in `p_uniqueId` varchar(128), in `p_instanceId` int)
begin
  insert into log_entry (unique_id, instance_id, log_code_id) values (p_uniqueId, p_instanceId, 1); 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_loglogout` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_loglogout`(in `p_uniqueId` varchar(128), in `p_instanceId` int)
begin
  insert into log_entry (unique_id, instance_id, log_code_id) values (p_uniqueId, p_instanceId, 2); 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_updateObject` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_updateObject`(in `p_uniqueId` varchar(128), in `p_type` varchar(255) , in `p_position` varchar(255), in `p_health` varchar(1024))
begin
  update objects set
    otype = if(p_type = '', otype, p_type),
    health = p_health,
    pos = if(p_position = '[]', pos, p_position)
  where
    uid = p_uniqueId; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_updateObjectHealth` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_updateObjectHealth`(in `p_objectId` int, in `p_health` varchar(1024), in `p_damage` double)
begin
  update objects set
    health = p_health,
    damage = p_damage
  where
    id = p_objectId; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_updateObjectInventory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_updateObjectInventory`(in `p_objectId` int, in `p_inventory` varchar(1024))
begin
  update objects set
    inventory = p_inventory
  where
    id = p_objectId; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_updateObjectInventoryByUID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_updateObjectInventoryByUID`(in `p_uniqueId` varchar(128), in `p_inventory` varchar(8192))
begin
  update objects set
    inventory = p_inventory
  where
    uid not like '%.%'
    and (convert(uid, unsigned integer) between (convert(p_uniqueId, unsigned integer) - 2) and (convert(p_uniqueId, unsigned integer) + 2)); 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_updateObjectPosition` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_updateObjectPosition`(in `p_objectId` int, in `p_position` varchar(255), in `p_fuel` double)
begin
  update objects set
    pos = if(p_position = '[]', pos, p_position),
    fuel = p_fuel
  where
    id = p_objectId; 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_updateSurvivor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `proc_updateSurvivor`(in `p_survivorId` int, in `p_position` varchar(1024), in `p_inventory` varchar(2048), in `p_backpack` varchar(2048), in `p_medical` varchar(1024), in `p_lastAte` int, in `p_lastDrank` int, in `p_survivalTime` int, in `p_model` varchar(255), in `p_humanity` int, in `p_zombieKills` int, in `p_headshots` int, in `p_murders` int, in `p_banditKills` int, in `p_state` varchar(255))
begin
  update
    profile p
    inner join survivor s on s.unique_id = p.unique_id
  set
    p.humanity = if(p_humanity = 0, humanity, p_humanity)
  where
    s.id = p_survivorId; --

  update survivor set
    zombie_kills = zombie_kills + p_zombieKills,
    headshots = headshots + p_headshots,
    bandit_kills = bandit_kills + p_banditKills,
    survivor_kills = survivor_kills + p_murders,
    state = p_state,
    model = if(p_model = 'any', model, p_model),
    last_ate = if(p_lastAte = -1, 0, last_ate + p_lastAte),
    last_drank = if(p_lastDrank = -1, 0, last_drank + p_lastDrank),
    survival_time = survival_time + p_survivalTime,
    pos = if(p_position = '[]', pos, p_position),
    medical = if(p_medical = '[]', medical, p_medical),
    backpack = if(p_backpack='[]', backpack, p_backpack),
    inventory = if(p_inventory='[]', inventory, p_inventory)
  where
    id = p_survivorId; --
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-09-08 21:29:25
