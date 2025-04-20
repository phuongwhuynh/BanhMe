-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: banh_mi_db
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts` (
  `user_id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `status` enum('active','deleted') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (2,'user','$2y$10$NqkbzWKQR2so9GuA4j7KgOk2KYlcborsg9ObwtXsSL8vBEG.MecLa','user','active'),(3,'admin','$2a$10$l1YwamIKF6FTsbzJ86WFW.HRWqBzccwiv88qRovaucD.D2B51jZm.','admin','active');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `in_cart`
--

DROP TABLE IF EXISTS `in_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `in_cart` (
  `user_id` int unsigned NOT NULL,
  `item_id` int unsigned NOT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`user_id`,`item_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `in_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `in_cart_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu` (`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `in_cart`
--

LOCK TABLES `in_cart` WRITE;
/*!40000 ALTER TABLE `in_cart` DISABLE KEYS */;
INSERT INTO `in_cart` VALUES (2,15,1);
/*!40000 ALTER TABLE `in_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `item_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `cate` enum('sweet','savory','raw') NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `image_path` varchar(512) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('active','delete') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`item_id`),
  CONSTRAINT `menu_chk_1` CHECK ((`price` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Bánh Mì Pa Tê Chả Lụa','savory','Bánh mì thơm giòn kết hợp với pa tê béo ngậy và chả lụa mềm mịn, thêm dưa leo, rau thơm và nước sốt đặc trưng.','images/banh_mi_pate_cha_lua.jpg',15000.00,'active'),(2,'Bánh Mì Thịt Nướng','savory','Bánh mì truyền thống với thịt nướng thơm lừng, rau sống tươi mát, đồ chua giòn giòn và nước sốt đậm đà.','images/banh_mi_thit_nuong.jpg',30000.00,'active'),(3,'Bánh Mì Chả Cá','savory','Bánh mì nóng giòn kẹp chả cá chiên vàng ruộm, ăn kèm với rau thơm, dưa leo và tương ớt cay nồng.','images/banh_mi_cha_ca.jpg',15000.00,'active'),(4,'Bánh Mì Heo Quay','savory','Thịt heo quay giòn bì, mềm ngọt bên trong, kết hợp với dưa leo, hành ngò và nước sốt đặc biệt trong ổ bánh mì giòn rụm.','images/banh_mi_heo_quay.jpg',30000.00,'active'),(5,'Bánh Mì Xíu Mại','savory','Bánh mì kẹp xíu mại viên mềm, sốt cà chua đậm đà, thêm hành ngò tạo hương vị thơm ngon khó cưỡng.','images/banh_mi_xiu_mai.jpg',30000.00,'active'),(6,'Bánh Mì Nướng Bơ Tỏi','savory','Bánh mì nướng giòn thấm đẫm bơ và tỏi thơm lừng, thích hợp làm món ăn vặt hấp dẫn.','images/banh_mi_nuong_bo_toi.jpeg',30000.00,'active'),(7,'Bánh Mì Chấm Sữa Đặc','sweet','Bánh mì giòn chấm sữa đặc béo ngậy, món ăn tuổi thơ gợi nhớ những ký ức đẹp.','images/banh_mi_cham_sua_dac.png',10000.00,'active'),(8,'Bánh Mì Chảo','savory','Bánh mì ăn kèm với chảo topping đa dạng như pate, trứng ốp la, xúc xích, thịt nguội và nước sốt đậm đà.','images/banh_mi_chao.jpg',40000.00,'active'),(9,'Bánh Mì Cay Hải Phòng','savory','Bánh mì mini giòn tan với nhân pate cay nồng, một đặc sản nổi tiếng của Hải Phòng.','images/banh_mi_cay_hai_phong.jpg',15000.00,'active'),(10,'Bánh Mì Bột Lọc','savory','Bánh mì kẹp bánh bột lọc dai dai, nhân tôm thịt đậm đà, hòa quyện với nước mắm chua ngọt.','images/banh_mi_bot_loc.jpg',25000.00,'active'),(11,'Bánh Mì Ép Huế','savory','Bánh mì ép giòn rụm, kẹp thịt, pate và rau, được ép nóng để tạo độ giòn đặc trưng.','images/banh_mi_ep_hue.jpg',10000.00,'active'),(12,'Bánh Mì Gà Xé Đà Nẵng','savory','Bánh mì Đà Nẵng với gà xé thơm ngon, rau răm, hành phi và nước sốt cay ngọt hấp dẫn.','images/banh_mi_ga_xe_da_nang.jpg',20000.00,'active'),(13,'Bánh Mì Phá Lấu','savory','Bánh mì kẹp phá lấu béo bùi, nước sốt đậm vị, ăn kèm dưa leo và rau thơm.','images/banh_mi_pha_lau.jpg',30000.00,'active'),(14,'Bánh Mì Hoa Cúc','sweet','Kết cấu mềm, xốp, có bơ thơm béo','images/banh_mi_hoa_cuc.jpg',30000.00,'active'),(15,'Bánh Mì Bơ Đường','sweet','Lớp bơ và đường tan chảy trên mặt bánh tạo độ giòn nhẹ','images/banh_mi_bo_duong.jpg',30000.00,'active'),(16,'Bánh mì nhân kem','sweet','Nhân kem trứng mịn, béo ngậy, có vị sữa dừa','images/banh_mi_nhan_kem.jpg',20000.00,'active'),(17,'Bánh mì nho khô','sweet','Bánh mì mềm kết hợp với vị chua ngọt nhẹ của nho khô','images/banh_mi_nho_kho.png',20000.00,'active'),(18,'Bánh mì kẹp kem','sweet','Sự kết hợp giữa bánh mì giòn rụm và kem lạnh mát, tạo nên sự hòa quyện giữa nóng - lạnh, giòn - mềm vô cùng thú vị','images/banh_mi_kep_kem.jpg',15000.00,'active');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` int unsigned NOT NULL AUTO_INCREMENT,
  `total_price` decimal(12,0) DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,45000,2,'2025-04-20 06:06:40'),(2,70000,2,'2025-04-20 06:06:58'),(3,40000,2,'2025-04-20 06:07:09'),(4,20000,2,'2025-04-20 06:07:21'),(5,295000,2,'2025-04-20 06:07:48'),(6,160000,2,'2025-04-20 06:08:21'),(7,70000,2,'2025-04-20 06:08:40'),(8,70000,2,'2025-04-20 06:08:55'),(9,25000,2,'2025-04-20 06:09:08');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_include_items`
--

DROP TABLE IF EXISTS `orders_include_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_include_items` (
  `order_id` int unsigned NOT NULL,
  `item_id` int unsigned NOT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`order_id`,`item_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `orders_include_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `orders_include_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu` (`item_id`),
  CONSTRAINT `orders_include_items_chk_1` CHECK ((`quantity` > 0))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_include_items`
--

LOCK TABLES `orders_include_items` WRITE;
/*!40000 ALTER TABLE `orders_include_items` DISABLE KEYS */;
INSERT INTO `orders_include_items` VALUES (1,9,1),(1,15,1),(2,8,1),(2,11,3),(3,8,1),(4,16,1),(5,6,2),(5,13,3),(5,14,3),(5,16,1),(5,17,1),(5,18,1),(6,2,1),(6,4,1),(6,5,1),(6,6,1),(6,8,1),(7,8,1),(7,15,1),(8,4,1),(8,8,1),(9,3,1),(9,11,1);
/*!40000 ALTER TABLE `orders_include_items` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `update_total_price` AFTER INSERT ON `orders_include_items` FOR EACH ROW BEGIN
    UPDATE orders 
    SET total_price = (
        SELECT SUM(quantity * price) 
        FROM orders_include_items oi
        JOIN menu m ON oi.item_id = m.item_id
        WHERE oi.order_id = NEW.order_id
    )
    WHERE order_id = NEW.order_id;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'banh_mi_db'
--

--
-- Dumping routines for database 'banh_mi_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-20 18:55:02
