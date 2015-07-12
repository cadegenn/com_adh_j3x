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
JHtml::_('behavior.tooltip');

// Import library dependencies
JLoader::register('ADHControls', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/controls.php');

$user           = JFactory::getUser();
$userId         = $user->get('id');
$listOrder      = $this->escape($this->state->get('list.ordering'));
$listDirn       = $this->escape($this->state->get('list.direction'));
//$saveOrder      = $listOrder == 'a.ordering';
?>

<form action="<?php echo JRoute::_('index.php?option=com_adh&view=adherents'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		<?php
		// Search tools bar
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
		?>
		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
			</div>
		<?php else : ?>
		<table class="table table-striped table-hover" id="adherentList">
		<thead><tr>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
			</th>			
			<th>
				<?php echo JHtml::_('grid.sort', 'COM_ADH_NOMPRENOM_LABEL', 'LOWER(a.nom)', $listDirn, $listOrder); ?>
			</th>
			<th>
				<?php echo JHtml::_('grid.sort', 'COM_ADH_EMAIL_LABEL', 'a.email', $listDirn, $listOrder); ?>
			</th>
			<th>
				<?php echo JHtml::_('grid.sort', 'COM_ADH_CP_LABEL', 'cp', $listDirn, $listOrder); ?>
			</th>
			<th>
				<?php echo JHtml::_('grid.sort', 'COM_ADH_VILLE_LABEL', 'LOWER(ville)', $listDirn, $listOrder); ?>
			</th>
			<th>
				<?php echo JHtml::_('grid.sort', 'COM_ADH_PAYS_LABEL', 'LOWER(pays)', $listDirn, $listOrder); ?>
			</th>
			<th>
				<?php echo JHtml::_('grid.sort', 'COM_ADH_STATUS_LABEL', 'a.published', $listDirn, $listOrder); ?>
			</th>
			<!--<th>
				<?php //echo JHtml::_('grid.sort', 'COM_ADH_PAYEE_LABEL', 'a.payee', $listDirn, $listOrder); ?>
			</th>-->
			<th>
				<?php echo JHtml::_('grid.sort', 'COM_ADH_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
			</th>
		</tr></thead>
		<tfoot><?php //echo $this->loadTemplate('foot');?></tfoot>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>
		<?php endif; ?>

		<?php echo $this->pagination->getListFooter(); ?>
		<?php // Load the batch processing form. ?>
		<?php //echo $this->loadTemplate('batch'); ?>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<pre style="clear:both;">
    <?php //echo var_dump($_POST); ?>
    <?php //echo var_dump($_GET); ?>
    <?php //echo var_dump($this); ?>
</pre>