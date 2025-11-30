/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: locatera
-- ------------------------------------------------------
-- Server version	10.11.13-MariaDB-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) NOT NULL,
  `product_name_snapshot` varchar(255) NOT NULL,
  `variant_name_snapshot` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES
(8,'#LOC251130103354','Cheesecuit','Red Velvet',3,58800.00);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `shipping_fee` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES
('#LOC251130103354','2025-11-30',191400.00,'Selesai','2025-12-03',15000.00);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variants`
--

DROP TABLE IF EXISTS `product_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_variants` (
  `variant_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `variant_name` varchar(100) NOT NULL,
  PRIMARY KEY (`variant_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variants`
--

LOCK TABLES `product_variants` WRITE;
/*!40000 ALTER TABLE `product_variants` DISABLE KEYS */;
INSERT INTO `product_variants` VALUES
(1,1,'Original'),
(2,1,'Matcha'),
(3,1,'Cookies n Cream'),
(4,2,'Mix Fruit'),
(5,2,'Strawberry'),
(6,2,'Tiramisu'),
(7,2,'Durian'),
(8,2,'Green Tea'),
(9,2,'Double Cheese'),
(10,2,'Choco Crunchy'),
(11,2,'Red Velvet'),
(12,3,'Original'),
(13,3,'Tiramisu'),
(14,3,'Choco Marble'),
(15,3,'Cheese Cream'),
(16,3,'Pink Marble'),
(17,3,'Green Tea Mint'),
(18,3,'Chese Cream'),
(19,3,'Banana Cheese'),
(20,4,'Peanut'),
(21,4,'Mung Bean'),
(22,4,'Red Bean'),
(23,4,'Savory Beef'),
(24,4,'Calleebaut Chocolate'),
(25,4,'Cranberry Creamcheese'),
(26,8,'Original'),
(27,8,'Spicy'),
(28,8,'Cheese'),
(29,8,'BBQ'),
(30,11,'Original'),
(31,11,'Coklat'),
(32,11,'Keju'),
(33,11,'Matcha'),
(34,11,'Strawberry'),
(35,11,'Red Velvet'),
(36,11,'Green Tea'),
(37,11,'Tiramisu'),
(38,11,'Kacang'),
(39,15,'Bolu Pisang Kacang'),
(40,15,'Bolu Pisang Coklat'),
(41,15,'Bolu Pisang Strawberry'),
(42,15,'Bolu Pisang Keju'),
(43,16,'Strawberry'),
(44,16,'Mango'),
(45,16,'Lychee'),
(46,16,'Avocado'),
(47,16,'Mixed Fruit');
/*!40000 ALTER TABLE `product_variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES
(1,'Tiramisusu','./src/asset/tiramisusu matcha bg.png',4.5,124000.00,'Makanan Basah','Cake oleh-oleh khas Bandung, dengan creame matcha yang lumer dan taburan crumble crunchy diatasnya. perpaduan 7 layers of happiness yang perfect & balance'),
(2,'Cheesecuit','./src/asset/cheesecuit bg.png',4.5,58800.00,'Makanan Basah','Perpaduan creame cheese yang melimpah dan biskuit premium ditambah dengan topping strawberry'),
(3,'Amanda','./src/asset/amanda.png',4.8,53000.00,'Makanan Basah','Kue brownis kukus yang memiliki 3 lapisan lembut dengan rasa coklat yang kuat, manis, gurih, dan sedikit pahit khas mocca'),
(4,'Rochi','./src/asset/rochi bg.png',4.9,36480.00,'Makanan Basah','Roti mochi panggang asal Bandung yang terkenal dengan tekturnya yang lembut dengan isian mochi kenyal didalamnya.'),
(5,'Kopi Aroma','./src/asset/kopi-aroma.png',4.7,40000.00,'Minuman','Kopi legendaris dari Bandung yang telah berdiri sejak tahun 1930, terkenal dengan proses pengolahan tradisionalnya yang mempertahankan cita rasa khas.'),
(6,'Bajigur Hanjuang','./src/asset/bajigur.png',4.6,16000.00,'Minuman','Minuman tradisional priangan dengan bahan utama gula palem, dilengkapi krimer dan vanilla sehingga menghasilkan rasa dan aroma yang khas'),
(7,'Bandung Kunafe','./src/asset/bandung kunafe bg.png',4.6,123000.00,'Makanan Basah','Oleh-oleh khas Bandung berupa kue lembut dengan tekstur japanese cake yang empuk dan dilapisi cream serta taburan remahan pastry atau keju.'),
(8,'Batagor riri','./src/asset/batagor riri bg.png',4.8,115000.00,'Makanan Kering','Batagor frozen siap goreng dengan isian ikan tenggiri asli yang gurih dan kenyal, cocok dinikmati sebagai camilan atau lauk pendamping nasi.'),
(9,'⁠Pisang Bollen Kartikasari','./src/asset/bollen kartiksari bg.png',4.6,43000.00,'Makanan Kering','Pisang bollen premium dengan isian pisang dan cokelat lumer, yang cocok dinikmati sebagai camilan spesial atau oleh-oleh.'),
(10,'Keripik Tempe','./src/asset/keripik tempe bg.png',4.6,35000.00,'Makanan Kering','Keripik tempe gurih dan renyah, terbuat dari tempe pilihan yang diiris tipis dan digoreng hingga kering, cocok sebagai camilan sehat.'),
(11,'Kue Balok Boga Rasa','./src/asset/kue balok bg.png',4.6,49000.00,'Makanan Basah','Kue balok premium dengan tekstur lembut dan isian cokelat lumer, yang cocok dinikmati sebagai camilan spesial atau oleh-oleh.'),
(12,'Rangginang','./src/asset/rengginang bg.png',4.6,38000.00,'Makanan Kering','Rangginang gurih dan renyah, terbuat dari beras ketan pilihan yang dibentuk dan digoreng hingga kering, cocok sebagai camilan tradisional.'),
(13,'Seblak Bandung Asli','./src/asset/seblak instant bdg.png',4.8,23000.00,'Makanan Kering','Seblak instan khas Bandung dengan cita rasa pedas dan gurih, mudah disajikan dengan tambahan topping sesuai selera.'),
(14,'Tahu Susu Lembang','./src/asset/tahu susu lembang bg.png',4.9,25000.00,'Makanan Basah','Tahu susu lembang yang lembut dan kaya protein, terbuat dari campuran kedelai pilihan dan susu segar dari Lembang.'),
(15,'Tjilaki 9','./src/asset/tjilaki bg.png',4.6,160000.00,'Makanan Basah','Salah satu produk kuliner dari Bandung yang terkenal dengan cita rasa bolu pisang premium. kue ini merupakan inovasi dari bolu pisang tradisional yang dikemas secara modern, menghadirkan perpaduan antara rasa auntentik pisang khas indonesia.'),
(16,'Yoghurt Lembang Yobba','./src/asset/yogurt bdg bg.png',4.6,20000.00,'Minuman','Produk yobba yogurt lembang yang paling best, perpaduan dari yogurt yang kental dengan sari dan buah asli serta serutan jelly yang krenyes-krenyes.');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT './src/asset/profil.jpg',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Udin','udin@gmail.com','081111222333','$2y$10$7ZCF51thIWRGMDhRLnr8guDwNIZduC8bKlID.OHPWYZhKtK6zBfA.','./src/asset/profil.jpg','2025-11-30 10:24:54');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-30 17:50:03
