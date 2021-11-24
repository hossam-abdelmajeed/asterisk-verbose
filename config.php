<?php
define('MEM_LIMIT','1G');
define('LOG_FILE',__DIR__ . '/'. 'logs');

define('FETCHING_PERIOD', 1000);

define('TRUNKS_TO_FETCH', serialize(array('macro-dialout-trunk','macro-dial-one')));
define('TRUNKS_TO_EXCLUDE', serialize(array('SIP/to_autocall')));
define('EXTENSIONS_TO_FETCH', serialize(array('')));

define('SRV','localhost');
define('USR','root');
define('PWD','v0IP4dmin@0tlob');
define('DB','vservice');

//////////////////
//DATABASE CREATION//
/////////////////
/*

CREATE DATABASE IF NOT EXISTS `vservice` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `vservice`;
DROP TABLE IF EXISTS `call_stream`;
CREATE TABLE IF NOT EXISTS `call_stream` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel` varchar(50) DEFAULT NULL,
  `context` varchar(50) DEFAULT NULL,
  `extension` varchar(15) DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `application` varchar(10) DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `caller_id` varchar(50) DEFAULT NULL,
  `account_code` varchar(10) DEFAULT NULL,
  `peer_account` varchar(10) DEFAULT NULL,
  `ama_flags` varchar(10) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `bridged_to` varchar(50) DEFAULT NULL,
  `unique_id` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

*/
?>
