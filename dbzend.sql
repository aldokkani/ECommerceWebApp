CREATE DATABASE  IF NOT EXISTS `dbzend` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dbzend`;
-- MySQL dump 10.13  Distrib 5.7.13, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: dbzend
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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
-- Table structure for table `Shopping_Cart`
--

DROP TABLE IF EXISTS `Shopping_Cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Shopping_Cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `due_amount` decimal(10,2) DEFAULT NULL,
  `is_paid` int(1) NOT NULL DEFAULT '0',
  `payment_date` timestamp NULL DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Shopping_Cart_1_idx` (`customer_id`),
  KEY `fk_Shopping_Cart_2_idx` (`coupon_id`),
  CONSTRAINT `fk_Shopping_Cart_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Shopping_Cart_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupon` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Shopping_Cart`
--

LOCK TABLES `Shopping_Cart` WRITE;
/*!40000 ALTER TABLE `Shopping_Cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `Shopping_Cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Shopping_Cart_Det`
--

DROP TABLE IF EXISTS `Shopping_Cart_Det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Shopping_Cart_Det` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `shopping_cart_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_Shopping_Cart_Det_1_idx` (`shopping_cart_id`),
  KEY `fk_Shopping_Cart_Det_2_idx` (`product_id`),
  CONSTRAINT `fk_Shopping_Cart_Det_1` FOREIGN KEY (`shopping_cart_id`) REFERENCES `Shopping_Cart` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Shopping_Cart_Det_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Shopping_Cart_Det`
--

LOCK TABLES `Shopping_Cart_Det` WRITE;
/*!40000 ALTER TABLE `Shopping_Cart_Det` DISABLE KEYS */;
/*!40000 ALTER TABLE `Shopping_Cart_Det` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `parent_cat_id` int(11) DEFAULT NULL,
  `photo` longtext,
  PRIMARY KEY (`id`),
  KEY `parent_cat_id` (`parent_cat_id`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Fashion & Clothing',NULL,'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQdOWfHH1v_SUPRyfyx0IcLEpBIcFFvxbAp7N0zBJ0EZWKS9-DX7w'),(2,'Electronics',NULL,'https://yourstory.com/wp-content/uploads/2014/09/iPhone6.png'),(3,'Beauty, Health & Food',NULL,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBfnbFD7dYPtfViqwJUQjHlt_NdEPVOPavlN2ulagCktq2r38H_5kbPnGf'),(4,'Sports',NULL,'http://goqii.com/blog/wp-content/uploads/all-sports.png'),(5,'Toys, Kids & Baby',NULL,'\'http://a3559z1.americdn.com/wp-content/uploads/2014/02/Kids-toys-help-child-physical-development-1.jpg');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupon`
--

DROP TABLE IF EXISTS `coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_hash` longtext NOT NULL,
  `discount` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_coupon_1_idx` (`user_id`),
  CONSTRAINT `fk_coupon_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon`
--

LOCK TABLES `coupon` WRITE;
/*!40000 ALTER TABLE `coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offer`
--

DROP TABLE IF EXISTS `offer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offer`
--

LOCK TABLES `offer` WRITE;
/*!40000 ALTER TABLE `offer` DISABLE KEYS */;
/*!40000 ALTER TABLE `offer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(45) DEFAULT NULL,
  `name_ar` varchar(45) DEFAULT NULL,
  `description_en` varchar(255) DEFAULT NULL,
  `description_ar` varchar(255) DEFAULT NULL,
  `unit_price` int(11) DEFAULT NULL,
  `photo` longtext,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_products_1_idx` (`category_id`),
  CONSTRAINT `fk_products_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Dove','دوف','Dove Beauty Bar, Sensitive Skin 4 oz, 16 Bar','صابونه دوف للجلد الحساس',16,'https://images-na.ssl-images-amazon.com/images/I/410oS9ItKuL._SL160_.jpg',3),(2,'Conair','مجفف شعر','Conair 1875 Watt Cord Keeper 2-in-1 Styler / Hair Dryer; Magenta - Amazon Exclusive','مجفف شعر',30,'https://images-na.ssl-images-amazon.com/images/I/81n1zuPbtYL._SX522_.jpg',3),(3,'Make Up Brush','فرشاه بودر عاليه الجوده','Very High Quality 20 CM MakeUp Brush L\'oreal','لوريال فرشاه ',90,'tbn:ANd9GcT6GlpPeTlgvJLANk2bzNLjvJ1TqVf6f2OkWweZZgXp9BWRdGEL',3),(4,'Bluetooth Receiver','ريسيفر بلوتوث','TaoTronics Bluetooth Receiver / Car Kit, Portable Wireless Audio Adapter 3.5 mm Stereo Output (Bluetooth 4.0, A2DP, Built-in Microphone) for Home Audio Music Streaming Sound System','ريسيفر بلوتوث',16,'data:image/webp;base64,UklGRpgTAABXRUJQVlA4IIwTAACwWQCdASosASwBPrFWoUukIqGjI3cpmIgWCelu/Gf4/etNg3+h8UfFx6s91PX9z3+e/znmP/IfwD+//vfEnwAvZnnJvi9Dv149gXvH+uPiV6q3Ul7gH8x/uP/M9YP9n4Kf3P/Y+wF/Qf7p/1v817rP8t/5f8r/oP3V9mv53/k//V/ovgD/mn9t/7n+M9rD/3e1D9pf/37mH61f+4bg9uXMb6LpUCUnjjThuXMb6LpUCUnjVLRfOHnb3qM1qOyk8cacNvWSNBxxSV2vY8NLQtYmARYQQ/85Ki6VAlJ3tF7qtc/Sm4gDKmaFdz/sJnIfpEtiY30XSnsWKo8MxUJuoIoJ72EdffMrgQHbwuH1lE+GhfjI8CVAlJ31xV1Bny3Cel0tk8GsuJoZl5Bq4gP9QNUJzM6KvkkfIGPCrU4bly+yQZkTB9j+GnLeMtgngg6jKiACepDuren2Ai9X2vC3LmN9EarzEf+CNJE0gn0yvGwkk6A7dzR8xhjAlN2Hqrs8cZx8x+Mv1jjZ4GH110DIWG4uE4Dqf31SR1y8z5CcZ6dvhhrBtVB7b4pw5AiLk0zPLdAp33n2EPROMM0at6fZGzGXJbpcOSnqG3T4HFNNKgL34mUqNBBy5JP5xGrpV4S7Da7dSrXbsYFjCz21fNDXAexRh1I+VGokbQSr7Bl2uOYPWBSoNZN4BCeAJ5Vg7qyXEJqly+CSbkYLKQDOgFxhfBg57Jz7EDcL/BDUMbijaKvDK+dyJypF1jpguFUsULwumBiWOG26Em39MN3OxlLXS/hVRiyO4lbe/+l+AC2BuoyZNfHmazs0BirDCgpjZ8mxP2B5XUiK4Z4z/wVdLM7rriO5U32Lqcra3DmUHRGpKul9sOyHY47HQcQiFXN4WJl/2DnB/ZPY/u7KnlvU9Hrf5PVgs0OG5cxoxuoblzG+i6VAlJ4404blzG+i6VAlJ4404blzG+i6UEAA/v7nuAAf9VrglTomNc+c7FHwIJFmZ0gEQbxVob887+GMbCbaFZaJTZJrhAlWDc4hcGbyQxBg4zokmYkjIz7To2AF6VmSL351NATP4YmOfjmCuEOhwCz/s/2y5xcrtmpyv6IUxUc/+c9hY4511DBog2puAI0kNnHFn4ICvcldR4YW+w+ca9fi8Z5sM8PcrZIFqN7PHV5JaLl8VJUgM8gW3Jf5hQbvT1fmEm8yMJ04xplIjCd1HTKXytanmvwcOQgAx317jb6Y0clY0UoTEaMJV/cbbNt8zucmBQHQUnxjV+OwQD97SYjkGjKazzeJdUjCR8LlpPDuCOqM4zXJ3nHn17HNI/oVaeRju1EDGzNI28yaRxtgX7HrF2FZNfMay7aoSlBI537SrpA5CiYhVBR21SLYeTQblIaIerwbh4Y57bRNcmlYj8Ux/NW24hTdIu/KKzRkuZUMHuNx+Jw4zjJhCoVoJwtFQuj1RKLh9mNJtQ1HNZQdsXwnkmUUolz1n8ZT1CMprT2CUXzRSgm2p5e6U4nY3b4CNZC3mit7IE73ZU6RBquDMY3hxdd3xkAeagncnWJZiZ9+1lNaIcJ9czyaLByi9g61yrK9Tgbm6FZlWttGTBYRaW1XRFQJS4TRAQ9Kgrug5rO7U1fzvzcZVBwIQmuY8O0EnifybvznvNujno9fpL2Ds+o9sw3Xof8z6aAGqRjxWETlQNVZ2y9dvHeL8GxyerG5kpzCBc0EwkLvCjqCWaWDTSNGWMpTABb5M1J2v90KopIhhj7vBEwYCyoEer7A/d+ZZr1hrAjdS9Gl6ahxzTXHcF/mQApbCBxTyRLZ0eYPpJ82xEhEpPjujWrmGOnFgoYuu/bGBF80EgriOaL2YQx4uWMdasxHinH6UUdMumjYNMmUpgM3EQ6LaKROUz6IXWamuqVtSnrB4gOl9Y6D6lS2w+wVleLS+61HWKGsDnttngeTRBR8PGjH77l9dqopbhiR4m7NOu4rAKW4jynVKWxs2Un9geRC8z7+TBj/GnUQ0HrI4zISb0jQMFOtnibiGXf3oELGHaUX26Kmv6kpxRjamYBa6WGFFPqc1zYsrj1zjiu968mi0lRuQk84CqaE1DHMmwd4/4PIHYat9aT2J+SxW8oh217H4ozXGTcCQUAjf+AeM2GJQOlC2jVKyQgCTLFjx92pIZYrnB0LFTachzyobgfgNx4sl+Wzqbd3qgISKUSad+EhFz1Mw36GnMknS7DzQu2MDGSycvF/Uz/Goy/Cvumz9VeXu5wLStEd5eQhd9Wm7rCWX5xNR74ScTkPL/Z7xqubwXTSIls9R7CDnpLVRGoJm8f35jAsRKlOgKIu1gLhR3exA1cmAHvdkQo3kkXDhAbw49kHKXFlknRXL3UJJW3F1xyOgOdufETIM+zBdhf4bAFfoefXjsVutqp+YXtXlBK/ZFbfZvj96iJAgEVRvU8VwHDU5n95ek88FwzuNgKtMs6NZgLWxL1hCMbEAygPLLAzoNIohSiXhBm/Rg8fJxf93PneQDffjFO3TWnv98c/mfL0Nn79Ciu9MIL2ecsbV8xTBGuVxzRm6wQYcUiadcco8uF2TzBNkGtM5nrYgO2ZJT++aigmJljc0J0ZOTlu8eIP4GdJwTTUVN2DUZDDKSALWsLbhA3lWSTJNo4ZjkuRgzJ2Uv59rgRQOn7L+qOwX4uqs+rYc1yPM/ErKIqmqmS4kq+V5ic8ypUwBS7Br3NBQGwt5mcK/SSP8Xw3Yu78x4odyB4fu75NWuwXex2107PZMUsCZOn04GNMEah31r12J6bh5eFIwgYCADgGO9RDvO+WqEB4aRgfZYkRLK42JCqlY8YR1yZZr1hrAqKV6NAFuD9xdrJrruwI6mM2/T8xeLyH2h+WieLwqPFM04HkOwsZTBxRmzW5vBDpifLRlQ2ASStUi1x2AY6RdT9d0egu6V4QVbV6V6+pdx9y5RGbGnwHJFqwPrARQyT/10uybHGBw2ItN/tOkfKepUH7I1n6FndjeS9ocwoW4/mzGKKZeQmMl8NMWMScuVzl7C2XVDaZ2h9oxJTuQFQeMT3AeVZV7IcDrNf5UoJ1bpEYj9ok4GU37cY2dKjwHEnhtz3LgHdhXl3UjltqbiJBu2p9PNSoRH8Bux/w+ZWoMOJGoGQJGFy1i09e22xMamTjByf1ZLb4+QZ8n6nvP5uHbbiUbgEGTZ4qJMKnhfOytgioPGqEhxlCyDeUSwX2Fj2lFD1LCWCvpdk6EUpDRtS//AO1NK1UepKr0/BF85SSYO10wRzbm0q6DJY5QGbw0DxOZUYeFCnEyA1dx3AuuDDdwOTXzJOab/YtUl3Ka+Vs+0b7nT2IcC3VVyiO08ygflvixzbwRt/MTuQ5tL5wM5ITnKUdfUPaOLg6j4rm68ukQZxnizuSa6Dbb61Nf3aQDniX4XObXvC1HP5XMPKxTyN3Pez3apHfvMw2By7gN9aJUPIVy+5LeR0gf8imnLvrMmwvMXG70mKwXOO2KLnThfi7yio0mLLsVYznRsLs3sMPCPVCWiwRfqXM8Vvn5kya6tzJAQ8xsh4ToJ/7Ou4ELih3k3YjlaAS3aQb3fexvUG4XLlp7OlYZYEf0jPAiam8riIy5nC+n78xXSvsFarlzp1o4gBDBmg6ezR/+bM+ObMpKi0sNb4A35JuOqc/23WR88kwCttfcEMIomI8gxQFbgcXoYVoJWmUcID22zDlqgb1W/IX8hOb/ZjG9/xH/LHTv4SgUAvAspT1Z3AtyoaLK84IsQz4Aga72gpStkv4FQRj8iLlaqdhWLvkvU39TDdteBHXOkq1+obC8himJM/i034eazBcqzvX6n9WUjx2/PMWA+0uVoqePTiufaPwviysm0lmSiPKZ821qrzKfNmdnFach9t9ROh6PENpY3otDpNRBYgQR3gJ3p/MYzeylVfOFSJ7qLj7gSOFqkvWrddsuphYxG7RGNPZddakmuOVTci7qgyEd86rtjy1l94iRUlvieh4Avd07HNiw0SItTE75RQP1+FBBx7K5+U0BeMUqqsE3jgKzotq5DokUmdsAlvh0dWY02urdzhrrLey8XKHqxY9RFL5ygZaIuBjgQk7DlLkvnC+hrZ90CG5Q+/xYpdzx16ts2KeyY6ID8nsBSxRTbTfebIfDozChapf1YjGKntNynzjzkqCr7LKYDJDbzYKXQAclQMK1jSTI4tYx1o4r/x/gXpKLg2Cdd/O8ratTnonFJQrxRbSC6cP4kX9jWLL7fXPCu1KBBCCV5DL7y/NkpsOmPH5mc7pKd/XosQmckGI9V705qUCEYuMRF9LpLXZy+oiXlyUd9gIjmNs5FjBanGhO6tdBxsEaP3yKZFNrKaP8BtKbYrACRCi7gXNma4zl8uqGqvV3vzTY7QVLO8TXpB9g26fx9tN1NslhdOjnvGhYtDU+16eC/0khIHySUptYtxrjfNh1GKka+s+zr7+JFwNE3/nED6oW/htDqczqRS2ZOeJ1PpI7LZSxbn56ItvVjRdwfFRfR4f6eXKYuACEEiUT56OE3WTaMj4D8EnWA9b7Z/SZGzQWDDSYMDkqQKuo3yUqez1y6SiOa7GIESU9TVQsRvXFKurx4NulmzgQNBDB/A5GOGOFRI2+AcETi0lqoj7h1Ig79/eQH6fiLZHBKywXRrfuP4sOYkxQpTFOBwyf51MqEVeQiQrrNtnYXicKcsT0IwofaN7mvOjpgpN4ap1BGxcBBZ288sNLwtGYxahi1IQrWAUXI5bV9J1yQTDI/8XJbNiNLaJcmrs8U9Uj3lreOdX9f9MY+EhgAifZODfg26WzfvVZfX3fVKfbWl6+jQuBbY3BbMeDOXGMSMW/8o6bpb7uKiJPZd1SHsODv5knk7geNflRNDojyLEqeDlOPlJwl8v4fc+0UW6f0H3cPGDMFNy4aF0OYFnSpdkJCmg0l1HceVLSoheSyBnqHu72rgPkL25MtC+gu4PzkgVW+DcioesDjx8P3GIOKljQIxO6yuh0zX5ch59TxHRkmGtG+HzTCjNjmDA3zLMFFaAwp0edovKk5W8SkIoWQT6emOqtAsL3HoC0CcUhiX+aCvW/aTnoq96tJcNLG4xsfHIC+K99p104bJj7B7IwOuDi1TZGjalqAv5HUiTFUhM05E4A6gmzqImOJIU/vM6W2zZl36qARS7xUvenJtIBWIeF3y9UefoKPo/anoBXVswr5TZglqyAIkYJoOL11Wyp/yTuZbcAMqD9Y0sRRTtrgY7BYD/4PRdleSF8rg/pxttzPmpiawqSXW87WeRMwfOpnthwGgcFUUEAPJEvWXyk6Q0AysykzCuEuQApilUUKpGCTXBC0OJC12b4J05rB5MDPWwI80QGojShDG7XguSURYxNdVvb31zeMvZO0Dk7pzo4/sx8rTgIUuw4ZV6d6K4vc43sd5LfpZ96Z6jCGWkMtl4vYprjeg6FEpgTFeKuvWVrFVZQ1e2apzYvvixfF2UvCMtbU37QZCIS0sfaVMrfS8FLoO7fbK1ZVTEE1lm3Y/MmC7dcdukSJiFhWoKwBx5aFd7QWGWXSl55T2feZaUgJSVEg48NltvQkxLTqEiedwL9nKwPe9pUXCg1Ffu3jJkooJZ9z+oKQpzPrFsR5968yLRUduDNqbCAO1d2YO8yyVNhFVbQJe7kUecrlpzSLU8bM0kXhU1U7/gOJwSLB7RqpfY4MGQAADgsMp+Mi1LJDvl5+3hHNyILgCiaQ0PncBFMD2Asuu2ejyappW/vlGZrwuf2wc+38xUbAh2am3MQrK1DmwDuP5YlAapPVLOykVXmUVBfgHxkwBSi8P2obAXZlxM/lvjsWdoS8FwJsBQy6Rp6LGHTyN65Y5WLIPJTfDdxkkcsyA4kC5AM1w4NI9LjogEHG8pmM8D72tfix3tmnGEbfXR2XClwM87iYLc+xgmUzFf8DxBDUtwkAR6Oqgz8/frps2CGkN+P9G349ht2kSPtwP7uuAQZ2fPbp8osdERV99gLqS8EVKm5DSQO67A+76xm8mxnD0l5Hsna7svjbNn0Kf7BkYNMjfMVyjHqjVSTKeBqO5/KsAf1pibjAtdxjnHdWVZJeViWDpZ3lucIKbUTESMRPZX6mfut3Rl4T8HA+6k22PZPor52RYjtGzPR0awICs4mqpGfMY/5d2VO9gFPvdiJhmAvP4RJtwHu/K5c+sgKJD7ylrWUWwwZ3Jig0tMDcqaGEmxaYjh93RxpIhhz1gMWYje7kY/j6LDGMcWLHCc2Bt2jIu6JxPc4gqs2Ofa3CiBgn4m3q5VzZAoJ2+tfpSeOHh+i+D0U3U0wYR41j7kjc6ap2AI/rdhE1Wr0r2s+UG3kYb7QktrYUC7DmSrsHORAAOEpUwMse6mZMkstKAGwe/eApD4qqMS3vvVyIALEeOYLTQ4F2b1nmaOF+pgFBCZus3ZopibfAU6qAtkd9W27l9Ylv+VMUHPKTyC9tHn7gowLSqqbw1wLvvpaoHIr6QoM8NVfdvNuM8vsJb3+DMyXhODnp/ygCDzap8wPFWvHXiwiaBej5aLEwrE8MMC60gQONK6afX5haAgMRMQZ1Az0m4m6vdNE14mjlx2zvW7XisJY2wDhb2IwoHbFoe4WJ/inCEjCPW5L6VzE8xA09420dkHoF1MaPwBQw1kS9hbN1kdm4yqCatqvmK2gDjE8uhnTse8AAAAAAA=',2),(5,'Easy One Touch Holder','حامل موبايل سامسونج نوت 5','iOttie Easy One Touch 2 Car Mount Holder for iPhone 7s 6s Plus 6s 5s 5c Samsung Galaxy S7 Edge S6 S5 Note 5','حامل موبايل نوت 5',19,'data:image/webp;base64,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',2),(6,'ASUS Chromebook','لابتوب اسوس','ASUS Chromebook C202SA-YS02 11.6\" Ruggedized and Water Resistant Design with 180 Degree (Intel Celeron 4 GB, 16GB eMMC, Dark Blue)','لابتوب اسوس',199,'data:image/jpeg;base64,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',2),(7,'Day-to-Night Blouse','بلوزه بينك','Day-to-Night Blouse','بلوزه بينك',209,'https://images-na.ssl-images-amazon.com/images/G/01/AMAZON_FASHION/2017/EDITORIAL/SPRING_1/WOMEN/PRETTIEST_PINK/1.jpg',1),(8,'Rose tone jewelery','قلاده دائره بينك','Rose Tone Jewlery','قلاده دائريه باللون الوردى مرصعه بالالماس',120,'https://images-na.ssl-images-amazon.com/images/G/01/AMAZON_FASHION/2017/EDITORIAL/SPRING_1/WOMEN/PRETTIEST_PINK/2b.jpg',1),(9,'Basket Ball','كرة سله','orange basket ball with black lines,size:5','كره سله اصليه برتقالى بها خطوط سوداء, مقاس:5',50,'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTEJh1zxF0UZVgzCDKVteWQgMDikIOPgE1JoF4RlrZrRrWRYvAzVd7YSvE',4),(10,'FootBall','كرة قدم','world wide champion ball , size:5 , black & white ','كرة كاس العالم , مقاس:5,ابيض واسود',100,'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQdKb1atZBleQXi-5qBtY3O5_54sJT3EoWWUhE9Uo1GLzUelJL0FN9rCg',4),(11,'Speedo T-shirt','تى شيرت سبيدو','Speedo Men\'s UPF 50+ Longview Short-Sleeve Rashguard Swim T-Shirt','تى شيرت سبيدو نص كم رجالى , اللون احمر ',150,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQoL-x_Z9DB_SNyYAIGy2mJbxvyg-5OtSxfCYASzTdjEWghGWV',4),(12,'helmet','خوذه','2014-2015 Vancouver Canucks Team Autographed / Signed Logo Franklin Goalie Mask w/ 23 Sigs Total & Proof Photos of Signing, COA','خوذه حماية للراس لعبة كرة القدم الامريكيه',400,'https://images-na.ssl-images-amazon.com/images/I/518M24H82pL.jpg',4),(13,'Little Tikes First Slide, Red/Blue','زحليقه','Perfect beginner\'s slide, sized especially for younger kids (3-feet long) ','زحليقة رائعه للاطفال , الحجم مخصص للاطفال الاصغر من 3 سنوات',200,'https://images-na.ssl-images-amazon.com/images/I/71vmk%2B2t1AL._SL1500_.jpg',5),(14,'Little Tikes 3\' Trampoline','ترامبولين','Perfect trampoline for toddlers to burn off energy ','ترامبولين رائعه للاطفال لحرق الدهون والمتعه',600,'http://i.ebayimg.com/00/s/NjQ2WDUwMA==/z/yisAAOSw5cNYFsuv/$_12.JPG',5),(15,'Rubik\'s Cube Game','المكعب السحرى',' Billions of combinations, one solution ,Comes with a display stand ','ملايين التكوينات مع حل واحد فقط .. لعبة الذكاء , تاتى ومعها حامل',30,'https://images-na.ssl-images-amazon.com/images/I/51NeESJEpvL.jpg',5);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_product_review`
--

DROP TABLE IF EXISTS `user_product_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_product_review` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`,`product_id`),
  KEY `fk_user_product_review_2_idx` (`product_id`),
  CONSTRAINT `fk_user_product_review_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_product_review_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_product_review`
--

LOCK TABLES `user_product_review` WRITE;
/*!40000 ALTER TABLE `user_product_review` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_product_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT 'customerUser',
  `isactive` tinyint(1) DEFAULT '1',
  `issuperuser` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wishlist_1_idx` (`customer_id`),
  KEY `fk_wishlist_2_idx` (`product_id`),
  CONSTRAINT `fk_wishlist_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_wishlist_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--

LOCK TABLES `wishlist` WRITE;
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-16 19:34:47
