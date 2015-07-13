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
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * adh View
 */
class adhViewAdherents extends JViewLegacy
{
	/**
	 * adherents view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		if ($this->getLayout() !== 'modal')
		{
			// Ajouter le sous menu
			AdhHelper::addSubmenu('adherents');	// => admin/helpers/adh.php
		}

		// Get data from the model
		$this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->authors       = $this->get('Authors');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		$this->total		 = $this->get('Total');			// JModelList::getTotal()

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));

			return false;
		}

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
		}

		parent::display($tpl);
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		$canDo = JHelperContent::getActions('com_adh', 'adherent', $this->state->get('filter.adherent_id'));
		$user  = JFactory::getUser();

		// voir d'autres boutons dans /administrator/includes/toolbar.php
		JToolBarHelper::title(JText::_('COM_ADH').' : '.JText::_('COM_ADH_SUBMENU_ADHERENTS'), 'adh');
		if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_adh', 'core.create'))) > 0 )
		{
			JToolBarHelper::addNew('adherent.add');
		}
		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
		{
			JToolBarHelper::editList('adherent.edit');
		}
		JToolBarHelper::divider();
		if ($canDo->get('core.edit.state'))
		{
			JToolBarHelper::publishList('adherents.publish');
			JToolBarHelper::unpublishList('adherents.unpublish');
			JToolBarHelper::divider();
			JToolBarHelper::archiveList('adherents.archive');
			JToolbarHelper::trash('articles.trash');
		}
		if ($canDo->get('core.delete'))
		{
			JToolBarHelper::deleteList(JText::_('COM_ADH_AREYOUSURE'),'adherents.delete');
		}

		if ($user->authorise('core.admin', 'com_adh') || $user->authorise('core.options', 'com_adh'))
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_adh');
		}
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_ADH_ADMINISTRATION'));
	}
	
	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'a.ordering'     => JText::_('JGRID_HEADING_ORDERING'),
			'LOWER(a.personne_morale)'        => JText::_('JSTATUS'),
			'LOWER(a.nom)'        => JText::_('JGLOBAL_TITLE'),
			'LOWER(a.prenom)' => JText::_('JCATEGORY'),
			'a.email'   => JText::_('JGRID_HEADING_ACCESS'),
			'LOWER(a.ville)'   => JText::_('JAUTHOR'),
			'LOWER(a.pays)'       => JText::_('JGRID_HEADING_LANGUAGE'),
			'a.published'      => JText::_('JDATE'),
			'a.id'           => JText::_('JGRID_HEADING_ID'),
		);
	}

}

?>
