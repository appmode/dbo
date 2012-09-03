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
// aphplixDboConfig Class
//--------------------------------------------------------------------//
/* aphplixDboConfig
 *
 * Config class for mod_dbo
 *
 * called as a singleton by the global Config() function,
 * creates an object to hold database config details for mod_dbo
 *
 */
class aphplixDboConfig
{
	// DB server config array
	private $_dbServer	= Array();

	/* addDatabase()
	 * 
	 * add config details for a database
	 * 
	 * param:   $strDbName      name of the database
	 * param:   $strUserName    optional name of the db user
	 * param:   $strPassword    optional password for the db user
	 * param:	$strHost        optional host for the db
	 * 
	 * returns: void
	 */
	public function addDatabase($strDbName, $strUserName='', $strPassword='', $strHost='')
	{
		$arrDb              = Array();
		$arrDb['dbname']    = $strDbName;
		$arrDb['username']  = $strUserName;
		$arrDb['password']  = $strPassword;
		$arrDb['host']      = $strHost;

		$this->_dbServer[]  = $arrDb;
	}
	
	/* database()
	 * 
	 * returns: array   database config
	 */
	public function database()
	{
		return $this->_dbServer;
	}
}

//--------------------------------------------------------------------//
// Config Function
//--------------------------------------------------------------------//
/* Config()
 *
 * Global function to access the config object
 *
 * returns: object  a singleton aphplixDboConfig object
 */
function Config()
{
	return Singleton('aphplixDboConfig');
}

?>
