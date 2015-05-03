/* 
 *  Copyright (C) 2012-2014 charly
 *  com_adh is a joomla! 2.5 component [http://www.volontairesnature.org]
 *  
 *  This file is part of com_adh.
 * 
 *     com_adh is free software: you can redistribute it and/or modify
 *     it under the terms of the Affero GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     com_adh is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     Affero GNU General Public License for more details.
 * 
 *     You should have received a copy of the Affero GNU General Public License
 *     along with com_adh.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */


function cotiz() {
	/**
	 * Unique id
	 *
	 * @var    integer
	 * @since  0.0.31
	 */
	this.id = 0;

	/**
	 * tarif_id
	 * 
	 * @int
	 * @since	0.0.31
	 */
	this.tarif_id = 0;
}

/**
 * Method to add fields to the DOM to let adminuser to add a new cotisation
 * 
 * @returns {undefined}
 */
cotiz.prototype.add = function() {
	var ul = document.getElementById("ul_cotiz");
	var li = document.createElement("li")
	ul.appendChild(li);
}