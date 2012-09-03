<?php

//--------------------------------------------------------------------//
// (c) Copyright 2009-2010 Flame Herbohn (aphplix@gmail.com)
//--------------------------------------------------------------------//

//--------------------------------------------------------------------//
// THIS SOFTWARE IS GPL LICENSED
//--------------------------------------------------------------------//
//  This program is free software; you can redistribute it and/or 
//  modify it under the terms of the GNU General Public License 
//  (version 2) as published by the Free Software Foundation.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU Library General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place - Suite 330, Boston, 
//  MA 02111-1307, USA.
//--------------------------------------------------------------------//

//--------------------------------------------------------------------//
// INSTRUCTIONS
//--------------------------------------------------------------------//
//
// 1) Install the Zend Framework
// 2) Ensure that the path in your php.ini includes the path to the Zend 
//    Framework.
// 3) Run the mysql commands from the DATABASE section below to create
//    the required database and user.
// 4) Run this script from the command line:
//    for example /usr/bin/php sample.php

//--------------------------------------------------------------------//
// DATABASE
//--------------------------------------------------------------------//
//
// use the following mysql commands to create the database & user 
// required for this sample script.
//

/*
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

*/

//--------------------------------------------------------------------//
// INCLUDES
//--------------------------------------------------------------------//

// require dbo class
require_once("mod_dbo/mod_dbo.php");

//--------------------------------------------------------------------//
// SCRIPT
//--------------------------------------------------------------------//

//---------------------------------------//
// check database connection
//---------------------------------------//

if (Database()->isConnected())
{
	echo "Database connection is OK\n";
}
else
{
	echo "Database connection failed\n";
	//echo Database()->error . "\n";
	die();
}

//---------------------------------------//
// insert a record
//---------------------------------------//

Dbo()->myTable->name     = "Fred Smith";
Dbo()->myTable->email    = "fred@smith.com";
$intId = Dbo()->myTable->insert();
if ($intId)
{
	echo "inserted record : {$intId}\n";
}
else
{
	echo "insert failed\n";
	die();
}

//---------------------------------------//
// clear a record
//---------------------------------------//
	
// clean the dbo
Dbo()->myTable->clean();

//---------------------------------------//
// select a record
//---------------------------------------//

// select the record
$bolSelect = Dbo()->myTable->select($intId);

if ($bolSelect)
{
	echo "selected record {$intId}\n";
}
else
{
	echo "select failed\n";
	die();
}

//---------------------------------------//
// use fields from a record
//---------------------------------------//

if (Dbo()->myTable->name == "Fred Smith")
{
	// call field as a property to return its value
	echo "email for " . Dbo()->myTable->name . " is : ";
	
	// call field as a method to display its value
	Dbo()->myTable->email();
	
	echo "\n";
} 

//---------------------------------------//
// update a record
//---------------------------------------//

Dbo()->myTable->email = "fred@new-email.com";
$bolUpdate = Dbo()->myTable->update();

if ($bolUpdate)
{
	echo "updated record " . Dbo()->myTable->id . "\n";
}
else
{
	echo "update failed\n";
	die();
}

//---------------------------------------//
// use a record as an iterator
//---------------------------------------//

foreach (Dbo()->myTable as $strName=>$mixValue)
{
	echo "{$strName} = {$mixValue}\n";
}


?>
