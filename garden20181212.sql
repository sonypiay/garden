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

/*Table structure for table `booking_list` */

DROP TABLE IF EXISTS `booking_list`;

CREATE TABLE `booking_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` varchar(10) NOT NULL,
  `schedule_date` date NOT NULL,
  `schedule_time` time NOT NULL,
  `region` int(10) unsigned NOT NULL,
  `address` text NOT NULL,
  `zipcode` int(5) NOT NULL,
  `mobile_number` varchar(16) NOT NULL,
  `price_deal` bigint(20) unsigned NOT NULL,
  `layout_design` varchar(128) NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`booking_id`),
  UNIQUE KEY `id` (`id`),
  KEY `fkbl_customer_id` (`customer_id`),
  KEY `fkbl_vendor_id` (`vendor_id`),
  CONSTRAINT `fkbl_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  CONSTRAINT `fkbl_vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `booking_list` */

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `booking_transaction` */

insert  into `booking_transaction`(`id`,`transaction_id`,`schedule_date`,`region`,`district`,`subdistrict`,`address`,`zipcode`,`mobile_number`,`price_deal`,`layout_design`,`additional_info`,`customer_id`,`vendor_id`,`payment_method`,`isPremium`,`last_status_transaction`,`created_at`,`updated_at`) values (7,'GB201812121F00003','2018-12-20',1,7,1,'Kebayoran Baru',12898,'08561969052',15000000,NULL,'Lorem ipsum dolor sit amet',1,1,'TRANSFER','Y','done','2018-12-12 09:06:37','2018-12-12 09:34:15'),(6,'GB201812127600006','2018-12-12',1,7,4,'Pasar Minggu',12990,'08561969052',550000,NULL,NULL,1,1,NULL,'N','rejected','2018-12-12 06:40:56','2018-12-12 08:41:19'),(5,'GB20181212D000005','2018-12-14',1,4,12,'Jl. Intan Baiduri No. 28',10640,'08561969052',9450000,'20181212_63a522a3.pdf','Lorem ipsum dolor sit amet',1,1,'TRANSFER','Y','done','2018-12-12 06:38:32','2018-12-12 08:57:39');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `customers` */

insert  into `customers`(`customer_id`,`customer_name`,`customer_email`,`customer_mobile_phone`,`customer_username`,`customer_password`,`customer_profile_picture`,`customer_gender`,`customer_birthday`,`customer_region`,`customer_district`,`customer_subdistrict`,`customer_address`,`customer_zipcode`,`customer_verified`,`credits`,`customer_registered`) values (1,'Sony Darmawan','sonypiay@mail.com','8561969052',NULL,'$2y$10$KB27E/HNPKgCrRofOxRVGOAkDfOrdY269IgapxBk.KrTsbotTv.jO',NULL,'male',NULL,NULL,NULL,NULL,NULL,NULL,'N',NULL,'2018-12-12 06:23:37');

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `log_status_transaction` */

