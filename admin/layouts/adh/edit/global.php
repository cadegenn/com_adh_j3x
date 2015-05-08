<?php

/** 
 *  @component	com_adh
 * 
 *  @copyright	Copyright (C) 2012-2015 DEGENNES Charles-Antoine <cadegenn@gmail.com>
 *  @license	Affero GNU General Public License Version 3; see LICENSE.txt
 * 
 */

defined('JPATH_BASE') or die;

$form = $displayData->getForm();

?>

<fieldset class="adminform">
	<div class="span6">
		<?php
		echo $form->renderField('date_naissance');
		echo $form->renderField('email');
		echo $form->renderField('telephone');
		?>
	</div>
	<div class="span6">
		<?php
		echo $form->renderField('profession_id');
		echo $form->renderField('password');
		echo $form->renderField('gsm');
		?>
	</div>
</fieldset>

<div class="clearfix"></div>

<fieldset class="adminform">
	<div class="span11">
		<?php
		echo $form->renderField('adresse');
		?>
	</div>
</fieldset>

<fieldset class="adminform">
	<div class="span6">
		<?php
		echo $form->renderField('adresse2');
		echo $form->renderField('ville');
		?>
	</div>
	<div class="span6">
		<?php
		echo $form->renderField('cp');
		echo $form->renderField('pays');
		?>
	</div>
</fieldset>

<fieldset class="adminform">
	<div class="span11">
		<?php
		echo $form->renderField('description');
		?>
	</div>
</fieldset>
