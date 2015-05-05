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

// Set some global property
$document = JFactory::getDocument();
$document->addStyleSheet( 'components/com_adh/css/com_adh.css' );

// Require helper file
JLoader::register('ADHHelper', JPATH_COMPONENT . '/helpers/adh.php');

$controller	= JControllerLegacy::getInstance('Adh');
$controller->execute($input->get('task'));
$controller->redirect();
