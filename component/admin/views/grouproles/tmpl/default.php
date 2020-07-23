<?php

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Scouterna\Scoutorg\Model;

defined('_JEXEC') or die('Restricted Access');

HTMLHelper::_('formbehavior.chosen', 'select');

?>
<form action="index.php?option=com_scoutorg&view=branches" method="post" id="adminForm" name="adminForm">
    <div id="j-sidebar-container" class="span2">
        <?= $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10 j-toggle-main">
        <?php if (empty($this->grouproles)) : ?>
            <div class="alert alert-no-items">
                <?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
            </div>
        <?php else : ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="1%"><?= Text::_('COM_SCOUTORG_NUM') ?></th>
                        <th width="2%">
                            <?= HTMLHelper::_('grid.checkall'); ?>
                        </th>
                        <th width="50%">
                            <?= Text::_('COM_SCOUTORG_BRANCH_NAME_LABEL') ?>
                        </th>
                        <th width="40%">
                            Source
                        </th>
                        <th width="2%">
                            <?= Text::_('COM_SCOUTORG_BRANCH_ID_LABEL') ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    /** @var Model\GroupRole $grouprole */
                    foreach ($this->grouproles as $grouprole) : ?>
                        <tr>
                            <td><?= $i ?></td>
                            <?php if ($grouprole->uid->getSource() == 'joomla') : ?>
                                <td>
                                    <?= HTMLHelper::_('grid.id', $i, $grouprole->uid->serialize()); ?>
                                </td>
                            <?php else : ?>
                                <td></td>
                            <?php endif; ?>
                            <td>
                                <a href="<?= Route::_('index.php?option=com_scoutorg&task=grouprole.edit&uid=' . $grouprole->uid->serialize()) ?>" title="<?= Text::_('Edit Group Role'); ?>">
                                    <?= $grouprole->name; ?>
                                </a>
                            </td>
                            <td>
                                <?= $grouprole->uid->getSource() ?>
                            </td>
                            <td align="center">
                                <?= $grouprole->uid->getId() ?>
                            </td>
                        </tr>
                    <?php $i++;
                    endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <?= HTMLHelper::_('form.token'); ?>
    </div>
</form>