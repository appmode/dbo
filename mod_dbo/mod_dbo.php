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
// mod_dbo
//--------------------------------------------------------------------//
/* mod_dbo is a database object module that provides simple access to 
 * data as objects.
 *
 * mod_dbo originates from the aphplix project. This version has been
 * cut down and is intended for demonstration only. Some features
 * (including error handling and security features) have been removed
 * to simplify the code. This version should NOT be used in a production
 * environment.
 */

//--------------------------------------------------------------------//
// REQUIREMENTS
//--------------------------------------------------------------------//
//
// MySQL 5
// PHP 5
// Zend Framework
// Path to Zend Framework set correctly in php.ini 
//   or in the CONFIG section below
//
//--------------------------------------------------------------------//

//--------------------------------------------------------------------//
// CONFIG
//--------------------------------------------------------------------//

// path to the Zend Framework (not required if this is set in php.ini)
$strZendPath = "/usr/share/php/libzend-framework-php/";


//--------------------------------------------------------------------//
// SCRIPT
//--------------------------------------------------------------------//

// set error reporting level
error_reporting(E_ERROR | E_PARSE);

// set zend include path
if ($strZendPath)
{
	set_include_path(get_include_path() . PATH_SEPARATOR . $strZendPath);
}

// zend includes
include('Zend/Db/Adapter/Mysqli.php');

// dbo includes
require_once('mod_dbo/base.php');
require_once('mod_dbo/config.php');
require_once('mod_dbo/singleton.php');
require_once('mod_dbo/db.php');
require_once('mod_dbo/dbo.php');

// dbo config
require_once('config.dbo.php');

?>
