CREATE TABLE IF NOT EXISTS `sr_clients` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sr_clients_logs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_client` int(4) DEFAULT NULL,
  `date_action` datetime DEFAULT NULL,
  `action_type` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `sr_clients_logs`
	ADD FOREIGN KEY (`ID_client`) REFERENCES `sr_clients` (`ID`);

CREATE TABLE IF NOT EXISTS `sr_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) DEFAULT NULL,
  `passwd` char(32) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

INSERT INTO `sr_users` VALUES (NULL, 'admin', '21232f297a57a5a743894a0e4a801fc3');

