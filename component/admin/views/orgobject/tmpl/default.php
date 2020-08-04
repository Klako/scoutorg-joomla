<?php

use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted access');

/** @var Form */
$form = $this->form;
$action = Route::_('index.php?option=com_scoutorg');
?>
<form action="<?= $action ?>" method="post" name="adminForm" id="adminForm" class="form">
    <div class="form-horizontal">
        <?= JHtmlBootstrap::startTabSet('scoutorgtabs', ['active' => array_values($form->getFieldsets())[0]->name]) ?>
        <?php foreach ($form->getFieldsets() as $name => $fieldset) : ?>
            <?= JHtmlBootstrap::addTab('scoutorgtabs', $name, Text::_($fieldset->label)) ?>
            <div class="row-fluid">
                <div class="span6">
                    <?php /** @var FormField $field */
                    foreach ($form->getFieldset($name) as $field) :  ?>
                        <?= $field->renderField() ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?= JHtmlBootstrap::endTab() ?>
        <?php endforeach; ?>
        <?= JHtmlBootstrap::endTabSet() ?>
    </div>
    <input type="hidden" name="task" value="<?= $this->type ?>.edit" />
    <?php echo HTMLHelper::_('form.token'); ?>
</form>