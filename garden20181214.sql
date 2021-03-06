/*
SQLyog Community Edition- MySQL GUI v5.29
Host - 5.5.5-10.1.33-MariaDB : Database - garden
*********************************************************************
Server version : 5.5.5-10.1.33-MariaDB
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `garden`;

USE `garden`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `bankcustomer` */

DROP TABLE IF EXISTS `bankcustomer`;

CREATE TABLE `bankcustomer` (
  `bank_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bank_code` varchar(3) NOT NULL,
  `bank_name` varchar(128) NOT NULL,
  `bank_logo` varchar(64) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`bank_id`),
  UNIQUE KEY `bank_code` (`bank_code`),
  UNIQUE KEY `bank_code_2` (`bank_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `bankcustomer` */

insert  into `bankcustomer`(`bank_id`,`bank_code`,`bank_name`,`bank_logo`,`created_at`,`updated_at`) values (1,'014','Bank Central Asia (BCA)','bankbca-logo.png','2018-10-29 16:07:22','2018-10-29 16:07:22'),(2,'013','Bank Permata','permatabank-logo.png','2018-10-29 16:07:37','2018-10-29 16:07:37');

/*Table structure for table `bankpayment` */

DROP TABLE IF EXISTS `bankpayment`;

CREATE TABLE `bankpayment` (
  `bank_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bank_code` varchar(3) NOT NULL,
  `bank_name` varchar(128) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `bank_logo` varchar(64) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`bank_id`),
  UNIQUE KEY `bank_code` (`bank_code`),
  UNIQUE KEY `bank_code_2` (`bank_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `bankpayment` */

insert  into `bankpayment`(`bank_id`,`bank_code`,`bank_name`,`account_number`,`bank_logo`,`created_at`,`updated_at`) values (1,'014','Bank Central Asia (BCA)','0286828689','bankbca-logo.png','2018-10-29 16:05:36','2018-10-29 16:05:36'),(2,'013','Bank Permata','8770003688','permatabank-logo.png','2018-10-29 16:05:59','2018-10-29 16:05:59');

/*Table structure for table `booking_transaction` */

DROP TABLE IF EXISTS `booking_transaction`;

CREATE TABLE `booking_transaction` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(25) NOT NULL,
  `schedule_date` date NOT NULL,
  `region` int(10) unsigned NOT NULL,
  `district` int(10) unsigned NOT NULL,
  `subdistrict` int(10) unsigned NOT NULL,
  `address` text NOT NULL,
  `zipcode` int(5) NOT NULL,
  `mobile_number` varchar(16) NOT NULL,
  `price_deal` bigint(20) unsigned NOT NULL,
  `layout_design` varchar(128) DEFAULT NULL,
  `additional_info` text,
  `customer_id` bigint(20) unsigned NOT NULL,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `payment_method` varchar(15) DEFAULT NULL,
  `isPremium` enum('Y','N') DEFAULT 'N',
  `last_status_transaction` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  UNIQUE KEY `id` (`id`),
  KEY `fkbtrans_customer_id` (`customer_id`),
  KEY `fkbtrans_vendor_id` (`vendor_id`),
  CONSTRAINT `fkbtrans_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  CONSTRAINT `fkbtrans_vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `booking_transaction` */

insert  into `booking_transaction`(`id`,`transaction_id`,`schedule_date`,`region`,`district`,`subdistrict`,`address`,`zipcode`,`mobile_number`,`price_deal`,`layout_design`,`additional_info`,`customer_id`,`vendor_id`,`payment_method`,`isPremium`,`last_status_transaction`,`created_at`,`updated_at`) values (7,'GB201812121F00003','2018-12-20',1,7,1,'Kebayoran Baru',12898,'08561969052',15000000,NULL,'Lorem ipsum dolor sit amet',1,1,'TRANSFER','Y','done','2018-12-12 09:06:37','2018-12-12 09:34:15'),(8,'GB2018121229B00004','2018-12-13',1,7,9,'Konohagakure',38381,'088888888',5000000,NULL,'Tsukuyomi',2,2,'TRANSFER','Y','done','2018-12-12 19:08:59','2018-12-12 19:21:51'),(6,'GB201812127600006','2018-12-12',1,7,4,'Pasar Minggu',12990,'08561969052',550000,NULL,NULL,1,1,NULL,'N','rejected','2018-12-12 06:40:56','2018-12-12 08:41:19'),(5,'GB20181212D000005','2018-12-14',1,4,12,'Jl. Intan Baiduri No. 28',10640,'08561969052',9450000,'20181212_63a522a3.pdf','Lorem ipsum dolor sit amet',1,1,'TRANSFER','Y','done','2018-12-12 06:38:32','2018-12-12 08:57:39'),(9,'GB20181212D6200005','2019-02-05',1,4,12,'Menteng',12982,'08882883',15000000,NULL,'menteng',2,2,'TRANSFER','Y','done','2018-12-12 19:22:52','2018-12-12 19:29:26');

/*Table structure for table `cust_activity_logs` */

DROP TABLE IF EXISTS `cust_activity_logs`;

CREATE TABLE `cust_activity_logs` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_type` varchar(32) DEFAULT NULL,
  `log_description` text,
  `log_datetime` datetime DEFAULT NULL,
  `log_ip` varchar(64) DEFAULT NULL,
  `log_agent` text,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `cust_activity_logs` */

insert  into `cust_activity_logs`(`log_id`,`log_type`,`log_description`,`log_datetime`,`log_ip`,`log_agent`) values (1,'register','sonypiay@mail.com registrasi pada 2018-11-12 17:13:10','2018-11-12 17:13:10','::1','Windows'),(2,'register','sonypiay@mail.com registrasi pada 2018-11-13 13:49:18','2018-11-13 13:49:18','::1','Windows'),(3,'register','sonypiay@mail.com registrasi pada 2018-11-14 11:19:59','2018-11-14 11:19:59','::1','Windows'),(4,'register','sonypiay@mail.com registrasi pada 2018-11-14 16:32:08','2018-11-14 16:32:08','::1','Windows'),(5,'register','sonypiay@mail.com registrasi pada 2018-11-15 06:04:27','2018-11-15 06:04:27','::1','Windows'),(6,'register','sonypiay@mail.com registrasi pada 2018-11-15 10:37:43','2018-11-15 10:37:43','::1','Windows'),(7,'register','sonypiay@mail.com registrasi pada 2018-11-16 15:48:23','2018-11-16 15:48:23','::1','Windows'),(8,'register','me@sonypiay.com registrasi pada 2018-11-16 19:01:55','2018-11-16 19:01:55','::1','Windows'),(9,'register','me@sonypiay.com registrasi pada 2018-11-16 19:35:37','2018-11-16 19:35:37','::1','Windows'),(10,'register','me@sonypiay.com registrasi pada 2018-11-16 19:35:56','2018-11-16 19:35:56','::1','Windows'),(11,'register','me@sonypiay.com registrasi pada 2018-11-18 17:28:09','2018-11-18 17:28:09','::1','Windows'),(12,'register','me@sonypiay.com registrasi pada 2018-11-19 09:34:55','2018-11-19 09:34:55','::1','Windows'),(13,'register','me@sonypiay.com registrasi pada 2018-11-19 16:31:34','2018-11-19 16:31:34','::1','Windows');

/*Table structure for table `customer_bankaccount` */

DROP TABLE IF EXISTS `customer_bankaccount`;

CREATE TABLE `customer_bankaccount` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` int(10) unsigned NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `ownername` varchar(255) DEFAULT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_number` (`account_number`),
  KEY `fkcb_customer_id` (`customer_id`),
  KEY `fkcb_bank_id` (`bank_id`),
  CONSTRAINT `fkcb_bank_id` FOREIGN KEY (`bank_id`) REFERENCES `bankcustomer` (`bank_id`),
  CONSTRAINT `fkcb_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `customer_bankaccount` */

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `customer_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(128) NOT NULL,
  `customer_mobile_phone` varchar(16) NOT NULL,
  `customer_username` varchar(128) DEFAULT NULL,
  `customer_password` varchar(128) NOT NULL,
  `customer_profile_picture` varchar(255) DEFAULT NULL,
  `customer_gender` enum('male','female') DEFAULT 'male',
  `customer_birthday` date DEFAULT NULL,
  `customer_region` int(10) unsigned DEFAULT NULL,
  `customer_district` int(10) unsigned DEFAULT NULL,
  `customer_subdistrict` int(10) unsigned DEFAULT NULL,
  `customer_address` text,
  `customer_zipcode` int(5) unsigned DEFAULT NULL,
  `customer_verified` enum('N','Y') DEFAULT 'N',
  `credits` bigint(20) unsigned DEFAULT NULL,
  `customer_registered` datetime NOT NULL,
  PRIMARY KEY (`customer_email`),
  UNIQUE KEY `customer_id` (`customer_id`),
  UNIQUE KEY `customer_mobile_phone` (`customer_mobile_phone`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `customers` */

insert  into `customers`(`customer_id`,`customer_name`,`customer_email`,`customer_mobile_phone`,`customer_username`,`customer_password`,`customer_profile_picture`,`customer_gender`,`customer_birthday`,`customer_region`,`customer_district`,`customer_subdistrict`,`customer_address`,`customer_zipcode`,`customer_verified`,`credits`,`customer_registered`) values (2,'Rizqy Caesario','rizqycaesario@gmail.com','8561291279',NULL,'$2y$10$lHCEwqi8RLTi5TxhTVX1w.oqeBITDE0YNka7xI9qlFBOXat1gaTxe',NULL,'male',NULL,NULL,NULL,NULL,NULL,NULL,'N',NULL,'2018-12-12 19:02:14'),(1,'Sony Darmawan','sonypiay@mail.com','8561969052',NULL,'$2y$10$KB27E/HNPKgCrRofOxRVGOAkDfOrdY269IgapxBk.KrTsbotTv.jO',NULL,'male',NULL,NULL,NULL,NULL,NULL,NULL,'N',NULL,'2018-12-12 06:23:37');

/*Table structure for table `kabupaten` */

DROP TABLE IF EXISTS `kabupaten`;

CREATE TABLE `kabupaten` (
  `id_kab` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kab` varchar(5) NOT NULL,
  `nama_kab` varchar(128) NOT NULL,
  `id_provinsi` int(10) unsigned NOT NULL,
  PRIMARY KEY (`kode_kab`),
  UNIQUE KEY `id_kab` (`id_kab`),
  KEY `fk_kab_provinsi` (`id_provinsi`),
  CONSTRAINT `fk_kab_provinsi` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `kabupaten` */

insert  into `kabupaten`(`id_kab`,`kode_kab`,`nama_kab`,`id_provinsi`) values (6,'JKB','Jakarta Barat',1),(4,'JKP','Jakarta Pusat',1),(7,'JKS','Jakarta Selatan',1),(2,'JKT','Jakarta Timur',1),(5,'JKU','Jakarta Utara',1),(1,'SRG','Serang',2),(3,'TNG','Tangerang',2);

/*Table structure for table `kecamatan` */

DROP TABLE IF EXISTS `kecamatan`;

CREATE TABLE `kecamatan` (
  `id_kec` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kec` varchar(7) NOT NULL,
  `nama_kec` varchar(128) NOT NULL,
  `id_kab` int(10) unsigned NOT NULL,
  PRIMARY KEY (`kode_kec`),
  UNIQUE KEY `id_kec` (`id_kec`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `kecamatan` */

insert  into `kecamatan`(`id_kec`,`kode_kec`,`nama_kec`,`id_kab`) values (3,'CLK','Cilandak',7),(10,'GMB','Gambir',4),(5,'JGK','Jagakarsa',7),(1,'KYB','Kebayoran Baru',7),(6,'MPT','Mampang Prapatan',7),(12,'MTG','Menteng',4),(2,'PES','Pesanggrahan',7),(7,'PNR','Pancoran',7),(4,'PSM','Pasar Minggu',7),(13,'SENEN','Senen',4),(9,'STB','Setiabudi',7),(8,'TBT','Tebet',7),(11,'TNB','Tanah Abang',4);

/*Table structure for table `log_status_transaction` */

DROP TABLE IF EXISTS `log_status_transaction`;

CREATE TABLE `log_status_transaction` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(25) NOT NULL,
  `status_transaction` varchar(20) NOT NULL,
  `status_description` text NOT NULL,
  `log_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fklogtrans_transaction_id` (`transaction_id`),
  CONSTRAINT `fklogtrans_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `booking_transaction` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

/*Data for the table `log_status_transaction` */

insert  into `log_status_transaction`(`id`,`transaction_id`,`status_transaction`,`status_description`,`log_date`) values (1,'GB20181212D000005','approval','Menunggu approval dari pihak Vendor','2018-12-12 06:38:32'),(2,'GB201812127600006','approval','Menunggu approval dari pihak Vendor','2018-12-12 06:40:56'),(3,'GB20181212D000005','payment_waiting','Menunggu konfirmasi pembayaran.','2018-12-12 08:26:06'),(4,'GB20181212D000005','payment_verify','Menunggu verifikasi pembayaran oleh pihak tim Garden Buana.','2018-12-12 08:29:09'),(5,'GB201812127600006','rejected','Transaksi ditolak','2018-12-12 08:41:19'),(6,'GB20181212D000005','paid','Pembayaran telah diterima Garden Buana dan pesanan Anda sudah diteruskan ke vendor.','2018-12-12 08:42:41'),(7,'GB20181212D000005','process','Pesanan sedang diproses oleh pihak Vendor','2018-12-12 08:48:57'),(8,'GB20181212D000005','onprogress','Pesanan sedang dikerjakan','2018-12-12 08:49:36'),(9,'GB20181212D000005','report','Laporan hasil pekerjaan terlampir.','2018-12-12 08:50:48'),(10,'GB20181212D000005','done','Pesanan sudah selesai dikerjakan. Dana sudah diterukan ke vendor.','2018-12-12 08:57:39'),(11,'GB201812121F00003','approval','Menunggu approval dari pihak Vendor','2018-12-12 09:06:37'),(12,'GB201812121F00003','payment_waiting','Pesanan diterima oleh pihak Vendor. <br> Menunggu pembayaran dari sisi Pelanggan.','2018-12-12 09:16:42'),(13,'GB201812121F00003','payment_verify','Menunggu verifikasi pembayaran oleh tim Garden Buana.','2018-12-12 09:21:46'),(14,'GB201812121F00003','paid','Pembayaran telah diterima Garden Buana dan pesanan Anda sudah diteruskan ke vendor.','2018-12-12 09:27:38'),(15,'GB201812121F00003','process','Pesanan sedang diproses oleh pihak Vendor','2018-12-12 09:28:24'),(16,'GB201812121F00003','onprogress','Pesanan sedang dikerjakan','2018-12-12 09:28:43'),(17,'GB201812121F00003','report','Laporan hasil pekerjaan terlampir.','2018-12-12 09:31:56'),(18,'GB201812121F00003','done','Pesanan sudah selesai dikerjakan. Dana sudah diterukan ke vendor.','2018-12-12 09:34:15'),(19,'GB2018121229B00004','approval','Menunggu approval dari pihak Vendor','2018-12-12 19:08:57'),(20,'GB2018121229B00004','payment_waiting','Pesanan diterima oleh pihak Vendor. <br> Menunggu pembayaran dari sisi Pelanggan.','2018-12-12 19:09:55'),(21,'GB2018121229B00004','payment_verify','Menunggu verifikasi pembayaran oleh tim Garden Buana.','2018-12-12 19:10:57'),(22,'GB2018121229B00004','paid','Pembayaran telah diterima Garden Buana dan pesanan Anda sudah diteruskan ke vendor.','2018-12-12 19:11:47'),(23,'GB2018121229B00004','process','Pesanan sedang diproses oleh pihak Vendor','2018-12-12 19:12:42'),(24,'GB2018121229B00004','onprogress','Pesanan sedang dikerjakan','2018-12-12 19:12:51'),(25,'GB2018121229B00004','report','Laporan hasil pekerjaan terlampir.','2018-12-12 19:13:37'),(26,'GB2018121229B00004','done','Pesanan sudah selesai dikerjakan. Dana sudah diterukan ke vendor.','2018-12-12 19:21:51'),(27,'GB20181212D6200005','approval','Menunggu approval dari pihak Vendor','2018-12-12 19:22:52'),(28,'GB20181212D6200005','payment_waiting','Pesanan diterima oleh pihak Vendor. <br> Menunggu pembayaran dari sisi Pelanggan.','2018-12-12 19:23:37'),(29,'GB20181212D6200005','payment_verify','Menunggu verifikasi pembayaran oleh tim Garden Buana.','2018-12-12 19:24:42'),(30,'GB20181212D6200005','paid','Pembayaran telah diterima Garden Buana dan pesanan Anda sudah diteruskan ke vendor.','2018-12-12 19:26:16'),(31,'GB20181212D6200005','process','Pesanan sedang diproses oleh pihak Vendor','2018-12-12 19:28:02'),(32,'GB20181212D6200005','onprogress','Pesanan sedang dikerjakan','2018-12-12 19:28:13'),(33,'GB20181212D6200005','report','Laporan hasil pekerjaan terlampir.','2018-12-12 19:28:31'),(34,'GB20181212D6200005','done','Pesanan sudah selesai dikerjakan. Dana sudah diterukan ke vendor.','2018-12-12 19:29:26');

/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `messages` */

insert  into `messages`(`msg_id`,`vendor_id`,`customer_id`,`created_at`,`updated_at`) values (1,1,2,'2018-12-13 17:29:07','2018-12-13 18:04:47'),(2,1,1,'2018-12-13 18:41:11','2018-12-13 18:41:34'),(3,2,1,'2018-12-13 18:41:50','2018-12-13 18:42:19');

/*Table structure for table `messages_conversation` */

DROP TABLE IF EXISTS `messages_conversation`;

CREATE TABLE `messages_conversation` (
  `conversation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msg_id` int(10) unsigned NOT NULL,
  `message_from` bigint(20) unsigned NOT NULL,
  `message_to` bigint(20) unsigned NOT NULL,
  `messages` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`conversation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `messages_conversation` */

insert  into `messages_conversation`(`conversation_id`,`msg_id`,`message_from`,`message_to`,`messages`,`created_at`,`updated_at`) values (1,1,2,1,'Hello World','2018-12-13 17:29:07','2018-12-13 17:29:07'),(2,1,2,1,'This is a message test','2018-12-13 17:32:32','2018-12-13 17:32:32'),(3,1,2,1,'this is from your customers','2018-12-13 17:32:49','2018-12-13 17:32:49'),(4,1,2,1,'Haii','2018-12-13 18:03:52','2018-12-13 18:03:52'),(5,1,2,1,'Haii','2018-12-13 18:04:21','2018-12-13 18:04:21'),(6,1,2,1,'Woiiiiiiiiiiii','2018-12-13 18:04:47','2018-12-13 18:04:47'),(7,2,1,1,'Woiiiiiiiiiiiiiiiiiiiiiiiiiiiii gila','2018-12-13 18:41:11','2018-12-13 18:41:11'),(8,2,1,1,'warararararara','2018-12-13 18:41:20','2018-12-13 18:41:20'),(9,2,1,1,'kungkingkangkungkingkng','2018-12-13 18:41:26','2018-12-13 18:41:26'),(10,2,1,1,'Bang, link download gta dimana bang?','2018-12-13 18:41:34','2018-12-13 18:41:34'),(11,3,1,2,'Woiiii','2018-12-13 18:41:50','2018-12-13 18:41:50'),(12,3,1,2,'Tsukuyomi','2018-12-13 18:42:19','2018-12-13 18:42:19');

/*Table structure for table `payment_order_verify` */

DROP TABLE IF EXISTS `payment_order_verify`;

CREATE TABLE `payment_order_verify` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_to` int(10) unsigned DEFAULT NULL,
  `status_payment` enum('pending','verification','paid') NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(25) NOT NULL,
  `payment_id` varchar(32) DEFAULT NULL,
  `payment_amount` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkpov_transaction_id` (`transaction_id`),
  KEY `fkpov_bank_payment_id` (`payment_to`),
  CONSTRAINT `fkpov_bank_payment_id` FOREIGN KEY (`payment_to`) REFERENCES `bankpayment` (`bank_id`),
  CONSTRAINT `fkpov_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `booking_transaction` (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `payment_order_verify` */

insert  into `payment_order_verify`(`id`,`payment_to`,`status_payment`,`transaction_id`,`payment_id`,`payment_amount`,`created_at`,`updated_at`) values (1,1,'verification','GB20181212D000005','201812123D0',9459000,'2018-12-12 06:38:32','2018-12-12 08:29:09'),(2,NULL,'pending','GB201812127600006','20181212F76',NULL,'2018-12-12 06:40:56','2018-12-12 06:40:56'),(3,1,'verification','GB201812121F00003','20181212F1F',15009000,'2018-12-12 09:06:37','2018-12-12 09:21:46'),(4,2,'verification','GB2018121229B00004','2018121229B',5005000,'2018-12-12 19:08:59','2018-12-12 19:10:57'),(5,1,'verification','GB20181212D6200005','20181212D62',15009000,'2018-12-12 19:22:53','2018-12-12 19:24:43');

/*Table structure for table `payment_subscription` */

DROP TABLE IF EXISTS `payment_subscription`;

CREATE TABLE `payment_subscription` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_to` int(10) unsigned NOT NULL,
  `status_payment` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `subs_order_id` varchar(20) NOT NULL,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkps_bank_payment_id` (`payment_to`),
  CONSTRAINT `fkps_bank_payment_id` FOREIGN KEY (`payment_to`) REFERENCES `bankpayment` (`bank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `payment_subscription` */

insert  into `payment_subscription`(`id`,`payment_to`,`status_payment`,`subs_order_id`,`vendor_id`,`created_at`,`updated_at`) values (1,1,'pending','201812356',1,'2018-12-13 23:04:15','2018-12-13 23:04:15');

/*Table structure for table `provinsi` */

DROP TABLE IF EXISTS `provinsi`;

CREATE TABLE `provinsi` (
  `id_provinsi` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode_provinsi` varchar(5) NOT NULL,
  `nama_provinsi` varchar(128) NOT NULL,
  PRIMARY KEY (`kode_provinsi`),
  UNIQUE KEY `id_provinsi` (`id_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `provinsi` */

insert  into `provinsi`(`id_provinsi`,`kode_provinsi`,`nama_provinsi`) values (2,'BTN','Banten'),(1,'DKI','DKI Jakarta'),(3,'JABAR','Jawa Barat'),(4,'JATEN','Jawa Tengah'),(5,'JATIM','Jawa Timur');

/*Table structure for table `userspanel` */

DROP TABLE IF EXISTS `userspanel`;

CREATE TABLE `userspanel` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username_panel` varchar(64) NOT NULL,
  `password_panel` varchar(128) NOT NULL,
  `privileges_user` varchar(64) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username_panel` (`username_panel`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `userspanel` */

insert  into `userspanel`(`uid`,`fullname`,`email`,`username_panel`,`password_panel`,`privileges_user`,`profile_picture`,`created_at`,`updated_at`,`deleted_at`) values (1,'Administrator','admin@localhost','admin','$2y$10$rERck.1Xa9Fon65sFx9aGe9xB2ddjpYoMhYm3cIODak4LhGZn35jy','full',NULL,'2018-10-17 17:36:21','2018-10-17 17:36:21',NULL),(2,'Sony Darmawan','sonypiay@mail.com','sonypiay','$2y$10$dKbxU7Ftco039IQhMka.feSDLXMmWjKnhk0x0p0EYn5aH3wQYv.au','full',NULL,NULL,'2018-10-24 18:01:06',NULL),(3,'Chairul Umam','chairulumam@gmail.com','chairul_umam','$2y$10$loFMiQTroCtljFc6ANnwBuds2Lgm0uD7PuaWjxOO3595I.xi9FZwa','full',NULL,NULL,NULL,NULL),(4,'testing','testin@localhost','testing','$2y$10$Z8TNvOxhciyO2GrCFOjOFeteqHbas7ZTT85xOC/jkUIXlVbsjcs/q','full',NULL,NULL,NULL,NULL),(5,'Support','support@gardenpages.id','support','$2y$10$WMFIYV3CNfWLYjhnHVIjqO9kuZlkraL7ejCeu9rm23QQqJXL2av7C','write',NULL,'2018-10-24 17:54:57','2018-10-24 17:57:15',NULL);

/*Table structure for table `vendor_bankaccount` */

DROP TABLE IF EXISTS `vendor_bankaccount`;

CREATE TABLE `vendor_bankaccount` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` int(10) unsigned NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `ownername` varchar(255) DEFAULT NULL,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_number` (`account_number`),
  KEY `fkvb_vendor_id` (`vendor_id`),
  KEY `fkvb_bank_id` (`bank_id`),
  CONSTRAINT `fkvb_bank_id` FOREIGN KEY (`bank_id`) REFERENCES `bankcustomer` (`bank_id`),
  CONSTRAINT `fkvb_vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_bankaccount` */

insert  into `vendor_bankaccount`(`id`,`bank_id`,`account_number`,`ownername`,`vendor_id`,`created_at`,`updated_at`) values (1,1,'8770003688','Sony Darmawan',1,'2018-12-12 17:01:47','2018-12-12 17:01:47'),(2,2,'877373873','Uchiha Itachi',2,'2018-12-12 19:06:09','2018-12-12 19:06:09');

/*Table structure for table `vendor_history_transaction` */

DROP TABLE IF EXISTS `vendor_history_transaction`;

CREATE TABLE `vendor_history_transaction` (
  `history_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `history_type` enum('withdraw','penerimaan','berlangganan') NOT NULL,
  `history_transaction_id` varchar(25) NOT NULL,
  `history_amount` bigint(20) unsigned NOT NULL,
  `history_current_amount` bigint(20) unsigned DEFAULT '0',
  `history_description` text,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_history_transaction` */

insert  into `vendor_history_transaction`(`history_id`,`history_type`,`history_transaction_id`,`history_amount`,`history_current_amount`,`history_description`,`vendor_id`,`created_at`,`updated_at`) values (1,'withdraw','C201812124F00001',9855000,14595000,'Penarikan dana no. tiket C201812124F00001',1,'2018-12-12 19:01:39','2018-12-13 13:02:58'),(2,'penerimaan','GB2018121229B00004',5000000,5000000,'Penerimaan dana dari no. transaksi GB2018121229B00004',2,'2018-12-12 19:21:51','2018-12-12 19:21:51'),(3,'penerimaan','GB20181212D6200005',15000000,20000000,'Penerimaan dana dari no. transaksi GB20181212D6200005',2,'2018-12-12 19:29:26','2018-12-12 19:29:26'),(4,'withdraw','C20181213E2D0002',5508000,14492000,'Penarikan dana no. tiket C20181213E2D0002',2,'2018-12-13 02:32:49','2018-12-13 12:55:54'),(5,'withdraw','C201812137F60003',1000000,13595000,'Penarikan dana no. tiket C201812137F60003',1,'2018-12-13 13:14:35','2018-12-13 13:14:35'),(6,'withdraw','C201812131A30004',10000000,3595000,'Penarikan dana no. tiket C201812131A30004',1,'2018-12-13 13:15:06','2018-12-13 13:15:06'),(7,'withdraw','C20181213BF80005',50000,3545000,'Penarikan dana no. tiket C20181213BF80005',1,'2018-12-13 13:24:23','2018-12-13 13:24:23'),(8,'withdraw','C20181213D900006',100000,3495000,'Penarikan dana no. tiket C20181213D900006',1,'2018-12-13 13:25:51','2018-12-13 13:25:51'),(9,'withdraw','C201812130030007',50000,3445000,'Penarikan dana no. tiket C201812130030007',1,'2018-12-13 13:26:04','2018-12-13 13:26:04'),(10,'withdraw','C201812135820008',595000,3000000,'Penarikan dana no. tiket C201812135820008',1,'2018-12-13 13:27:23','2018-12-13 13:27:23'),(11,'withdraw','C201812131D90009',1500000,1500000,'Penarikan dana no. tiket C201812131D90009',1,'2018-12-13 13:27:44','2018-12-13 13:27:44'),(12,'withdraw','C2018121389D0010',500000,1595000,'Penarikan dana no. tiket C2018121389D0010',1,'2018-12-13 13:28:49','2018-12-13 13:28:49'),(13,'withdraw','C2018121314F0011',5000000,9492000,'Penarikan dana no. tiket C2018121314F0011',2,'2018-12-13 13:31:17','2018-12-13 13:31:17'),(14,'withdraw','C201812135CE0012',4925000,4567000,'Penarikan dana no. tiket C201812135CE0012',2,'2018-12-13 13:31:43','2018-12-13 13:31:43');

/*Table structure for table `vendor_portfolio` */

DROP TABLE IF EXISTS `vendor_portfolio`;

CREATE TABLE `vendor_portfolio` (
  `portfolio_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `portfolio_name` varchar(255) NOT NULL,
  `portfolio_slug_name` varchar(255) NOT NULL,
  `portfolio_thumbnail` varchar(255) DEFAULT NULL,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`portfolio_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_portfolio` */

insert  into `vendor_portfolio`(`portfolio_id`,`portfolio_name`,`portfolio_slug_name`,`portfolio_thumbnail`,`vendor_id`,`created_at`,`updated_at`,`deleted_at`) values (1,'Portfolio Test','portfolio-test','ca2c8713.jpg',1,'2018-12-12 06:27:25','2018-12-12 06:28:27',NULL),(2,'Portfolio Test 2','portfolio-test-2','a90e7551.jpeg',1,'2018-12-12 06:31:21','2018-12-12 06:35:55',NULL),(3,'Akatsuki','akatsuki',NULL,2,'2018-12-12 19:06:49','2018-12-12 19:06:49',NULL),(4,'Biznet Networks','biznet-networks','841f0649.jpg',3,'2018-12-14 02:56:12','2018-12-14 02:57:50',NULL);

/*Table structure for table `vendor_portfolio_images` */

DROP TABLE IF EXISTS `vendor_portfolio_images`;

CREATE TABLE `vendor_portfolio_images` (
  `images_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `images_name` varchar(255) NOT NULL,
  `portfolio_id` int(10) unsigned NOT NULL,
  `thumbnail` enum('N','Y') DEFAULT 'N',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`images_id`),
  KEY `fk_portfolio_id` (`portfolio_id`),
  CONSTRAINT `fk_portfolio_id` FOREIGN KEY (`portfolio_id`) REFERENCES `vendor_portfolio` (`portfolio_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_portfolio_images` */

insert  into `vendor_portfolio_images`(`images_id`,`images_name`,`portfolio_id`,`thumbnail`,`created_at`,`updated_at`,`deleted_at`) values (1,'ca2c8713.jpg',1,'N','2018-12-12 06:28:27','2018-12-12 06:28:53',NULL),(2,'60a1a2b3.jpeg',1,'N','2018-12-12 06:28:53','2018-12-12 06:28:53',NULL),(3,'e5136c82.jpeg',1,'N','2018-12-12 06:29:18','2018-12-12 06:29:18',NULL),(4,'91acbd1f.jpeg',1,'N','2018-12-12 06:29:36','2018-12-12 06:29:36',NULL),(5,'05fbf371.jpeg',1,'N','2018-12-12 06:30:05','2018-12-12 06:30:05',NULL),(6,'7de513e4.jpeg',2,'N','2018-12-12 06:31:53','2018-12-12 06:35:55',NULL),(7,'93886ab1.jpg',2,'N','2018-12-12 06:32:11','2018-12-12 06:35:55',NULL),(8,'189f53eb.jpeg',2,'N','2018-12-12 06:32:23','2018-12-12 06:35:55',NULL),(9,'a90e7551.jpeg',2,'Y','2018-12-12 06:35:55','2018-12-12 06:35:55',NULL),(10,'eea0f6e5.png',1,'N','2018-12-13 16:31:38','2018-12-13 16:31:38',NULL),(11,'301e957b.png',1,'N','2018-12-13 16:31:51','2018-12-13 16:31:51',NULL),(12,'d6754f79.png',1,'N','2018-12-13 16:32:01','2018-12-13 16:32:01',NULL),(13,'992a1140.png',1,'N','2018-12-13 16:32:33','2018-12-13 16:32:33',NULL),(14,'df671059.png',1,'N','2018-12-13 16:32:56','2018-12-13 16:32:56',NULL),(15,'ff67ff0c.jpg',1,'N','2018-12-13 16:34:37','2018-12-13 16:34:37',NULL),(16,'1573d75c.jpg',1,'N','2018-12-13 16:35:02','2018-12-13 16:35:02',NULL),(17,'892ea2db.jpg',1,'N','2018-12-13 16:35:29','2018-12-13 16:35:29',NULL),(18,'99fc5b22.jpg',1,'N','2018-12-13 16:36:10','2018-12-13 16:36:10',NULL),(19,'71473846.jpg',1,'N','2018-12-13 16:36:19','2018-12-13 16:36:19',NULL),(20,'adbf4930.jpg',1,'N','2018-12-13 16:36:42','2018-12-13 16:36:42',NULL),(21,'834e87f8.jpg',1,'N','2018-12-13 16:38:37','2018-12-13 16:38:37',NULL),(22,'53720a3b.jpg',4,'N','2018-12-14 02:56:29','2018-12-14 02:58:04',NULL),(23,'7c6b49d8.png',4,'N','2018-12-14 02:56:57','2018-12-14 02:58:04',NULL),(24,'2a06be15.jpg',4,'N','2018-12-14 02:57:32','2018-12-14 02:58:04',NULL),(25,'841f0649.jpg',4,'N','2018-12-14 02:57:41','2018-12-14 02:58:04',NULL),(26,'93408cbe.png',4,'N','2018-12-14 02:58:04','2018-12-14 02:58:04',NULL),(27,'3af598ba.png',4,'N','2018-12-14 02:58:16','2018-12-14 02:58:16',NULL),(28,'ac343937.jpg',4,'N','2018-12-14 02:58:34','2018-12-14 02:58:34',NULL),(29,'1a50ebd4.jpg',4,'N','2018-12-14 02:58:42','2018-12-14 02:58:42',NULL),(30,'151e7ee5.jpg',4,'N','2018-12-14 02:58:51','2018-12-14 02:58:51',NULL),(31,'517f7d57.png',4,'N','2018-12-14 02:59:06','2018-12-14 02:59:06',NULL),(32,'e690a8a9.jpg',4,'N','2018-12-14 02:59:23','2018-12-14 02:59:23',NULL);

/*Table structure for table `vendor_premium` */

DROP TABLE IF EXISTS `vendor_premium`;

CREATE TABLE `vendor_premium` (
  `subs_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subs_order_id` varchar(20) NOT NULL,
  `subs_expired` date NOT NULL,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `is_verified` enum('N','Y') NOT NULL DEFAULT 'N',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`subs_id`),
  UNIQUE KEY `subs_order_id` (`subs_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_premium` */

insert  into `vendor_premium`(`subs_id`,`subs_order_id`,`subs_expired`,`vendor_id`,`is_verified`,`created_at`,`updated_at`) values (1,'201812356','2019-01-13',1,'N','2018-12-13 23:04:15','2018-12-13 23:04:15');

/*Table structure for table `vendor_report_transaction` */

DROP TABLE IF EXISTS `vendor_report_transaction`;

CREATE TABLE `vendor_report_transaction` (
  `report_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `report_file` varchar(128) NOT NULL,
  `report_description` text,
  `transaction_id` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`report_id`),
  KEY `fkreport_transaction_id` (`transaction_id`),
  CONSTRAINT `fkreport_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `booking_transaction` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_report_transaction` */

insert  into `vendor_report_transaction`(`report_id`,`report_file`,`report_description`,`transaction_id`,`created_at`,`updated_at`) values (1,'20181212_63a522a3.pdf','Berikut hasil pekerjaan yang sudah selesai. terima kasih','GB20181212D000005','2018-12-12 08:50:48','2018-12-12 08:50:48'),(2,'20181212_ed589715.pdf','Terlampir hasil pekerjaan yang sudah dilakukan.\r\n\r\nTerima kasih.','GB201812121F00003','2018-12-12 09:31:56','2018-12-12 09:31:56'),(3,'20181212_ed589715.pdf','laporan hasil pekerjaan','GB2018121229B00004','2018-12-12 19:13:37','2018-12-12 19:13:37'),(4,'20181212_63a522a3.pdf','laporan','GB20181212D6200005','2018-12-12 19:28:31','2018-12-12 19:28:31');

/*Table structure for table `vendors` */

DROP TABLE IF EXISTS `vendors`;

CREATE TABLE `vendors` (
  `vendor_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(255) NOT NULL,
  `vendor_slug_name` varchar(255) NOT NULL,
  `vendor_description` text,
  `vendor_logo` varchar(128) DEFAULT NULL,
  `vendor_email_business` varchar(128) NOT NULL,
  `vendor_mobile_private` varchar(16) NOT NULL,
  `vendor_mobile_business` varchar(16) NOT NULL,
  `vendor_region` int(10) unsigned NOT NULL,
  `vendor_district` int(10) unsigned NOT NULL,
  `vendor_subdistrict` int(10) unsigned NOT NULL,
  `vendor_address` text NOT NULL,
  `vendor_zipcode` int(5) NOT NULL,
  `vendor_verified` enum('N','Y') DEFAULT 'N',
  `vendor_ownername` varchar(255) NOT NULL,
  `vendor_username` varchar(128) DEFAULT NULL,
  `vendor_password` varchar(128) NOT NULL,
  `credits_balance` bigint(20) unsigned DEFAULT '0',
  `vendor_registered` datetime NOT NULL,
  `vendor_premium` enum('basic','premium') NOT NULL DEFAULT 'basic',
  PRIMARY KEY (`vendor_email_business`),
  UNIQUE KEY `vendor_id` (`vendor_id`),
  UNIQUE KEY `vendor_mobile_private` (`vendor_mobile_private`),
  UNIQUE KEY `vendor_mobile_business` (`vendor_mobile_business`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `vendors` */

insert  into `vendors`(`vendor_id`,`vendor_name`,`vendor_slug_name`,`vendor_description`,`vendor_logo`,`vendor_email_business`,`vendor_mobile_private`,`vendor_mobile_business`,`vendor_region`,`vendor_district`,`vendor_subdistrict`,`vendor_address`,`vendor_zipcode`,`vendor_verified`,`vendor_ownername`,`vendor_username`,`vendor_password`,`credits_balance`,`vendor_registered`,`vendor_premium`) values (3,'Biznet Lifestyle','biznet-lifestyle',NULL,'09a9eda8png','adi_kusma@mail.com','825725855','825725855',1,4,11,'Jl. Jendral Sudirman Kav 10-11',12345,'N','Adi Saputra Kusma',NULL,'$2y$10$ZwxKxMhALBapn93ew05WD.Qnukfr2y6T2NGurFrpMQs2XJ5CW6ybG',0,'2018-12-14 02:54:57','basic'),(1,'Tara Arts','tara-arts',NULL,'28de002cjpg','diwantara.anug@gmail.com','8561969053','8561969053',1,4,10,'Jawa Ipsum gelung kalung ayam manah jawah, luh bebed kancing. Sapu sima peksi susu piring tuwi enjing mucal dipun pendhet wos? Peksi cariyos, sakit suku epek-epek ngulemi pedhang, untu manah nyukani maesa. Bidal minggat supena ngulemi',10640,'N','Diwantara Anugrah Putra',NULL,'$2y$10$jlJ478uaUJE6yqYQCXaIsuKjStjHnVeNHKt6HTnFqigbnyPaHL0du',1595000,'2018-12-12 06:26:34','basic'),(2,'Uchiha Gakure','uchiha-gakure',NULL,NULL,'itachi.uchiha@mail.com','825657876','825657876',1,7,5,'Menteng Dalam',12121,'N','Itachi Uchiha',NULL,'$2y$10$9V/B3s3bbTBaXXPMjZaqA.QttJ3YwaLusGEvkRGz36JAQjl1MJFOa',4567000,'2018-12-12 19:04:35','basic');

/*Table structure for table `withdraw` */

DROP TABLE IF EXISTS `withdraw`;

CREATE TABLE `withdraw` (
  `withdraw_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` varchar(25) NOT NULL,
  `vendor_bankid` int(10) unsigned NOT NULL,
  `nominal` bigint(20) unsigned NOT NULL,
  `status_withdraw` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `vendor_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`withdraw_id`),
  KEY `fkwd_vendorbankid` (`vendor_bankid`),
  CONSTRAINT `fkwd_vendorbankid` FOREIGN KEY (`vendor_bankid`) REFERENCES `vendor_bankaccount` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `withdraw` */

insert  into `withdraw`(`withdraw_id`,`ticket_id`,`vendor_bankid`,`nominal`,`status_withdraw`,`vendor_id`,`created_at`,`updated_at`) values (1,'C201812124F00001',1,9855000,'approved',1,'2018-12-12 19:01:39','2018-12-13 13:02:58'),(2,'C20181213E2D0002',2,5508000,'approved',2,'2018-12-13 02:32:49','2018-12-13 12:55:54'),(3,'C201812137F60003',1,1000000,'approved',1,'2018-12-13 13:14:35','2018-12-13 13:22:22'),(4,'C201812131A30004',1,10000000,'approved',1,'2018-12-13 13:15:06','2018-12-13 13:22:41'),(5,'C20181213BF80005',1,50000,'rejected',1,'2018-12-13 13:24:24','2018-12-13 13:25:21'),(6,'C20181213D900006',1,100000,'rejected',1,'2018-12-13 13:25:51','2018-12-13 13:27:08'),(7,'C201812130030007',1,50000,'rejected',1,'2018-12-13 13:26:04','2018-12-13 13:26:16'),(8,'C201812135820008',1,595000,'rejected',1,'2018-12-13 13:27:23','2018-12-13 13:28:12'),(9,'C201812131D90009',1,1500000,'approved',1,'2018-12-13 13:27:44','2018-12-13 13:28:00'),(10,'C2018121389D0010',1,500000,'pending',1,'2018-12-13 13:28:49','2018-12-13 13:28:49'),(11,'C2018121314F0011',2,5000000,'pending',2,'2018-12-13 13:31:17','2018-12-13 13:31:17'),(12,'C201812135CE0012',2,4925000,'pending',2,'2018-12-13 13:31:43','2018-12-13 13:31:43');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
