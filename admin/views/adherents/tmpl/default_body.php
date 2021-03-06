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
JLoader::register('AGrid', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/html/agrid.php');

$app		= JFactory::getApplication();
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$archived	= $this->state->get('filter.published') == 2 ? true : false;
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
//$saveOrder	= $listOrder == 'a.ordering';
?>

<?php foreach($this->items as $i => $item):
	$item->max_ordering = 0; //??
	//$ordering       = ($listOrder == 'a.ordering');
	//$canCreate      = $user->authorise('core.create',		'com_adh.category.'.$item->catid);
	$canEdit        = $user->authorise('core.edit',			'com_adh.adherent.'.$item->id);
	$canCheckin     = $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
	//$canEditOwn     = $user->authorise('core.edit.own',		'com_adh.adherent.'.$item->id) && $item->created_by == $userId;
	$canChange      = $user->authorise('core.edit.state',	'com_adh.adherent.'.$item->id) && $canCheckin;
	?>
	<tr class="row<?php echo $i % 2; ?>">
        <td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td class="center">
			<div class="btn-group">
				<?php echo JHtml::_('jgrid.published', $item->published, $i, 'adherents.', $canChange, 'cb', '', ''); ?>
				<?php //		+-> /libraries/cms/html/jgrid.php : published() ?>
				<?php //		+-> controllers/adherents.php : published() ?>
				<?php
				// Create dropdown items
				$action = $archived ? 'unarchive' : 'archive';
				JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'adherents');

				$action = $trashed ? 'untrash' : 'trash';
				JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'adherents');

				// Render dropdown list
				echo JHtml::_('actionsdropdown.render', $this->escape($item->nom));
				?>
			</div>
		</td>
		<td>
			<?php 
			$class = "";
			if ($item->personne_morale != "") {
				$class = "structure";
				$label = $item->personne_morale;
			} else {
				switch (strtolower($item->titre)) {
					case "m." :
					case "mr" : $class = "user-male";
								break;
					case "mme" :
					case "mlle":$class = "user-female";
								break;
					default :	$class = "user-male";
								break;
				}
				$label = $item->nom." ".$item->prenom;
			}?>
			<!--<a class="icon-<?php echo $class; ?>" href="<?php echo JRoute::_('index.php?option=com_adh&view=adherent&layout=edit&id=' . $item->id); ?>"><?php echo($label); ?></a>-->
			<a href="<?php echo JRoute::_('index.php?option=com_adh&view=adherent&layout=edit&id=' . $item->id); ?>"><?php echo($label); ?></a>
			<?php if ($item->personne_morale == "") : ?>
			<!--<small class="pull-right">(<?php echo $item->date_naissance; ?>)</small>-->
			<small>(<?php echo $item->date_naissance; ?>)</small>
			<?php endif; ?>
			<br />
			<a href='mailto:<?php echo $item->email; ?>'><?php echo $item->email; ?></a>
		</td>
		<!--<td>
			<a href='mailto:<?php //echo $item->email; ?>'><?php //echo $item->email; ?></a>
		</td>-->
		<td class="nowrap hidden-phone text-right">
			<?php echo $item->cp; ?>
		</td>
		<td class="nowrap hidden-phone">
			<?php echo $item->ville; ?>
		</td>
		<td class="nowrap hidden-phone">
			<?php echo $item->pays; ?>
		</td>
		<!--<td class="center">
			<?php //echo JHtml::_('jgrid.published', $item->payee, $i, 'adherents.', $canChange, 'cb', $item->date_debut_cotiz, $item->date_fin_cotiz); ?>
			<?php //		+-> /libraries/joomla/html/html/jgrid.php : published() ?>
			<?php //		+-> controllers/adherents.php : published() ?>
		</td>-->
		<td class="nowrap hidden-phone text-right">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
