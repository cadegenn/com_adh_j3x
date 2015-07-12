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
		
		// load com_media language file @url https://docs.joomla.org/Loading_extra_language_files
		$lang = JFactory::getLanguage();
		$extension = 'com_media';
		$base_dir = JPATH_SITE;
		$language_tag = $lang->getTag();
		$reload = true;
		$lang->load($extension, $base_dir, $language_tag, $reload);

		$export_file = $model->export();
		$app->enqueueMessage($component.' '.JTEXT::_('COM_ADH_EXPORT_DATA').' <a href='.$export_file.'>'.$export_file.'</a>');
		$app->redirect(JRoute::_('index.php?option=com_adh'), false);
	}

	/**
	 * Upload one or more files
	 *
	 * @return  boolean
	 *
	 * @since   0.0.2
	 */
	public function upload()
	{
		// Check for request forgeries
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));
		$app    = JFactory::getApplication();
		$params = JComponentHelper::getParams('com_adh');
		$component	= JRequest::getVar('option', '','get','string');
		$model		= $this->getModel();

		// load com_media language file @url https://docs.joomla.org/Loading_extra_language_files
		$lang = JFactory::getLanguage();
		$extension = 'com_media';
		$base_dir = JPATH_SITE;
		$language_tag = $lang->getTag();
		$reload = true;
		$lang->load($extension, $base_dir, $language_tag, $reload);

		// Get some data from the request
		$files        = $this->input->files->get('Filedata', '', 'array');

		// Set the redirect
		/*if ($return)
		{
			$this->setRedirect($return . '&folder=' . $this->folder);
		}
		else
		{
			$this->setRedirect('index.php?option=com_adh&folder=' . $this->folder);
		}*/

		// Authorize the user
		/*if (!$this->authoriseUser('create'))
		{
			return false;
		}*/

		// Total length of post back data in bytes.
		$contentLength = (int) $_SERVER['CONTENT_LENGTH'];

		// Instantiate the media helper
		$mediaHelper = new JHelperMedia;

		// Maximum allowed size of post back data in MB.
		$postMaxSize = $mediaHelper->toBytes(ini_get('post_max_size'));

		// Maximum allowed size of script execution in MB.
		$memoryLimit = $mediaHelper->toBytes(ini_get('memory_limit'));

		// Check for the total size of post back data.
		if (($postMaxSize > 0 && $contentLength > $postMaxSize)
			|| ($memoryLimit != -1 && $contentLength > $memoryLimit))
		{
			JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_WARNUPLOADTOOLARGE'));

			return false;
		}

		$uploadMaxSize = $params->get('upload_maxsize', 0) * 1024 * 1024;
		$uploadMaxFileSize = $mediaHelper->toBytes(ini_get('upload_max_filesize'));

		// Perform basic checks on file info before attempting anything
		foreach ($files as &$file)
		{
			$file['name']     = JFile::makeSafe($file['name']);
			$file['filepath'] = JPath::clean(implode(DIRECTORY_SEPARATOR, array(JPATH_ADMINISTRATOR . '/backups', $file['name'])));

			if (($file['error'] == 1)
				|| ($uploadMaxSize > 0 && $file['size'] > $uploadMaxSize)
				|| ($uploadMaxFileSize > 0 && $file['size'] > $uploadMaxFileSize))
			{
				// File size exceed either 'upload_max_filesize' or 'upload_maxsize'.
				JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_WARNFILETOOLARGE'));

				return false;
			}

			if (JFile::exists($file['filepath']))
			{
				// A file with this name already exists
				//JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_FILE_EXISTS'));
				//return false;
				
				JFile::delete($file['filepath']);
			}

			if (!isset($file['name']))
			{
				// No filename (after the name was cleaned by JFile::makeSafe)
				$this->setRedirect('index.php', JText::_('COM_MEDIA_INVALID_REQUEST'), 'error');

				return false;
			}
		}

		// Set FTP credentials, if given
		JClientHelper::setCredentialsFromRequest('ftp');
		JPluginHelper::importPlugin('content');
		$dispatcher	= JEventDispatcher::getInstance();

		foreach ($files as &$file)
		{
			// The request is valid
			$err = null;

			/*if (!$mediaHelper->canUpload($file, $component))
			{
				// The file can't be uploaded

				return false;
			}*/

			// Trigger the onContentBeforeSave event.
			$object_file = new JObject($file);
			$result = $dispatcher->trigger('onContentBeforeSave', array('com_adh.file', &$object_file, true));

			if (in_array(false, $result, true))
			{
				// There are some errors in the plugins
				JError::raiseWarning(100, JText::plural('COM_MEDIA_ERROR_BEFORE_SAVE', count($errors = $object_file->getErrors()), implode('<br />', $errors)));

				return false;
			}

			if (!JFile::upload($object_file->tmp_name, $object_file->filepath))
			{
				// Error in upload
				JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_UNABLE_TO_UPLOAD_FILE'));

				return false;
			}
			else
			{
				// Trigger the onContentAfterSave event.
				$dispatcher->trigger('onContentAfterSave', array('com_adh.file', &$object_file, true));
				$app->enqueueMessage(JText::sprintf('COM_MEDIA_UPLOAD_COMPLETE', $object_file->filepath));
			}
			
			/**
			 * finally call import from model
			 */
			if ($model->import($object_file->filepath)) {
				$app->enqueueMessage(JText::sprintf('COM_MEDIA_UPLOAD_COMPLETE', $object_file->filepath));
			} else {
				$app->enqueueMessage(JText::sprintf('COM_ADH_ERROR_UNABLE_TO_IMPORT_DATA', $object_file->filepath), "error");
			}
			
			$this->setRedirect('index.php?option='.$component);
		}

		return true;
	}

}

?>
