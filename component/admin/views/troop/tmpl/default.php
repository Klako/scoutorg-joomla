<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Scouterna\Scoutorg\Model\Troop;

/** @var Troop */
$troop = $this->troop;

$serializedUid = $troop ? $troop->uid->serialize() : 'joomla:0';

?>
<form action="<?= Route::_('index.php?option=com_scoutorg&layout=default&uid=' . $serializedUid) ?>"
    method="post" name="adminForm" id="adminForm" class="form">
	<div class="form-horizontal">
		<?php foreach ($this->form->getFieldsets() as $name => $fieldset): ?>
			<fieldset class="adminform">
				<legend><?php echo Text::_($fieldset->label); ?></legend>
				<div class="row-fluid">
					<div class="span6">
						<?php /** @var FormField $field */
						foreach ($this->form->getFieldset($name) as $field): ?>
							<?= $field->renderField() ?>
						<?php endforeach; ?>
					</div>
				</div>
			</fieldset>
		<?php endforeach; ?>
	</div>
	<input type="hidden" name="task" value="troop.edit" />
	<?php echo HTMLHelper::_('form.token'); ?>
</form>
