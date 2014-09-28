/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.5.34-log : Database - hm_zixun
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `d_batch` */

CREATE TABLE `d_batch` (
  `batch_id` int(11) NOT NULL AUTO_INCREMENT,
  `rsync_config` tinyint(1) DEFAULT NULL COMMENT '是否同步发布配置文件',
  `project_id` varchar(100) DEFAULT NULL,
  `env` char(10) DEFAULT NULL COMMENT '发布的环境',
  `revision` varchar(500) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  `memo` varchar(5000) DEFAULT NULL COMMENT '发布备注',
  PRIMARY KEY (`batch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

/*Table structure for table `d_batch_server` */

CREATE TABLE `d_batch_server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch_id` int(11) DEFAULT NULL,
  `server_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

/*Table structure for table `d_project` */

CREATE TABLE `d_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(100) DEFAULT NULL,
  `svn_path` text,
  `framework` char(20) DEFAULT NULL COMMENT '基于的框架',
  `code` varchar(100) DEFAULT NULL COMMENT '项目代码',
  `root_path` varchar(500) DEFAULT NULL,
  `domain` varchar(200) DEFAULT NULL,
  `nginx_conf` text,
  `config_svn_path` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Table structure for table `d_project_server` */

CREATE TABLE `d_project_server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `server_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '状态（1：正常，0：未初始化）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

/*Table structure for table `d_server` */

CREATE TABLE `d_server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `php_path` varchar(200) DEFAULT NULL,
  `nginx_path` varchar(200) DEFAULT NULL,
  `ip` varchar(60) DEFAULT NULL,
  `web_username` varchar(50) DEFAULT NULL,
  `env` char(10) DEFAULT NULL COMMENT 'pro正式；pre预发',
  `is_deleted` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态（1：可用，0：不可用）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
