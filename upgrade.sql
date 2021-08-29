# emlog pro database upgrade sql

# Modify existing fields
# -- eg: ALTER TABLE {db_prefix}blog CHANGE COLUMN comnum comnum int(10) unsigned NOT NULL default '0';

# Insert new configuration record
# -- eg: INSERT INTO {db_prefix}options (option_name, option_value) VALUES ('att_imgmaxw','420');

# Add new field
# -- eg: ALTER TABLE {db_prefix}blog ADD COLUMN sortop enum('n','y') NOT NULL default 'n' AFTER top;
# v1.0.4 Add article cover image
ALTER TABLE `{db_prefix}blog` ADD COLUMN `cover` varchar(255) NOT NULL default '' AFTER `excerpt`;