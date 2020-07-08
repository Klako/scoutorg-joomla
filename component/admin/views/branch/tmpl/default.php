<?php

use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');

/** @var Form */
$form = $this->form;
?>
<form action="<?php echo Route::_('index.php?option=com_scoutorg&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm" class="form">
	<div class="form-horizontal">
		<?php foreach ($form->getFieldsets() as $name => $fieldset): ?>
			<fieldset class="adminform">
				<legend><?php echo Text::_($fieldset->label); ?></legend>
				<div class="row-fluid">
					<div class="span6">
						<?php /** @var FormField $field */
						foreach ($form->getFieldset($name) as $field):  ?>
							<?= $field->renderField() ?>
						<?php endforeach; ?>
					</div>
				</div>
			</fieldset>
		<?php endforeach; ?>
	</div>
	<input type="hidden" name="task" value="branch.edit" />
	<?php echo HTMLHelper::_('form.token'); ?>
</form>
