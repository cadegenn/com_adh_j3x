<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');

// Import library dependencies
JLoader::register('ADHFunctions', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/functions.php');
JLoader::register('ADHControls', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/controls.php');
JLoader::register('ADHdb', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/db.php');

?>

<form action="<?php echo JRoute::_('index.php?option=com_adh&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm" id="profession-form">
	<div class='width-60 fltlft'>
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_ADH_PROFESSION_DETAILS' ); ?> <small>(<?php echo $this->item->id; ?>)</small></legend>
			<div class="tr">
				<div class="tth"><?php echo $this->form->getField("categorie")->label; ?></div>
				<div class="ttd"><?php echo html_entity_decode($this->form->getField("categorie")->input); ?></div>
			</div>
			<div class="tr">
				<div class="tth"><?php echo $this->form->getField("label")->label; ?></div>
				<div class="ttd"><?php echo html_entity_decode($this->form->getField("label")->input); ?></div>
			</div>
		</fieldset>
	</div>
	<div class='width-40 pull-right'>
		<?php echo JHtml::_('sliders.start', 'content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
			<?php echo JHtml::_('sliders.panel', JText::_('COM_ADH_FIELDSET_PUBLISHING'), 'meta-options'); ?>
				<fieldset class="panelform">
					<ul class="adminformlist">
						<li><?php echo $this->form->getLabel('creation_date'); ?>
						<?php echo $this->form->getInput('creation_date'); ?></li>
						
						<li><?php echo $this->form->getLabel('published'); ?>
						<?php echo $this->form->getInput('published'); ?></li>
						
						<li><?php echo $this->form->getLabel('modified_by'); ?>
						<?php echo $this->form->getInput('modified_by'); ?></li>
						
						<li><?php echo $this->form->getLabel('modification_date'); ?>
						<?php echo $this->form->getInput('modification_date'); ?></li>
					</ul>
				</fieldset>
		<?php echo JHtml::_('sliders.end'); ?>
	</div>
	<div>
		<input type="hidden" name="task" value="profession.edit" />
                <?php JFactory::getApplication()->setUserState('com_adh.edit.configprofession.id', (int) $this->item->id); ?>
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<!--<pre>
    <?php //echo var_dump($this); ?>
</pre>-->