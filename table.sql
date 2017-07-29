DROP TABLE IF EXISTS `tplp`.`srlog`;
CREATE TABLE  `tplp`.`srlog` (
  `IP` varchar(30) NOT NULL DEFAULT '',
  `PORT` int(10) unsigned NOT NULL DEFAULT '0',
  `GAME` int(10) unsigned NOT NULL DEFAULT '0',
  `DTB` datetime DEFAULT NULL,
  `DTE` datetime DEFAULT NULL,
  `OS` varchar(45) NOT NULL DEFAULT '',
  `BROWSER` varchar(45) NOT NULL DEFAULT '',
  `CNT` int(10) unsigned NOT NULL DEFAULT '0',
  `LNG` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`IP`,`PORT`,`GAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;