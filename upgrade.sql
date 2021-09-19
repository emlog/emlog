# emlog pro database upgrade sql

# 修改已有字段
# -- eg: ALTER TABLE {db_prefix}blog CHANGE COLUMN comnum comnum int(10) unsigned NOT NULL default '0';

# 插入新的配置记录
# -- eg: INSERT INTO {db_prefix}options (option_name, option_value) VALUES ('att_imgmaxw','420');

# 添加新的字段
# -- eg: ALTER TABLE {db_prefix}blog ADD COLUMN sortop enum('n','y') NOT NULL default 'n' AFTER top;
# v1.0.6 增加用户登录更新时间及IP
ALTER TABLE `{db_prefix}user` ADD COLUMN `ip` varchar(128) NOT NULL default '' COMMENT 'ip地址' AFTER `description`;
ALTER TABLE `{db_prefix}user` ADD COLUMN `create_time` int(11) NOT NULL COMMENT '创建时间' AFTER `description`;
ALTER TABLE `{db_prefix}user` ADD COLUMN `update_time` int(11) NOT NULL COMMENT '更新时间' AFTER `description`;

# v1.0.4 添加文章封面图
ALTER TABLE `{db_prefix}blog` ADD COLUMN `cover` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '封面图' AFTER `excerpt`;