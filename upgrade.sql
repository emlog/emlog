# emlog pro database upgrade sql

# 修改已有字段
# -- eg: ALTER TABLE {db_prefix}blog CHANGE COLUMN comnum comnum int(10) unsigned NOT NULL default '0';

# 插入新的配置记录
# -- eg: INSERT INTO {db_prefix}options (option_name, option_value) VALUES ('att_imgmaxw','420');

# 添加新的字段
# -- eg: ALTER TABLE {db_prefix}blog ADD COLUMN sortop enum('n','y') NOT NULL default 'n' AFTER top;

# v1.0.7 增加卡片笔记
CREATE TABLE `{db_prefix}attachment` (
 `aid` int unsigned NOT NULL AUTO_INCREMENT COMMENT '资源文件表',
 `blogid` int unsigned NOT NULL DEFAULT '0' COMMENT '文章ID（已废弃）',
 `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件名',
 `filesize` int NOT NULL DEFAULT '0' COMMENT '文件大小',
 `filepath` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件路径',
 `addtime` bigint NOT NULL DEFAULT '0' COMMENT '创建时间',
 `width` int NOT NULL DEFAULT '0' COMMENT '图片宽度',
 `height` int NOT NULL DEFAULT '0' COMMENT '图片高度',
 `mimetype` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件mime类型',
 `thumfor` int NOT NULL DEFAULT '0' COMMENT '缩略图的原资源ID（已废弃）',
 PRIMARY KEY (`aid`),
 KEY `blogid` (`blogid`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

# v1.0.6 增加用户登录更新时间及IP
ALTER TABLE `{db_prefix}user` ADD COLUMN `ip` varchar(128) NOT NULL default '' COMMENT 'ip地址' AFTER `description`;
ALTER TABLE `{db_prefix}user` ADD COLUMN `create_time` int(11) NOT NULL COMMENT '创建时间' AFTER `description`;
ALTER TABLE `{db_prefix}user` ADD COLUMN `update_time` int(11) NOT NULL COMMENT '更新时间' AFTER `description`;

# v1.0.4 添加文章封面图
ALTER TABLE `{db_prefix}blog` ADD COLUMN `cover` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '封面图' AFTER `excerpt`;