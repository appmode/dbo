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
// aphplixSingleton Class
//--------------------------------------------------------------------//
/* aphplixSingleton
 *
 * used to return a singleton instance of a class
 *
 * usage :  $objClass = aphplixSingleton::Instance($strClass);
 */
class aphplixSingleton
{
	// array to hold instances
	private static $arrInstance;
	
	private function __construct()
	{
		return FALSE;
	}
	
	/* Instance()
	 * 
	 * gets a singleton instance of a class
	 * 
	 * param:   $strClass   Name of the class
	 * 
	 * returns: object      singleton instance of the $strClass class
	 */
	public static function Instance($strClass)
	{
		if (!isset(self::$arrInstance[$strClass]))
		{
			self::$arrInstance[$strClass] = new $strClass;
		}
		
		return self::$arrInstance[$strClass];
	}

	// prevent clone
	public function __clone()
	{
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}
}

//--------------------------------------------------------------------//
// Singleton Function
//--------------------------------------------------------------------//
/* Singleton()
 *
 * Global function to access a singleton instance of a class
 *
 * param:   $strClass   Name of the class
 * 
 * returns: object      singleton instance of the $strClass class
 */
function Singleton($strClass)
{
	return aphplixSingleton::Instance($strClass);
}

?>
