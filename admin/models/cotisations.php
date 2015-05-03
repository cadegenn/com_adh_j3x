<?php
/**
 * @package		com_adh
 * @subpackage	
 * @brief		com_adh helps you manage the people within an association
 * @copyright	Copyright (C) 2010 - 2014 DEGENNES Charles-Antoine <cadegenn@gmail.com>
 * @license		Affero GNU General Public License version 3 or later; see LICENSE.txt
 * 
 * @TODO		
 */

/** 
 *  Copyright (C) 2012-2014 DEGENNES Charles-Antoine <cadegenn@gmail.com>
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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * adhModelCotisations List Model
 */
class adhModelCotisations extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'c.id',
				'personne_morale', 'a.personne_morale',
				'nom', 'a.nom', 'LOWER(a.nom)',
				'prenom', 'a.prenom', 'LOWER(a.prenom)',
				'date_debut_cotiz', 'c.date_debut_cotiz',
				'montant', 'c.montant',
				'mode_paiement', 'c.mode_paiement',
				'payee', 'c.payee'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('c.*, a.personne_morale AS personne_morale, a.nom AS nom, a.prenom AS prenom');
		$query->from('#__adh_cotisations AS c, #__adh_adherents AS a');
		$query->where('c.adherent_id = a.id');
		
		$letter = $this->getState('letter.search');
		if (!empty($letter)) {
			// case sensitive
			//$query->where('(cotisations.nom LIKE "%'.$search.'%")', 'OR')->where('(cotisations.prenom LIKE "%'.$search.'%")');
			// case insensitive
			$query->where('(nom COLLATE utf8_unicode_ci LIKE "'.$letter.'%" OR personne_morale COLLATE utf8_unicode_ci LIKE "'.$letter.'%")');
		}
		
		$year = $this->getState('year.search');
		if (!empty($year)) {
			$query->where('YEAR(date_debut_cotiz) = '.$year);
		}
				
		// Filter (http://docs.joomla.org/How_to_add_custom_filters_to_component_admin)
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			// case sensitive
			//$query->where('(cotisations.nom LIKE "%'.$search.'%")', 'OR')->where('(cotisations.prenom LIKE "%'.$search.'%")');
			// case insensitive
			//$query->where('(#__adh_cotisations.nom COLLATE utf8_unicode_ci LIKE "%'.$search.'%")', 'OR')->where('(#__adh_cotisations.prenom COLLATE utf8_unicode_ci LIKE "%'.$search.'%")');
			$query->where('(nom COLLATE utf8_unicode_ci LIKE "%'.$search.'%" OR prenom COLLATE utf8_unicode_ci LIKE "%'.$search.'%" OR personne_morale COLLATE utf8_unicode_ci LIKE "%'.$search.'%")');
		}
				
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'c.date_debut_cotiz');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		$query->order($db->escape($orderCol.' '.$orderDirn));
		// whatever order user choose, we order 1st with his choice, and then with this
		$query->order('date_debut_cotiz DESC, nom ASC, prenom ASC');

		return $query;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since		1.6
	 * @see			http://docs.joomla.org/How_to_add_custom_filters_to_component_admin
	*/
	protected function populateState($ordering = null, $direction = null)
	{
		   // Initialise variables.
		   $app = JFactory::getApplication('administrator');

		   // Load the filter state.
		   $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		   $this->setState('filter.search', $search);
		   $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		   $this->setState('filter.state', $state);

		   // Load the year state.
		   $search = $this->getUserStateFromRequest($this->context.'.year.search', 'year_search');
		   $this->setState('year.search', $search);
		   $state = $this->getUserStateFromRequest($this->context.'.year.state', 'year_state', '', 'string');
		   $this->setState('year.state', $state);

		   // Load the letter state.
		   $search = $this->getUserStateFromRequest($this->context.'.letter.search', 'letter_search');
		   $this->setState('letter.search', $search);
		   $state = $this->getUserStateFromRequest($this->context.'.letter.state', 'letter_state', '', 'string');
		   $this->setState('letter.state', $state);

		   // List state information.
		   parent::populateState('c.date_debut_cotiz', 'asc');
	}


}
?>
