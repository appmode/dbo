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
// aphplixDboBase Class
//--------------------------------------------------------------------//
/* aphplixDboBase
 *
 * Base class for mod_dbo classes to inherit from
 */
class aphplixDboBase
{
	protected $_arrProperty = Array();

	public function __Set($strName, $mixValue)
	{
		return $this->_arrProperty[$strName] = $mixValue;
	}
	
	public function __get($strName)
	{
		return $this->_arrProperty[$strName];
	}
	
	public function __isset($strName)
	{
		return isset($this->_arrProperty[$strName]);
	}
	
	public function __unset($strName)
	{
		unset($this->_arrProperty[$strName]);
	}
	
	public function __clone()
	{
		// shallow copy the property array
		$arrProperty = $this->_arrProperty;
		$this->_arrProperty = Array();
		foreach ($arrProperty AS $strKey=>$mixValue)
		{
			$this->_arrProperty[$strKey] = $mixValue;
		}
	}
}
?>
