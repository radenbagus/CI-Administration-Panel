# Dumping structure for table jefflincoln.admin_users
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(50) NOT NULL,
  `password` varchar(255) character set utf8 collate utf8_bin NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(100) character set utf8 collate utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL default '1',
  `role` enum('super','internal','external','none') NOT NULL default 'none',
  `banned` tinyint(1) NOT NULL default '0',
  `ban_reason` varchar(255) character set utf8 collate utf8_bin default NULL,
  `new_password_key` varchar(50) character set utf8 collate utf8_bin default NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# Data exporting was unselected.


# Dumping structure for table jefflincoln.gallery_cat_primary
CREATE TABLE IF NOT EXISTS `gallery_cat_primary` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(80) default NULL,
  `weight` int(10) default NULL,
  `front` varchar(80) NOT NULL COMMENT 'photo id',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# Data exporting was unselected.


# Dumping structure for table jefflincoln.gallery_cat_secondary
CREATE TABLE IF NOT EXISTS `gallery_cat_secondary` (
  `id` int(10) NOT NULL auto_increment,
  `pid` int(10) default NULL,
  `name` varchar(50) default NULL,
  `weight` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# Data exporting was unselected.


# Dumping structure for table jefflincoln.gallery_photos
CREATE TABLE IF NOT EXISTS `gallery_photos` (
  `id` int(10) NOT NULL auto_increment,
  `sid` int(10) default NULL,
  `name` varchar(80) default NULL,
  `details` varchar(80) default NULL,
  `weight` int(10) default NULL,
  `vh` enum('v','h') default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO `admin_users` (`id`, `pid`, `password`, `firstName`, `lastName`, `email`, `activated`, `role`, `banned`, `ban_reason`, `new_password_key`, `created`, `modified`) 

VALUES
	(1, 0, '827ccb0eea8a706c4c34a16891f84e7b', 'Demo', 'user', 'youremail@domain.com', 1, 'super', 0, NULL, NULL, '2011-10-31 15:42:20', '2012-01-05 14:49:42');



INSERT INTO `gallery_cat_primary` (`id`, `name`, `weight`, `front`) VALUES
	(1, 'example gallery', 0, '25');



INSERT INTO `gallery_cat_secondary` (`id`, `pid`, `name`, `weight`) VALUES
	(1, 1, 'sub gallery', 0),
	(2, 1, 'another sub gallery', 2);
	

INSERT INTO `gallery_photos` (`id`, `sid`, `name`, `details`, `weight`, `vh`) VALUES
	(22, 1, 'Lincoln_1170_5thJMH_5275.png', NULL, 1, NULL),
	(52, 1, 'Town1-horizontal-crop1.png', NULL, 0, NULL),
	(29, 3, 'LincolnGCove_2.png', NULL, 1, NULL);`revalori_test``revalori_test``revalori_test`