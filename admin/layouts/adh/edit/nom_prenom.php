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

<div class="form-inline form-inline-header">
	<?php
	echo $form->renderField('titre');
	echo $form->renderField('nom');
	echo $form->renderField('prenom');
	echo $form->renderField('personne_morale');
	?>
</div>
