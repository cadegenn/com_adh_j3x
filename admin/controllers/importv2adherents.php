<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * ImportV2Adherents Controller
 */
class adhControllerImportV2Adherents extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = 'importV2adherents', $prefix = 'adhModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	
	/*
	 * import adherents
	 */
	public function import() {
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		// Get items to import from the request.
		$cid = JRequest::getVar('cid', array(), '', 'array');

		if (!is_array($cid) || count($cid) < 1)
		{
			JError::raiseWarning(500, JText::_($this->text_prefix . '_NO_ITEM_SELECTED'));
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			jimport('joomla.utilities.arrayhelper');
			JArrayHelper::toInteger($cid);

			// Import the items.
			if ($model->import($cid))	// --> adminitrator/components/com_adh/models/importv2adherents.php
			{
				$this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_IMPORTED', count($cid)));
			}
			else
			{
				$this->setMessage($model->getError());
			}
		}

		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));
	}
	public function importAll() {
		$model = $this->getModel();
		if ($model->import('all'))	// --> adminitrator/components/com_adh/models/importv2adherents.php
		{
			$this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_IMPORTED', 'All'));
		}
		else
		{
			$this->setMessage($model->getError());
		}
	}
	
}
?>
