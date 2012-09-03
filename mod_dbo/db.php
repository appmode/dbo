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
// aphplixDb Class
//--------------------------------------------------------------------//
/* aphplixDb
 *
 * Provides low level database access
 */
class aphplixDb extends aphplixDboBase
{
	// holds the zend db adapter object
	private $_objDb         = NULL;
	
	// holds config for the db connection
	private $_arrDbConf     = NULL;
	
	// hold last db error message
	public $error           = NULL;
	
	/* do we have a connection?
	 * TRUE  = have connection
	 * FALSE = do not have connection
	 * NULL  = no databases defined
	 */
	private $_bolConnection = NULL;
	
	public function __Construct()
	{
		// connect to database server
		foreach (Config()->database() AS $arrServerDetails)
		{
			// make connection object
			$this->_objDb = new Zend_Db_Adapter_Mysqli($arrServerDetails);
			
			// cache db details
			$this->_arrDbConf = $arrServerDetails;
			
			// mark as connected
			$this->_bolConnection = TRUE;
			
			// test connection
			try 
			{
				$this->_objDb->getConnection();
			}
			catch (Exception $e)
			{
				// mark as not connected
				$this->_bolConnection = FALSE;
				
				$this->error = $e;
				
				// try next connection
				continue;
			}
			
			// stop trying connections
			break;
		}
	}
	
	/* db()
	 * returns: zend db adapter object  
	 */
	public function db()
	{
		return $this->_objDb;
	}
	
	/* isConnected()
	 * 
	 * check if a db connection exists
	 * 
	 * returns: bool    TRUE  = connected
	 *                  FALSE = not connected
	 *                  NULL  = no databases defined
	 */
	public function isConnected()
	{
		return $this->_bolConnection;
	}
	
	/* query()
	 * 
	 * run an sql query on the database
	 * 
	 * param:   $strSql     sql query to be run
	 * 
	 * returns: object      an unbuffered result object, as returned by
	 *                      mysqli::use_result() or FALSE if an error 
	 *                      occurred.
	 */
	public function query($strSql)
	{
		$this->_objDb->getConnection()->real_query($strSql);
		return $this->_objDb->getConnection()->use_result();
	}
	
	/* createView
	 * 
	 * create a view
	 * 
	 * param:   $strName    name of the view to create
	 * param:	$strSql     sql query used to create the view
	 * 
	 * returns: object      an unbuffered result object, as returned by
	 *                      mysqli::use_result() or FALSE if an error 
	 *                      occurred.
	 */
	public function createView($strName, $strSql)
	{
		return $this->query("CREATE OR REPLACE VIEW {$strName} AS {$strSQL}");
	}
	
	/* dropView
	 * 
	 * drop a view
	 * 
	 * param:   $strName    name of the view to drop
	 * 
	 * returns: object      an unbuffered result object, as returned by
	 *                      mysqli::use_result() or FALSE if an error 
	 *                      occurred.
	 */
	public function dropView($strName)
	{
		return $this->query("DROP VIEW IF EXISTS {$strName};");
	}
	
	/* truncateTable
	 * 
	 * truncate a table
	 * 
	 * param:   $strName    name of the table to truncated
	 * 
	 * returns: object      an unbuffered result object, as returned by
	 *                      mysqli::use_result() or FALSE if an error 
	 *                      occurred.
	 */
	public function truncateTable($strName)
	{
		return $this->query("TRUNCATE TABLE {$strName};");
	}
}

//--------------------------------------------------------------------//
// Db Function
//--------------------------------------------------------------------//
/* Db()
 *
 * Global function to access the zend db adapter object
 *
 * returns: object  a zend db adapter object
 */

function Db()
{
	$objDb = Singleton('aphplixDb');
	return $objDb->db();
}

//--------------------------------------------------------------------//
// Database Function
//--------------------------------------------------------------------//
/* Database()
 *
 * Global function to access the db object
 *
 * returns: object  a singleton aphplixDb object
 */
function Database()
{
	return Singleton('aphplixDb');
}


?>
