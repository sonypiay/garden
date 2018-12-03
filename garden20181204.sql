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
  `bank_logo` varchar(64) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`bank_id`),
  UNIQUE KEY `bank_code` (`bank_code`),
  UNIQUE KEY `bank_code_2` (`bank_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `bankpayment` */

insert  into `bankpayment`(`bank_id`,`bank_code`,`bank_name`,`bank_logo`,`created_at`,`updated_at`) values (1,'014','Bank Central Asia (BCA)','bankbca-logo.png','2018-10-29 16:05:36','2018-10-29 16:05:36'),(2,'013','Bank Permata','permatabank-logo.png','2018-10-29 16:05:59','2018-10-29 16:05:59');

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
  `transaction_id` varchar(12) NOT NULL,
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
  `payment_method` varchar(15) DEFAULT NULL,
  `payment_type` enum('paidoff','downpayment') DEFAULT NULL,
  `last_status_transaction` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  UNIQUE KEY `id` (`id`),
  KEY `fkbtrans_customer_id` (`customer_id`),
  KEY `fkbtrans_vendor_id` (`vendor_id`),
  CONSTRAINT `fkbtrans_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  CONSTRAINT `fkbtrans_vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `booking_transaction` */

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `customer_bankaccount` */

insert  into `customer_bankaccount`(`id`,`bank_id`,`account_number`,`ownername`,`customer_id`,`created_at`,`updated_at`) values (2,1,'8770003688','Sony Darmawan',1,'2018-11-19 17:02:03','2018-11-19 17:22:06'),(4,2,'12345678909','Sony Darmawan',1,'2018-11-19 17:22:59','2018-11-19 17:22:59');

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

insert  into `customers`(`customer_id`,`customer_name`,`customer_email`,`customer_mobile_phone`,`customer_username`,`customer_password`,`customer_profile_picture`,`customer_gender`,`customer_birthday`,`customer_region`,`customer_district`,`customer_subdistrict`,`customer_address`,`customer_zipcode`,`customer_verified`,`credits`,`customer_registered`) values (1,'Sony Darmawan','me@sonypiay.com','8561969052','sonypiay','$2y$10$1Cf/A9WGKsyo3jpVH/.8f.Nyt082sQmsrqlccspYmTVtijSNuZR/m',NULL,'male','1996-09-17',NULL,NULL,NULL,NULL,NULL,'N',NULL,'2018-11-12 17:13:10');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `kabupaten` */

insert  into `kabupaten`(`id_kab`,`kode_kab`,`nama_kab`,`id_provinsi`) values (4,'JKP','Jakarta Pusat',1),(2,'JKT','Jakarta Timur',1),(1,'SRG','Serang',2),(3,'TNG','Tangerang',2);

/*Table structure for table `kecamatan` */

DROP TABLE IF EXISTS `kecamatan`;

CREATE TABLE `kecamatan` (
  `id_kec` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kec` varchar(5) NOT NULL,
  `nama_kec` varchar(128) NOT NULL,
  `id_kab` int(10) unsigned NOT NULL,
  PRIMARY KEY (`kode_kec`),
  UNIQUE KEY `id_kec` (`id_kec`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `kecamatan` */

insert  into `kecamatan`(`id_kec`,`kode_kec`,`nama_kec`,`id_kab`) values (4,'CLD','Ciledug',3),(2,'KMY','Kemayoran',4),(3,'SUMBA','Sumur Batu',4);

/*Table structure for table `log_status_transaction` */

DROP TABLE IF EXISTS `log_status_transaction`;

CREATE TABLE `log_status_transaction` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(12) NOT NULL,
  `status_transaction` varchar(20) NOT NULL,
  `status_description` text NOT NULL,
  `log_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fklogtrans_transaction_id` (`transaction_id`),
  CONSTRAINT `fklogtrans_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `booking_transaction` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `log_status_transaction` */

/*Table structure for table `payment_order_verify` */

DROP TABLE IF EXISTS `payment_order_verify`;

CREATE TABLE `payment_order_verify` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` int(10) unsigned NOT NULL,
  `accountnumber` varchar(20) NOT NULL,
  `payment_to` int(10) unsigned NOT NULL,
  `nominal` bigint(20) unsigned NOT NULL,
  `status_payment` enum('pending','verified') DEFAULT NULL,
  `transaction_id` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkpov_bank_id` (`bank_id`),
  KEY `fkpov_transaction_id` (`transaction_id`),
  KEY `fkpov_bank_payment_id` (`payment_to`),
  CONSTRAINT `fkpov_bank_id` FOREIGN KEY (`bank_id`) REFERENCES `bankcustomer` (`bank_id`),
  CONSTRAINT `fkpov_bank_payment_id` FOREIGN KEY (`payment_to`) REFERENCES `bankpayment` (`bank_id`),
  CONSTRAINT `fkpov_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `booking_transaction` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `payment_order_verify` */

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_bankaccount` */

insert  into `vendor_bankaccount`(`id`,`bank_id`,`account_number`,`ownername`,`vendor_id`,`created_at`,`updated_at`) values (1,1,'8770003688','Sony Darmawan',1,'2018-11-30 15:29:04','2018-11-30 15:30:54');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_portfolio` */

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `vendor_portfolio_images` */

/*Table structure for table `vendors` */

DROP TABLE IF EXISTS `vendors`;

CREATE TABLE `vendors` (
  `vendor_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(255) NOT NULL,
  `vendor_slug_name` varchar(255) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `vendors` */

insert  into `vendors`(`vendor_id`,`vendor_name`,`vendor_slug_name`,`vendor_logo`,`vendor_email_business`,`vendor_mobile_private`,`vendor_mobile_business`,`vendor_region`,`vendor_district`,`vendor_subdistrict`,`vendor_address`,`vendor_zipcode`,`vendor_verified`,`vendor_ownername`,`vendor_username`,`vendor_password`,`credits_balance`,`vendor_registered`) values (2,'TaraArtsLife','taraartslife',NULL,'pyscho30@gmail.com','8561969053','8561969053',2,3,4,'Perumahan japos',10012,'N','Diwantara Anugrah Putra',NULL,'$2y$10$MsfW2XKGWhjPaWsj/yV4kuXpWEKjmMYJ6N7ULM4crdAJmLrY7IBaC',0,'2018-11-30 13:57:53'),(3,'Test Garden Buana','test-garden-buana',NULL,'sonypiay@gmail.com','21888888888','21888888888',1,4,2,'Kemayoran',10640,'N','Test Garden',NULL,'$2y$10$bsWTqh68HjXDgXsUTSdiRukp8JMgq9A5aIE4/G5B97WDdQHj9L4Zy',0,'2018-12-01 03:33:24'),(1,'Buana Garden','buana-garden','gplogo.jpg','sonypiay@mail.com','8561969051','8561969051',1,4,2,'kemayoran',10640,'N','Sony Darmawan',NULL,'$2y$10$/YUU9kV5L3d3IH7IdSeECuK9o5vt2lRWMzEEHkL4tbiEWiwexCtMq',0,'2018-11-22 10:36:23');

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
