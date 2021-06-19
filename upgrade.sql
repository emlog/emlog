# emlog pro database upgrade sql

# 修改已有字段
ALTER TABLE {db_prefix}blog CHANGE COLUMN comnum comnum int(10) unsigned NOT NULL default '0';

# 插入新的配置记录
INSERT INTO {db_prefix}options (option_name, option_value) VALUES ('att_img2maxw','420');

# 添加新的字段
ALTER TABLE {db_prefix}blog ADD COLUMN sortop enum('n','y') NOT NULL default 'n' AFTER top;
ALTER TABLE {db_prefix}blog ADD COLUMN sortop2 enum('n','y') NOT NULL default 'n' AFTER top;
