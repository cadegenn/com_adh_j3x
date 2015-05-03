<?php
/** 
 *  @component	com_adh
 * 
 *  @copyright	Copyright (C) 2012-2015 DEGENNES Charles-Antoine <cadegenn@gmail.com>
 *  @license	Affero GNU General Public License Version 3; see LICENSE.txt
 * 
 */

defined('_JEXEC') or die;
JHtml::_('behavior.tabstate');

$input = JFactory::getApplication()->input;

if (!JFactory::getUser()->authorise('core.manage', 'com_tags'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

$controller	= JControllerLegacy::getInstance('Adh');
$controller->execute($input->get('task'));
$controller->redirect();