insert  into `log_status_transaction`(`id`,`transaction_id`,`status_transaction`,`status_description`,`log_date`) values (1,'GB20181212D000005','approval','Menunggu approval dari pihak Vendor','2018-12-12 06:38:32'),(2,'GB201812127600006','approval','Menunggu approval dari pihak Vendor','2018-12-12 06:40:56'),(3,'GB20181212D000005','payment_waiting','Menunggu konfirmasi pembayaran.','2018-12-12 08:26:06'),(4,'GB20181212D000005','payment_verify','Menunggu verifikasi pembayaran oleh pihak tim Garden Buana.','2018-12-12 08:29:09'),(5,'GB201812127600006','rejected','Transaksi ditolak','2018-12-12 08:41:19'),(6,'GB20181212D000005','paid','Pembayaran telah diterima Garden Buana dan pesanan Anda sudah diteruskan ke vendor.','2018-12-12 08:42:41'),(7,'GB20181212D000005','process','Pesanan sedang diproses oleh pihak Vendor','2018-12-12 08:48:57'),(8,'GB20181212D000005','onprogress','Pesanan sedang dikerjakan','2018-12-12 08:49:36'),(9,'GB20181212D000005','report','Laporan hasil pekerjaan terlampir.','2018-12-12 08:50:48'),(10,'GB20181212D000005','done','Pesanan sudah selesai dikerjakan. Dana sudah diterukan ke vendor.','2018-12-12 08:57:39'),(11,'GB201812121F00003','approval','Menunggu approval dari pihak Vendor','2018-12-12 09:06:37'),(12,'GB201812121F00003','payment_waiting','Pesanan diterima oleh pihak Vendor. <br> Menunggu pembayaran dari sisi Pelanggan.','2018-12-12 09:16:42'),(13,'GB201812121F00003','payment_verify','Menunggu verifikasi pembayaran oleh tim Garden Buana.','2018-12-12 09:21:46'),(14,'GB201812121F00003','paid','Pembayaran telah diterima Garden Buana dan pesanan Anda sudah diteruskan ke vendor.','2018-12-12 09:27:38'),(15,'GB201812121F00003','process','Pesanan sedang diproses oleh pihak Vendor','2018-12-12 09:28:24'),(16,'GB201812121F00003','onprogress','Pesanan sedang dikerjakan','2018-12-12 09:28:43'),(17,'GB201812121F00003','report','Laporan hasil pekerjaan terlampir.','2018-12-12 09:31:56'),(18,'GB201812121F00003','done','Pesanan sudah selesai dikerjakan. Dana sudah diterukan ke vendor.','2018-12-12 09:34:15');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `payment_order_verify` */

insert  into `payment_order_verify`(`id`,`payment_to`,`status_payment`,`transaction_id`,`payment_id`,`payment_amount`,`created_at`,`updated_at`) values (1,1,'verification','GB20181212D000005','201812123D0',9459000,'2018-12-12 06:38:32','2018-12-12 08:29:09'),(2,NULL,'pending','GB201812127600006','20181212F76',NULL,'2018-12-12 06:40:56','2018-12-12 06:40:56'),(3,1,'verification','GB201812121F00003','20181212F1F',15009000,'2018-12-12 09:06:37','2018-12-12 09:21:46');

/*Table structure for table `payment_subscription` */

DROP TABLE IF EXISTS `payment_subscription`;

