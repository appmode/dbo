dbo
===

simple PHP database objects

This is a cut down version of mod_dbo, the database object module from
the aphplix project. Some features (including error handling and 
security features) have been removed to simplify the code.

The code uses object oriented PHP 5 features including:
* Public, private & protected methods and properties.
* Static methods.
* Class inheritance.
* Object overloading.
* Implementation of an iterator.
* Use of the singleton design pattern.
* Use of the __clone() method.

A sample script is included (sample.php) which demonstrates the 
functionality of mod_dbo.

This version of mod_dbo has not been extensively tested, is insecure 
and not feature complete. It is for demonstration purposes only and
should not be used in a production environment.


INSTRUCTIONS
--------------------------------------------------------------------

* Install the Zend Framework
* Ensure that the path in your php.ini includes the path to the Zend Framework.
* Run the mysql commands from the DATABASE section below to create the required database and user.
* Run this script from the command line, for example /usr/bin/php sample.php


DATABASE
--------------------------------------------------------------------

use the following mysql commands to create the database & user 
required for this sample script.

	CREATE DATABASE `myDatabase`;

	CREATE TABLE  `myDatabase`.`myTable` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`name` VARCHAR( 100 ) NOT NULL ,
	`email` VARCHAR( 150 ) NOT NULL
	) ENGINE = MYISAM ;

	CREATE USER 'user'@'localhost' IDENTIFIED BY  'password';

	GRANT USAGE ON * . * TO  'user'@'localhost' IDENTIFIED BY  'password' 
	WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 
	MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

	GRANT SELECT , INSERT , UPDATE , CREATE VIEW , SHOW VIEW ON  
	`myDatabase` . * TO  'user'@'localhost';

