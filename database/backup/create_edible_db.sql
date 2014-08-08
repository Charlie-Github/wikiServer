CREATE DATABASE `edibleDB_CN` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

CREATE TABLE `Foods` (
  `Food_Title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Lang` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Food_Title`),
  UNIQUE KEY `Food_Title_UNIQUE` (`Food_Title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Foods_EN` (
  `Food_Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Food_Name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tags` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Create_Date` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  PRIMARY KEY (`Food_Title`),
  UNIQUE KEY `Food_Title_UNIQUE` (`Food_Title`),
  CONSTRAINT `Foods_EN_Food_Title` FOREIGN KEY (`Food_Title`) REFERENCES `Foods` (`Food_Title`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Foods_CN` (
  `Food_Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Food_Name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tags` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Create_Date` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  PRIMARY KEY (`Food_Title`),
  UNIQUE KEY `Food_Title_UNIQUE` (`Food_Title`),
  CONSTRAINT `Foods_EN_Food_Title` FOREIGN KEY (`Food_Title`) REFERENCES `Foods` (`Food_Title`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `Photos` (
  `Photo_Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Uid` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Food_Title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Create_Date` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  PRIMARY KEY (`Photo_Name`),
  UNIQUE KEY `Photo_Name_UNIQUE` (`Photo_Name`),
  KEY `Photos_Uid_idx` (`Uid`),
  KEY `Photos_Food_Title_idx` (`Food_Title`),
  CONSTRAINT `Photos_Uid` FOREIGN KEY (`Uid`) REFERENCES `User` (`Uid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `Photos_Food_Title` FOREIGN KEY (`Food_Title`) REFERENCES `Foods` (`Food_Title`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Reviews` (
  `Uid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Food_Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Review` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Rate` int(11) DEFAULT NULL,
  `Like_Num` int(11) DEFAULT NULL,
  `Dislike_Num` int(11) DEFAULT NULL,
  `Create_Date` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  PRIMARY KEY (`Uid`,`Food_Title`),
  KEY `Reviews_Food_Title_idx` (`Food_Title`),
  CONSTRAINT `Reviews_Uid` FOREIGN KEY (`Uid`) REFERENCES `User` (`Uid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `Reviews_Food_Title` FOREIGN KEY (`Food_Title`) REFERENCES `Foods` (`Food_Title`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `User` (
  `Uid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Create_Date` datetime DEFAULT NULL,
  PRIMARY KEY (`Uid`),
  UNIQUE KEY `Uid_UNIQUE` (`Uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