CREATE TABLE `payment_subscription` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` int(10) unsigned NOT NULL,
  `accountnumber` varchar(20) NOT NULL,
  `payment_to` int(10) unsigned NOT NULL,
  `nominal` bigint(20) unsigned NOT NULL,
  `status_payment` enum('pending','verified') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkps_bank_id` (`bank_id`),
  KEY `fkps_bank_payment_id` (`payment_to`),
  CONSTRAINT `fkps_bank_id` FOREIGN KEY (`bank_id`) REFERENCES `bankcustomer` (`bank_id`),
  CONSTRAINT `fkps_bank_payment_id` FOREIGN KEY (`payment_to`) REFERENCES `bankpayment` (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `payment_subscription` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `vendor_bankaccount` */

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_portfolio` */

insert  into `vendor_portfolio`(`portfolio_id`,`portfolio_name`,`portfolio_slug_name`,`portfolio_thumbnail`,`vendor_id`,`created_at`,`updated_at`,`deleted_at`) values (1,'Portfolio Test','portfolio-test','ca2c8713.jpg',1,'2018-12-12 06:27:25','2018-12-12 06:28:27',NULL),(2,'Portfolio Test 2','portfolio-test-2','a90e7551.jpeg',1,'2018-12-12 06:31:21','2018-12-12 06:35:55',NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_portfolio_images` */

insert  into `vendor_portfolio_images`(`images_id`,`images_name`,`portfolio_id`,`thumbnail`,`created_at`,`updated_at`,`deleted_at`) values (1,'ca2c8713.jpg',1,'N','2018-12-12 06:28:27','2018-12-12 06:28:53',NULL),(2,'60a1a2b3.jpeg',1,'N','2018-12-12 06:28:53','2018-12-12 06:28:53',NULL),(3,'e5136c82.jpeg',1,'N','2018-12-12 06:29:18','2018-12-12 06:29:18',NULL),(4,'91acbd1f.jpeg',1,'N','2018-12-12 06:29:36','2018-12-12 06:29:36',NULL),(5,'05fbf371.jpeg',1,'N','2018-12-12 06:30:05','2018-12-12 06:30:05',NULL),(6,'7de513e4.jpeg',2,'N','2018-12-12 06:31:53','2018-12-12 06:35:55',NULL),(7,'93886ab1.jpg',2,'N','2018-12-12 06:32:11','2018-12-12 06:35:55',NULL),(8,'189f53eb.jpeg',2,'N','2018-12-12 06:32:23','2018-12-12 06:35:55',NULL),(9,'a90e7551.jpeg',2,'Y','2018-12-12 06:35:55','2018-12-12 06:35:55',NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_report_transaction` */

insert  into `vendor_report_transaction`(`report_id`,`report_file`,`report_description`,`transaction_id`,`created_at`,`updated_at`) values (1,'20181212_63a522a3.pdf','Berikut hasil pekerjaan yang sudah selesai. terima kasih','GB20181212D000005','2018-12-12 08:50:48','2018-12-12 08:50:48'),(2,'20181212_ed589715.pdf','Terlampir hasil pekerjaan yang sudah dilakukan.\r\n\r\nTerima kasih.','GB201812121F00003','2018-12-12 09:31:56','2018-12-12 09:31:56');

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
  PRIMARY KEY (`vendor_email_business`),
  UNIQUE KEY `vendor_id` (`vendor_id`),
  UNIQUE KEY `vendor_mobile_private` (`vendor_mobile_private`),
  UNIQUE KEY `vendor_mobile_business` (`vendor_mobile_business`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `vendors` */

insert  into `vendors`(`vendor_id`,`vendor_name`,`vendor_slug_name`,`vendor_description`,`vendor_logo`,`vendor_email_business`,`vendor_mobile_private`,`vendor_mobile_business`,`vendor_region`,`vendor_district`,`vendor_subdistrict`,`vendor_address`,`vendor_zipcode`,`vendor_verified`,`vendor_ownername`,`vendor_username`,`vendor_password`,`credits_balance`,`vendor_registered`) values (1,'Tara Arts','tara-arts',NULL,'28de002cjpg','diwantara.anug@gmail.com','8561969053','8561969053',1,4,10,'Jawa Ipsum gelung kalung ayam manah jawah, luh bebed kancing. Sapu sima peksi susu piring tuwi enjing mucal dipun pendhet wos? Peksi cariyos, sakit suku epek-epek ngulemi pedhang, untu manah nyukani maesa. Bidal minggat supena ngulemi',10640,'N','Diwantara Anugrah Putra',NULL,'$2y$10$jlJ478uaUJE6yqYQCXaIsuKjStjHnVeNHKt6HTnFqigbnyPaHL0du',24450000,'2018-12-12 06:26:34');

/*Table structure for table `withdraw` */

DROP TABLE IF EXISTS `withdraw`;

CREATE TABLE `withdraw` (
  `withdraw_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_bankid` int(10) unsigned NOT NULL,
  `nominal` bigint(20) unsigned NOT NULL,
  `status_withdraw` enum('pending','success') DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`withdraw_id`),
  KEY `fkwd_vendorbankid` (`vendor_bankid`),
  CONSTRAINT `fkwd_vendorbankid` FOREIGN KEY (`vendor_bankid`) REFERENCES `vendor_bankaccount` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `withdraw` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
