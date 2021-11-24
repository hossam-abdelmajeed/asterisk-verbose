# asterisk-verbose
	Loading Asterisk call stream from BASH into MySQL database

1. What is asterisk-verbose?

	asterisk-verbose is a small PHP script that fetchs data from Asterisk call stream using BASH SSH command into a MySQL database.
	
2. Settingup asterisk-verbose:

	- Update config.php file with your server information:
		- **MEM_LIMIT** is PHP memory_limit, by default I set it to 1 Gigabyte, to get raide of 
				` Fatal error: Allowed memory size of x bytes exhausted (tried to allocate x bytes) in /path/of/script/file `
				It's all yours to in/decrease it.
		- **LOG_FILE** is the file will store all errors/infos if it occurred.
		- **TRUNKS_TO_FETCH** it is an array holds needed TRUNKs that will be considered into parsing and inserted into database
		- you can examples as below:
		```	+------------------+
			+------------------+
			| trunks	       |
			+------------------+
			| my-dialout-trunk |
			| my-dial-one      |
			+------------------+
		```
		- **TRUNKS_TO_EXCLUDE** it is an array holds TRUNKs' names that will NOT be considered into parsing the call stream
		- you can examples as below:
		```	+---------------------+
			+---------------------+
			| trunks              |
			+---------------------+
			| SIP/to_myvoiptrunk  |
			+---------------------+
		```
		- **EXTENSIONS_TO_FETCH** it is an array holds Extensions' numbers that will be considered into parsing the call stream regardless the TUNKS TO FETCH
		- you can examples as below:
		```	+------------+
			+------------+
			| extensions |
			+------------+
			| 1000       |
			| 548333     |
			| xxxx       |
			+------------+
		```
		- **SRV** the MySQL hostname to connect to.
		- **USR** the MySQL username to use.
		- **PWD** the MySQL password to use.
		- **DB** the MySQL database to connect to.
		- **FETCHING_PERIOD** is the fetching sequence that will hit BASH CLI with VERBOSE command, per milliseconds.
		
	- You have to prepare your Database, using these commands:
		```
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
		```
3. Starting verbose_service.php as a service.

4. If you updated the config file, you will need to resatr the service to reload the new configurations.
	
That's it.
