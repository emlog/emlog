# emlog pro database upgrade sql

# Modify existing fields
# -- eg: ALTER TABLE {db_prefix}blog CHANGE COLUMN comnum comnum int(10) unsigned NOT NULL default '0';

# Insert new configuration record
# -- eg: INSERT INTO {db_prefix}options (option_name, option_value) VALUES ('att_imgmaxw','420');

# Add new field
# -- eg: ALTER TABLE {db_prefix}blog ADD COLUMN sortop enum('n','y') NOT NULL default 'n' AFTER top;
# v1.0.6 Add user login update time and IP
ALTER TABLE `{db_prefix}user` ADD COLUMN `ip` varchar(128) NOT NULL default '' COMMENT 'IP address' AFTER `description`;
ALTER TABLE `{db_prefix}user` ADD COLUMN `create_time` int(11) NOT NULL COMMENT 'Create time' AFTER `description`;
ALTER TABLE `{db_prefix}user` ADD COLUMN `update_time` int(11) NOT NULL COMMENT 'Update time' AFTER `description`;

# v1.0.4 Add article cover image
ALTER TABLE `{db_prefix}blog` ADD COLUMN `cover` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Cover image' AFTER `excerpt`;