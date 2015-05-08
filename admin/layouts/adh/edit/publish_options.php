<?php

/** 
 *  @component	com_adh
 * 
 *  @copyright	Copyright (C) 2012-2015 DEGENNES Charles-Antoine <cadegenn@gmail.com>
 *  @license	Affero GNU General Public License Version 3; see LICENSE.txt
 * 
 */

defined('_JEXEC') or die;

$app       = JFactory::getApplication();
$form      = $displayData->getForm();
$input     = $app->input;
$component = $input->getCmd('option', 'com_adh');

if ($component == 'com_categories')
{
	$extension = $input->getCmd('extension', 'com_adh');
	$parts     = explode('.', $extension);
	$component = $parts[0];
}

$saveHistory = JComponentHelper::getParams($component)->get('save_history', 0);

$fields = $displayData->get('fields') ?: array(
	array('parent', 'parent_id'),
	array('published', 'state', 'enabled'),
	array('category', 'catid'),
	'created_by', 'creation_date',
	'modified_by', 'modification_date',
	'tags',
	'note',
	'version_note',
);
//$fields = $form->getFieldset('publish_options');

$hiddenFields = $displayData->get('hidden_fields') ?: array();

if (!$saveHistory)
{
	$hiddenFields[] = 'version_note';
}

$html   = array();
$html[] = '<fieldset class="form-vertical">';

foreach ($fields as $field)
{
	$field = is_array($field) ? $field : array($field);

	foreach ($field as $f)
	{
		if ($form->getField($f))
		{
			if (in_array($f, $hiddenFields))
			{
				$form->setFieldAttribute($f, 'type', 'hidden');
			}

			$html[] = $form->renderField($f);
			break;
		}
	}
}

$html[] = '</fieldset>';

echo implode('', $html);
