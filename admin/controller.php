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

	/*
	 * @brief	export()		export all data
	 * @since	0.0.2
	 */
	public function export() {
		$app		= JFactory::getApplication();
		$component	= JRequest::getVar('option', '','get','string');
		$model		= $this->getModel();
		
		$export_file = $model->export();
		$app->enqueueMessage($component.' data exported at <a href='.$export_file.'>'.$export_file.'</a>');
		$app->redirect(JRoute::_('index.php?option=com_adh'), false);
	}

	/*
	 * @brief	import()		import all data
	 * @since	0.0.2
	 */
	public function import() {
		$app		= JFactory::getApplication();
		$component	= JRequest::getVar('option', '','get','string');
		$model		= $this->getModel();
		
		$export_file = $model->import();
		$app->enqueueMessage($component.' data exported at <a href='.$export_file.'>'.$export_file.'</a>');
		$app->redirect(JRoute::_('index.php?option=com_adh'), false);
	}

}

?>
