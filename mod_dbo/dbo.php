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
// aphplixDbo Class
//--------------------------------------------------------------------//
/* aphplixDbo
 *
 * Database object class
 */
Class aphplixDbo extends aphplixDboBase implements Iterator
{	
	// holds the name of the table
	private $_strTable			= NULL;
	
	// holds the name of the Id (Autoindex Primary Key) column
	private $_strIdColumn 		= 'id';
	private $_objDb				= NULL;
	
	/* __Construct()
	 * 
	 * param:   $strTable     name of the table
	 * param:	$objDb        optional, the zend db adapter object 
	 *                        to use
	 * param:	$strIdColumn  optional, the name of the Id 
	 *                        (Autoindex Primary Key) column
	 * 
	 * returns: void
	 */
	public function __Construct($strTable, $objDb=NULL, $strIdColumn=NULL)
	{
		// store table name
		$this->_strTable = $strTable;
		
		// store db object
		if ($objDb)
		{
			$this->_objDb = $objDb;
		}
		
		// store id column name
		if ($strIdColumn)
		{
			$this->_strIdColumn = $strIdColumn;
		}
	}

	/* clean()
	 * 
	 * cleans the database object (removes it's properties)
	 * 
	 * returns: void
	 */
	public function clean()
	{
		$this->_arrProperty = Array();
	}
	
	/* _db()
	 * 
	 * private method used by the dbo to get the zend db adapter object
	 * 
	 * returns: object  a zend db adapter object
	 */
	private function _db()
	{
		if ($this->_objDb)
		{
			return $this->_objDb;
		}
		else
		{
			return Db();
		}
	}
	
	//----------------------------------------------------------------//
	// ITERATOR METHODS
	//----------------------------------------------------------------//
	
	public function rewind()
	{
		reset($this->_arrProperty);
	}
	
	public function current()
	{
		return current($this->_arrProperty);
	}
	
	public function key()
	{
		return key($this->_arrProperty);
	}
	
	public function next()
	{
		return next($this->_arrProperty);
	}
	
	public function valid()
	{
		return !is_null($this->key());
	}

	//----------------------------------------------------------------//
	// OVERLOAD METHODS
	//----------------------------------------------------------------//
	
	public function __call($strProperty, $arrArguments)
	{
		// output the property value
		echo $this->_arrProperty[$strProperty];

		// return the property value
		return $this->_arrProperty[$strProperty];
	}
	
	//----------------------------------------------------------------//
	// DB METHODS
	//----------------------------------------------------------------//
	
	/* insert()
	 * 
	 * insert the dbo into the database
	 * 
	 * returns: int     the Id (Autoindex Primary Key) for the inserted 
	 *                  record, or FALSE if the insert failed.
	 */
	public function insert()
	{
		// store the current Id temporarily
		$intId = $this->_arrProperty[$this->_strIdColumn];
		
		// clear the Id
		unset($this->_arrProperty[$this->_strIdColumn]);
		
		// insert record into database
		if (!$this->_db()->Insert($this->_strTable, $this->_arrProperty))
		{
			// reset the Id
			$this->_arrProperty[$this->_strIdColumn] = $intId;
			return FALSE;
		}
		
		// set Id
		$this->_arrProperty[$this->_strIdColumn] = $this->_db()->LastInsertId();
		
		// return Id
		return $this->_arrProperty[$this->_strIdColumn];
	}
	
	/* select()
	 * 
	 * select a dbo record from the database
	 * 
	 * param:   $mixWhere    optional,
	 *                       int     Id of the record to select
	 *                       array   (not yet implamented)
	 *                       object  converts into a string where clause
	 *                       string  where clause
	 *                       
	 * param:   $mixColumns  optional,
	 *                       array   list of columns to select
	 *                               array values are used as column 
	 *                               names
	 *                       string  list of columns to select
	 *                               comma separated  
	 * 
	 * returns: bool         TRUE if the select was valid 
	 *                       (even if no record was found) 
	 *                       FALSE if the select failed.
	 */
	public function select($mixWhere=NULL, $mixColumns=NUll)
	{
		if ((int)$mixWhere)
		{
			$strWhere 	= $this->_strIdColumn." = ".(int)$mixWhere;
		}
		else
		{
			// get id
			$mixId = $this->_arrProperty[$this->_strIdColumn];
			
			// set where clause
			if (is_object($mixId))
			{
				$strWhere 	= $this->_strIdColumn." = ".$mixId->__toString();
			}
			elseif((int)$mixId)
			{
				$strWhere 	= $this->_strIdColumn." = ".(int)$mixId;	
			}
			
			if ($mixWhere)
			{
				if (is_array($mixWhere))
				{
					//TODO!!!!
				}
				elseif (is_object($mixWhere))
				{
					$mixWhere = $mixWhere->__toString();
				}
				
				if ($strWhere)
				{
					$mixWhere .= " AND $strWhere";
				}
				$strWhere = $mixWhere;
			}
		}
		
		// a where clause is required
		if (!$strWhere)
		{
			return FALSE;	
		}
		
		// set columns
		if (is_array($mixColumns))
		{
			$strColumns = implode(',', $mixcolumns);
		}
		elseif (is_string($mixColumns))
		{
			$strColumns = $mixColumns;
		}
		
		if (!$strColumns)
		{
			$strColumns = "*";
		}
		
		// build query
		$strQuery = "SELECT {$strColumns} FROM {$this->_strTable} WHERE $strWhere";
		
		// select record from database & return the result
		if (!$arrResult = $this->_db()->FetchRow($strQuery))
		{
			return FALSE;
		}

		$this->_arrProperty = $arrResult;
		return TRUE;
	}
	
	/* update()
	 * 
	 * update the dbo record in the database
	 * 
	 * param:   $mixWhere    optional,
	 *                       array   (not yet implamented)
	 *                       object  converts into a string where clause
	 *                       string  where clause
	 *                       
	 * param:   $mixColumns  optional,
	 *                       array   list of columns to update
	 *                               array values are used as column 
	 *                               names
	 *                       string  list of columns to update
	 *                               comma separated  
	 * 
	 * returns: bool         TRUE if the record was updated 
	 *                       FALSE if the record was not updated
	 */
	public function update($mixWhere=NULL, $mixColumns=NULL)
	{
		// get id
		$mixId = $this->_arrProperty[$this->_strIdColumn];
		
		// set where clause
		if (is_object($mixId))
		{
			$strWhere 	= $this->_strIdColumn." = ".$mixId->__toString();
		}
		elseif((int)$mixId)
		{
			$strWhere 	= $this->_strIdColumn." = ".(int)$mixId;	
		}
		
		if ($mixWhere)
		{
			if (is_array($mixWhere))
			{
				//TODO!!!!
			}
			elseif (is_object($mixWhere))
			{
				$mixWhere = $mixWhere->__toString();
			}
			
			if ($strWhere)
			{
				$mixWhere .= " AND $strWhere";
			}
			$strWhere = $mixWhere;
		}
		
		// a where clause is required
		if (!$strWhere)
		{
			return FALSE;	
		}

		// clear the Id
		unset($this->_arrProperty[$this->_strIdColumn]);
		
		// work out the values to be updated
		$arrValues = Array();
		if (is_string($mixColumns))
		{
			$mixColumns = explode(',', $mixColumns);
		}
		if ($mixColumns && is_array($mixColumns))
		{
			foreach ($mixColumns AS $strColumn)
			{
				if (trim($strColumn))
				{
					$arrValues[$strColumn] = $this->_arrProperty[$strColumn];
				}
			}
		}
		else
		{
			$arrValues = $this->_arrProperty;
		}
		
		// update record in database
		$mixReturn = $this->_db()->Update($this->_strTable, $arrValues, $strWhere);
		
		// reset the id
		if ($mixId)
		{
			$this->_arrProperty[$this->_strIdColumn] = $mixId;
		}
		
		// return
		if ($mixReturn)
		{
			return TRUE;
		}
		
		return FALSE;
	}
}

//--------------------------------------------------------------------//
// aphplixDboLoaer Class
//--------------------------------------------------------------------//
/* aphplixDboLoaer
 *
 * Class for loading dbo objects
 *
 * called as a singleton by the global Dbo() function,
 * creates an object to hold dbo objects
 *
 */
class aphplixDboLoaer extends aphplixDboBase
{
	public function __get($strName)
	{
		if (!array_key_exists($strName, $this->_arrProperty))
		{
			$this->_arrProperty[$strName] = new aphplixDbo($strName);
		}
		return $this->_arrProperty[$strName];
	}
}

//--------------------------------------------------------------------//
// Dbo Function
//--------------------------------------------------------------------//
/* Dbo()
 *
 * Global function to access dbo objects
 *
 * returns: object  a singleton aphplixDboLoaer object
 */
function Dbo()
{
	return Singleton('aphplixDboLoaer');
}

?>
