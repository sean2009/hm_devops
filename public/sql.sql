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

/*Data for the table `d_batch` */

insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (31,NULL,'21',NULL,'225,155',1393575748,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (32,NULL,'21',NULL,'225,153,132',1393575869,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (33,NULL,'21',NULL,'225,155,153',1393575926,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (34,NULL,'21',NULL,'225',1393576370,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (35,NULL,'22',NULL,'407,406,337,265,217',1393577438,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (36,NULL,'22',NULL,'407,406,337,265,217,203,199',1393577454,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (37,NULL,'23',NULL,'332,160',1393577630,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (38,NULL,'22',NULL,'407,406,337,265,217,203',1393578850,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (39,NULL,'22',NULL,'407,406,337,265,217,203,199,198,177',1393578865,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (40,NULL,'22',NULL,'422',1393809492,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (41,NULL,'22',NULL,'422',1393809564,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (42,NULL,'22',NULL,'422',1393809706,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (43,NULL,'22',NULL,'422',1393809714,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (44,NULL,'22',NULL,'422',1393809887,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (45,NULL,'22',NULL,'422',1393810141,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (46,NULL,'22',NULL,'422',1393810215,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (47,NULL,'22',NULL,'422',1393810479,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (48,NULL,'22',NULL,'422',1393810544,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (49,NULL,'22',NULL,'422',1393811186,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (50,NULL,'22',NULL,'422,199',1393811269,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (51,NULL,'22',NULL,'424',1393813010,NULL);
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (52,NULL,'22',NULL,'424,422',1393813085,'我测试一下');
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (53,NULL,'23',NULL,'332',1393813721,'wo zacasdasdasdas');
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (54,1,'22',NULL,'431',1393825498,'sadsadas');
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (55,1,'22',NULL,'437,436,435',1393825867,'asdsadas');
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (56,1,'23',NULL,'332,160,153,132,114',1393826781,'dfdf');
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (57,1,'22','pre','437',1393827724,'dfgf');
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (58,1,'22','pro','437,429',1393827780,'gfhg');
insert  into `d_batch`(`batch_id`,`rsync_config`,`project_id`,`env`,`revision`,`dateline`,`memo`) values (59,1,'22','pre','472,446,437',1393899197,'hfg');

/*Table structure for table `d_batch_server` */

CREATE TABLE `d_batch_server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch_id` int(11) DEFAULT NULL,
  `server_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

/*Data for the table `d_batch_server` */

insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (25,31,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (26,32,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (27,33,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (28,33,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (29,34,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (30,34,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (31,35,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (32,35,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (33,36,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (34,36,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (35,37,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (36,38,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (37,38,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (38,39,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (39,39,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (40,40,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (41,40,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (42,41,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (43,41,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (44,42,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (45,42,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (46,43,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (47,43,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (48,44,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (49,44,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (50,45,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (51,45,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (52,46,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (53,46,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (54,47,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (55,47,30,0);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (56,48,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (57,48,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (58,49,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (59,49,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (60,50,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (61,50,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (62,51,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (63,51,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (64,52,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (65,52,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (66,53,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (67,54,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (68,54,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (69,55,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (70,55,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (71,56,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (72,57,30,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (73,58,29,1);
insert  into `d_batch_server`(`id`,`batch_id`,`server_id`,`status`) values (74,59,30,1);

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

/*Data for the table `d_project` */

insert  into `d_project`(`id`,`project_name`,`svn_path`,`framework`,`code`,`root_path`,`domain`,`nginx_conf`,`config_svn_path`) values (21,'yiiext','svn://192.168.0.152:8888/repos/dev/trunk/yiiext','yiiext','yiiext','yiiext','',NULL,NULL);
insert  into `d_project`(`id`,`project_name`,`svn_path`,`framework`,`code`,`root_path`,`domain`,`nginx_conf`,`config_svn_path`) values (22,'资讯前台','svn://192.168.0.152:8888/repos/dev/trunk/zixun_front','ecshop','zixun_front','zixun_front','zhuangxiu.mmall.com','server {\r\n	listen	80;\r\n	server_name  zhuangxiu.mmall.com;\r\n	index  index.html index.php;\r\n	root /app/zixun_front ;\r\n	\r\n	location / {\r\n		root   /app/zixun_front ;\r\n		index index.html  index.php;\r\n	}\r\n\r\n	location ~ .*\\.php?$ {\r\n		proxy_set_header Host  $host;\r\n		proxy_set_header X-Forwarded-For  $remote_addr;\r\n		fastcgi_pass  127.0.0.1:9000 ;\r\n		include fastcgi.conf;\r\n	}\r\n\r\n}\r\n','');
insert  into `d_project`(`id`,`project_name`,`svn_path`,`framework`,`code`,`root_path`,`domain`,`nginx_conf`,`config_svn_path`) values (23,'passport_web','svn://192.168.0.152:8888/repos/dev/trunk/passport/passport_web','yii','passport_web','/passport/passport_web','passport.mmall.com','server {\r\n	listen	80;\r\n	server_name  passport.mmall.com;\r\n	index  index.html index.php;\r\n	root /app//passport/passport_web ;\r\n	\r\n	location / {\r\n		root   /app//passport/passport_web ;\r\n		index index.html  index.php;\r\n	}\r\n\r\n	location ~ .*\\.php?$ {\r\n		proxy_set_header Host  $host;\r\n		proxy_set_header X-Forwarded-For  $remote_addr;\r\n		fastcgi_pass  127.0.0.1:9000 ;\r\n		include fastcgi.conf;\r\n	}\r\n\r\n}\r\n','svn://192.168.0.152:8888/configs/product_configs/passport/passport_web');

/*Table structure for table `d_project_server` */

CREATE TABLE `d_project_server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `server_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '状态（1：正常，0：未初始化）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

/*Data for the table `d_project_server` */

insert  into `d_project_server`(`id`,`project_id`,`server_id`,`status`) values (46,8,25,1);
insert  into `d_project_server`(`id`,`project_id`,`server_id`,`status`) values (49,18,25,1);
insert  into `d_project_server`(`id`,`project_id`,`server_id`,`status`) values (54,18,26,1);
insert  into `d_project_server`(`id`,`project_id`,`server_id`,`status`) values (56,17,25,1);
insert  into `d_project_server`(`id`,`project_id`,`server_id`,`status`) values (62,20,25,1);
insert  into `d_project_server`(`id`,`project_id`,`server_id`,`status`) values (65,21,29,1);
insert  into `d_project_server`(`id`,`project_id`,`server_id`,`status`) values (70,21,30,1);
insert  into `d_project_server`(`id`,`project_id`,`server_id`,`status`) values (73,23,29,1);
insert  into `d_project_server`(`id`,`project_id`,`server_id`,`status`) values (81,23,30,1);
insert  into `d_project_server`(`id`,`project_id`,`server_id`,`status`) values (82,22,30,1);
insert  into `d_project_server`(`id`,`project_id`,`server_id`,`status`) values (83,22,29,1);

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

/*Data for the table `d_server` */

insert  into `d_server`(`id`,`username`,`password`,`php_path`,`nginx_path`,`ip`,`web_username`,`env`,`is_deleted`,`status`) values (29,'root','32f6bAWGeVHCRrNF0uNfLzXAUUr63JF8SSBVqrLK0Yd0rVVe','/usr/local/php/bin/php','/usr/local/nginx/sbin/nginx','192.168.0.153','redstar','pro',0,1);
insert  into `d_server`(`id`,`username`,`password`,`php_path`,`nginx_path`,`ip`,`web_username`,`env`,`is_deleted`,`status`) values (30,'root','0199MhwGp+Kte8Soh287jfKrZlgAEFRoKjzsm/0pK/q4yaw+','/usr/local/php/bin/php','/usr/local/nginx/sbin/nginx','192.168.0.156','redstar','pre',0,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
