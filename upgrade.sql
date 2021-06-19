# emlog pro database upgrade sql
ALTER TABLE {db_prefix}blog CHANGE COLUMN gid gid int(10) unsigned NOT NULL auto_increment;
ALTER TABLE {db_prefix}blog CHANGE COLUMN sortid sortid int(10) NOT NULL default '-1';
ALTER TABLE {db_prefix}blog CHANGE COLUMN views views int(10) unsigned NOT NULL default '0';
ALTER TABLE {db_prefix}blog CHANGE COLUMN comnum comnum int(10) unsigned NOT NULL default '0';
INSERT INTO {db_prefix}options (option_name, option_value) VALUES ('att_img2maxw','420');
INSERT INTO {db_prefix}options (option_name, option_value) VALUES ('att_img2maxh','460');