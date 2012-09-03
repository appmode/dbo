<?php
// config file used by mod_dbo
// copy this file into the base directory with your other scripts
// yeah, I know, it's not safe... but... HEY, LOOK OVER THERE!


		
	// db host      : REPLACE THIS WITH YOURS
	$strHost        = "localhost";
	
	// db username  : REPLACE THIS WITH YOURS
	$strUserName    = "user";
	
	// db password  : REPLACE THIS WITH YOURS
	$strPassword    = "password";
	
	// db name      : REPLACE THIS WITH YOURS
	$strDbName      = "myDatabase";
	
	

	// add the database config
	Config()->addDatabase($strDbName, $strUserName, $strPassword, $strHost);
?>
