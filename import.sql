/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# emlog_attachment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emlog_attachment`;

CREATE TABLE `emlog_attachment` (
  `aid` int unsigned NOT NULL AUTO_INCREMENT COMMENT '资源文件表',
  `author` int unsigned NOT NULL DEFAULT '1' COMMENT '作者UID',
  `blogid` int unsigned NOT NULL DEFAULT '0' COMMENT '文章ID（已废弃）',
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `filesize` int NOT NULL DEFAULT '0' COMMENT '文件大小',
  `filepath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件路径',
  `addtime` bigint NOT NULL DEFAULT '0' COMMENT '创建时间',
  `width` int NOT NULL DEFAULT '0' COMMENT '图片宽度',
  `height` int NOT NULL DEFAULT '0' COMMENT '图片高度',
  `mimetype` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `thumfor` int NOT NULL DEFAULT '0' COMMENT '缩略图的原资源ID（已废弃）',
  PRIMARY KEY (`aid`),
  KEY `thum_uid` (`thumfor`,`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# emlog_blog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emlog_blog`;

CREATE TABLE `emlog_blog` (
  `gid` int unsigned NOT NULL AUTO_INCREMENT COMMENT '文章表',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文章标题',
  `date` bigint NOT NULL COMMENT '发布时间',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章内容',
  `excerpt` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章摘要',
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '封面图',
  `alias` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文章别名',
  `author` int NOT NULL DEFAULT '1' COMMENT '作者UID',
  `sortid` int NOT NULL DEFAULT '-1' COMMENT '分类ID',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blog' COMMENT '文章OR页面',
  `views` int unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `comnum` int unsigned NOT NULL DEFAULT '0' COMMENT '评论数量',
  `attnum` int unsigned NOT NULL DEFAULT '0' COMMENT '附件数量（已废弃）',
  `top` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '置顶',
  `sortop` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '分类置顶',
  `hide` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '草稿y',
  `checked` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y' COMMENT '文章是否审核',
  `allow_remark` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y' COMMENT '允许评论y',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '访问密码',
  `template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模板',
  `tags` text COLLATE utf8mb4_unicode_ci COMMENT '标签',
  PRIMARY KEY (`gid`),
  KEY `author` (`author`),
  KEY `views` (`views`),
  KEY `comnum` (`comnum`),
  KEY `sortid` (`sortid`),
  KEY `top` (`top`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `emlog_blog` WRITE;
/*!40000 ALTER TABLE `emlog_blog` DISABLE KEYS */;

INSERT INTO `emlog_blog` (`gid`, `title`, `date`, `content`, `excerpt`, `cover`, `alias`, `author`, `sortid`, `type`, `views`, `comnum`, `attnum`, `top`, `sortop`, `hide`, `checked`, `allow_remark`, `password`, `template`, `tags`)
VALUES
	(1,'欢迎使用emlog',1657034772,'恭喜您成功安装了emlog，这是系统自动生成的演示文章。编辑或者删除它，然后开始您的创作吧！','','','',1,-1,'blog',0,1,0,'n','n','n','y','y','','',NULL);

/*!40000 ALTER TABLE `emlog_blog` ENABLE KEYS */;
UNLOCK TABLES;


# emlog_comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emlog_comment`;

CREATE TABLE `emlog_comment` (
  `cid` int unsigned NOT NULL AUTO_INCREMENT COMMENT '评论表',
  `gid` int unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `pid` int unsigned NOT NULL DEFAULT '0' COMMENT '父级评论ID',
  `top` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '置顶',
  `poster` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '发布人昵称',
  `uid` int NOT NULL DEFAULT '0' COMMENT '发布人UID',
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '评论内容',
  `mail` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'email',
  `url` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'homepage',
  `ip` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'ip address',
  `agent` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'user agent',
  `hide` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '是否审核',
  `date` bigint NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`cid`),
  KEY `gid` (`gid`),
  KEY `date` (`date`),
  KEY `hide` (`hide`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `emlog_comment` WRITE;
/*!40000 ALTER TABLE `emlog_comment` DISABLE KEYS */;

INSERT INTO `emlog_comment` (`cid`, `gid`, `pid`, `top`, `poster`, `uid`, `comment`, `mail`, `url`, `ip`, `agent`, `hide`, `date`)
VALUES
	(1,1,0,'n','snow',0,'stay hungry stay foolish','','','','','n',1657034772);

/*!40000 ALTER TABLE `emlog_comment` ENABLE KEYS */;
UNLOCK TABLES;


# emlog_link
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emlog_link`;

CREATE TABLE `emlog_link` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '链接表',
  `sitename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `siteurl` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
  `description` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注信息',
  `hide` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '是否隐藏',
  `taxis` int unsigned NOT NULL DEFAULT '0' COMMENT '排序序号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `emlog_link` WRITE;
/*!40000 ALTER TABLE `emlog_link` DISABLE KEYS */;

INSERT INTO `emlog_link` (`id`, `sitename`, `siteurl`, `description`, `hide`, `taxis`)
VALUES
	(1,'emlog.net','http://www.emlog.net','emlog官方主页','n',0);

/*!40000 ALTER TABLE `emlog_link` ENABLE KEYS */;
UNLOCK TABLES;


# emlog_navi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emlog_navi`;

CREATE TABLE `emlog_navi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '导航表',
  `naviname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '导航名称',
  `url` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '导航地址',
  `newtab` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '在新窗口打开',
  `hide` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '是否隐藏',
  `taxis` int unsigned NOT NULL DEFAULT '0' COMMENT '排序序号',
  `pid` int unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `isdefault` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '是否系统默认导航，如首页',
  `type` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '导航类型 0自定义 1首页 2笔记 3后台管理 4分类 5页面',
  `type_id` int unsigned NOT NULL DEFAULT '0' COMMENT '导航类型对应ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `emlog_navi` WRITE;
/*!40000 ALTER TABLE `emlog_navi` DISABLE KEYS */;

INSERT INTO `emlog_navi` (`id`, `naviname`, `url`, `newtab`, `hide`, `taxis`, `pid`, `isdefault`, `type`, `type_id`)
VALUES
	(1,'首页','','n','n',1,0,'y',1,0),
	(3,'登录','admin','n','n',3,0,'y',3,0);

/*!40000 ALTER TABLE `emlog_navi` ENABLE KEYS */;
UNLOCK TABLES;


# emlog_options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emlog_options`;

CREATE TABLE `emlog_options` (
  `option_id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '站点配置信息表',
  `option_name` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置项',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置项值',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name_uindex` (`option_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `emlog_options` WRITE;
/*!40000 ALTER TABLE `emlog_options` DISABLE KEYS */;

INSERT INTO `emlog_options` (`option_id`, `option_name`, `option_value`)
VALUES
	(1,'blogname','EMLOG'),
	(2,'bloginfo','使用emlog搭建的站点'),
	(3,'site_title',''),
	(4,'site_description',''),
	(5,'site_key','emlog'),
	(6,'log_title_style','0'),
	(7,'blogurl','https://www.emlog.dev/'),
	(8,'icp',''),
	(9,'footer_info','powered by <a href=\"https://www.emlog.net\">emlog pro</a>'),
	(10,'admin_perpage_num','15'),
	(11,'rss_output_num','10'),
	(12,'rss_output_fulltext','y'),
	(13,'index_lognum','10'),
	(14,'index_comnum','10'),
	(15,'index_newlognum','5'),
	(16,'index_hotlognum','5'),
	(17,'comment_subnum','20'),
	(18,'nonce_templet','default'),
	(19,'admin_style','default'),
	(20,'tpl_sidenum','1'),
	(21,'comment_code','n'),
	(22,'comment_needchinese','y'),
	(23,'comment_interval','60'),
	(24,'isgravatar','y'),
	(25,'isthumbnail','y'),
	(26,'att_maxsize','1024000'),
	(27,'att_type','rar,zip,gif,jpg,jpeg,png,txt,pdf,docx,doc,xls,xlsx,mp4'),
	(28,'att_imgmaxw','600'),
	(29,'att_imgmaxh','370'),
	(30,'comment_paging','y'),
	(31,'comment_pnum','10'),
	(32,'comment_order','newer'),
	(33,'iscomment','y'),
	(34,'ischkcomment','y'),
	(35,'isurlrewrite','0'),
	(36,'isalias','n'),
	(37,'isalias_html','n'),
	(38,'timezone','Asia/Shanghai'),
	(39,'active_plugins','a:1:{i:0;s:13:\"tips/tips.php\";}'),
	(40,'widget_title','a:11:{s:7:\"blogger\";s:12:\"个人资料\";s:8:\"calendar\";s:6:\"日历\";s:3:\"tag\";s:6:\"标签\";s:4:\"sort\";s:6:\"分类\";s:7:\"archive\";s:6:\"存档\";s:7:\"newcomm\";s:12:\"最新评论\";s:6:\"newlog\";s:12:\"最新文章\";s:6:\"hotlog\";s:12:\"热门文章\";s:4:\"link\";s:6:\"链接\";s:6:\"search\";s:6:\"搜索\";s:11:\"custom_text\";s:15:\"自定义组件\";}'),
	(41,'custom_widget','a:0:{}'),
	(42,'widgets1','a:4:{i:0;s:7:\"blogger\";i:1;s:7:\"newcomm\";i:2;s:4:\"link\";i:3;s:6:\"search\";}'),
	(43,'detect_url','n'),
	(44,'emkey',''),
	(45,'login_code','n'),
	(46,'is_signup','y'),
	(47,'ischkarticle','y'),
	(48,'smtp_mail',''),
	(49,'smtp_pw',''),
	(50,'smtp_server',''),
	(51,'smtp_port',''),
	(52,'is_openapi','y'),
	(53,'apikey','dbe37933966ce7b0aac37e56fa87dedd');

/*!40000 ALTER TABLE `emlog_options` ENABLE KEYS */;
UNLOCK TABLES;


# emlog_sort
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emlog_sort`;

CREATE TABLE `emlog_sort` (
  `sid` int unsigned NOT NULL AUTO_INCREMENT COMMENT '分类表',
  `sortname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名',
  `alias` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '别名',
  `taxis` int unsigned NOT NULL DEFAULT '0' COMMENT '排序序号',
  `pid` int unsigned NOT NULL DEFAULT '0' COMMENT '父分类ID',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '备注',
  `template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类模板',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# emlog_storage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emlog_storage`;

CREATE TABLE `emlog_storage` (
  `sid` int NOT NULL AUTO_INCREMENT COMMENT '对象存储表',
  `plugin` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '插件名',
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '对象名',
  `type` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '对象数据类型',
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '对象值',
  `createdate` int NOT NULL COMMENT '创建时间',
  `lastupdate` int NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `plugin` (`plugin`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# emlog_tag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emlog_tag`;

CREATE TABLE `emlog_tag` (
  `tid` int unsigned NOT NULL AUTO_INCREMENT COMMENT '标签表',
  `tagname` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标签名',
  `gid` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章ID',
  PRIMARY KEY (`tid`),
  KEY `tagname` (`tagname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# emlog_twitter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emlog_twitter`;

CREATE TABLE `emlog_twitter` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '笔记表',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '笔记内容',
  `img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片',
  `author` int NOT NULL DEFAULT '1' COMMENT '作者UID',
  `date` bigint NOT NULL COMMENT '创建时间',
  `replynum` int unsigned NOT NULL DEFAULT '0' COMMENT '回复数量',
  PRIMARY KEY (`id`),
  KEY `author` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# emlog_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `emlog_user`;

CREATE TABLE `emlog_user` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT COMMENT '用户表',
  `username` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户密码',
  `nickname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `role` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户组',
  `ischeck` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '内容是否需要管理员审核',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `ip` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'ip地址',
  `state` tinyint NOT NULL DEFAULT '0' COMMENT '用户状态 0正常 1禁用',
  `create_time` int NOT NULL COMMENT '创建时间',
  `update_time` int NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `emlog_user` WRITE;
/*!40000 ALTER TABLE `emlog_user` DISABLE KEYS */;

INSERT INTO `emlog_user` (`uid`, `username`, `password`, `nickname`, `role`, `ischeck`, `photo`, `email`, `description`, `ip`, `state`, `create_time`, `update_time`)
VALUES
	(1,'admin','$P$Bl6AR6ZGwM5aH06ym3QVtrhFTlh9UV/','emer','admin','n','','emlog@qq.com','','',0,1657034772,1657034772);

/*!40000 ALTER TABLE `emlog_user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
