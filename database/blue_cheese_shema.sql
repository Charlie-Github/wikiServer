CREATE TABLE `users` (
  `uid` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `usr_name` varchar(45) NOT NULL DEFAULT 'Anonymous',
  `usr_pwd` varchar(45) NOT NULL,
  `selfie` varchar(45) NOT NULL DEFAULT 'default_selfie.png',
  `last_login_time` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  `privilege` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid_UNIQUE` (`uid`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7996 DEFAULT CHARSET=utf8;



CREATE TABLE `reviews` (
  `rid` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned zerofill NOT NULL,
  `fid` int(10) unsigned zerofill NOT NULL,
  `comments` varchar(5000) COLLATE utf8_bin NOT NULL,
  `rate` int(1) NOT NULL DEFAULT '0',
  `likes` int(5) NOT NULL DEFAULT '0',
  `dislikes` int(5) NOT NULL DEFAULT '0',
  `last_edit_time` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  PRIMARY KEY (`uid`,`fid`),
  UNIQUE KEY `rid_UNIQUE` (`rid`),
  KEY `fk_reviews_1_idx` (`fid`),
  CONSTRAINT `fk_reviews_1` FOREIGN KEY (`fid`) REFERENCES `foods` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reviews_2` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `photos` (
  `pid` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `fid` int(10) unsigned zerofill NOT NULL,
  `url` varchar(45) COLLATE utf8_bin NOT NULL,
  `uid` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `pid_UNIQUE` (`pid`),
  UNIQUE KEY `url_UNIQUE` (`url`),
  KEY `fk_photos_1_idx` (`uid`),
  KEY `fk_photos_2_idx` (`fid`),
  CONSTRAINT `fk_photos_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_photos_2` FOREIGN KEY (`fid`) REFERENCES `foods` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1443 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `foods_EN` (
  `fid` int(10) unsigned zerofill NOT NULL,
  `title` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `tags` varchar(200) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `last_edit_time` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  `uid` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`fid`),
  UNIQUE KEY `fid_UNIQUE` (`fid`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  KEY `fk_foods_EN_3_idx` (`uid`),
  CONSTRAINT `fk_foods_EN_1` FOREIGN KEY (`fid`) REFERENCES `foods` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_foods_EN_2` FOREIGN KEY (`title`) REFERENCES `foods` (`title`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_foods_EN_3` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `foods_CN` (
  `fid` int(10) unsigned zerofill NOT NULL,
  `title` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `tags` varchar(200) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `last_edit_time` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  `uid` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`fid`),
  UNIQUE KEY `fid_UNIQUE` (`fid`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  KEY `fk_foods_CN_3_idx` (`uid`),
  CONSTRAINT `fk_foods_CN_1` FOREIGN KEY (`fid`) REFERENCES `foods` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_foods_CN_2` FOREIGN KEY (`title`) REFERENCES `foods` (`title`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_foods_CN_3` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `foods` (
  `fid` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `avg_rate` decimal(2,1) NOT NULL DEFAULT '0.0',
  `rate_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fid`),
  UNIQUE KEY `fid_UNIQUE` (`fid`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=1572 DEFAULT CHARSET=utf8;


CREATE TABLE `feedbacks` (
  `feed_id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned zerofill NOT NULL,
  `content` varchar(500) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  PRIMARY KEY (`feed_id`),
  UNIQUE KEY `feed_id_UNIQUE` (`feed_id`),
  KEY `uid_idx` (`uid`),
  CONSTRAINT `uid` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;
