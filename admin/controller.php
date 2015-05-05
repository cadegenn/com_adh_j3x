<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of chantiers component
 */
class adhController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false) {
		$input = JFactory::getApplication()->input;
		$input->set('i', $input->getCmd('view', 'adh'));
 
		// call parent behavior
		parent::display($cachable, $urlparams);
		
	}
}

?>
