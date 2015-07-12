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
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
//JHtml::_('behavior.tooltip');
?>

		<?php
		/*
		 *	upload form taken from com_media/views/media/tmpl/default.php
		 */
		?>
		<?php //if ($user->authorise('core.create', 'com_adh')):?>
		<!-- File Upload Form -->
		<div id="collapseUpload" class="collapse">
			<form action="<?php echo JUri::base(); ?>index.php?option=com_adh&amp;task=upload&amp;tmpl=component&amp;<?php echo $this->session->getName() . '=' . $this->session->getId(); ?>&amp;<?php echo JSession::getFormToken();?>=1&amp;format=html" id="uploadForm" class="form-inline" name="uploadForm" method="post" enctype="multipart/form-data">
				<div id="uploadform">
					<fieldset id="upload-noflash" class="actions">
							<label for="upload-file" class="control-label"><?php echo JText::_('COM_MEDIA_UPLOAD_FILE'); ?></label>
								<input type="file" id="upload-file" name="Filedata[]" multiple /> <button class="btn btn-primary" id="upload-submit"><i class="icon-upload icon-white"></i> <?php echo JText::_('COM_MEDIA_START_UPLOAD'); ?></button>
								<p class="help-block"><?php echo $this->config->get('upload_maxsize') == '0' ? JText::_('COM_MEDIA_UPLOAD_FILES_NOLIMIT') : JText::sprintf('COM_MEDIA_UPLOAD_FILES', $this->config->get('upload_maxsize')); ?></p>
					</fieldset>
					<?php JFactory::getSession()->set('com_adh.return_url', 'index.php?option=com_adh'); ?>
				</div>
			</form>
		</div>
		<?php //endif;?>


<?php echo $this->loadTemplate('dashboard');?>
<?php echo $this->loadTemplate('chart');?>
<?php //echo $this->loadTemplate('map');?>

<p align="center"><?php echo $this->component->name; ?> - <?php echo $this->manifest->version; ?></p>
<?php if (JDEBUG) : ?>
	<pre><?php //var_dump($this); ?></pre>
<?php endif; ?>
