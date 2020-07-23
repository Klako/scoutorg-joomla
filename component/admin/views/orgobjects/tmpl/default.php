<?php

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Scouterna\Scoutorg\Model;
use Scouterna\Scoutorg\Model\Uid;

defined('_JEXEC') or die('Restricted Access');

HTMLHelper::_('formbehavior.chosen', 'select');

/** @var ScoutOrgViewOrgobjects $this */
?>
<form action="index.php?option=com_scoutorg" method="post" id="adminForm" name="adminForm">
    <div id="j-sidebar-container" class="span2">
        <?= $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10 j-toggle-main">
        <?php if (empty($this->table['rows'])) : ?>
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
                        <?php foreach ($this->table['columns'] as $column) : ?>
                            <th>
                                <?= Text::_($column) ?>
                            </th>
                        <?php endforeach; ?>
                        <th width="10%">
                            Source
                        </th>
                        <th width="2%">
                            <?= Text::_('COM_SCOUTORG_BRANCH_ID_LABEL') ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($this->table['rows'] as $uid => $row) :
                        $uid = Uid::deserialize($uid); ?>
                        <tr>
                            <td><?= $i ?></td>
                            <?php if ($uid->getSource() == 'joomla') : ?>
                                <td>
                                    <?= HTMLHelper::_('grid.id', $i, $uid->serialize()); ?>
                                </td>
                            <?php else : ?>
                                <td></td>
                            <?php endif; ?>
                            <?php foreach ($row as $rowColumn) : ?>
                                <td>
                                    <?= $rowColumn ?>
                                </td>
                            <?php endforeach; ?>
                            <td>
                                <?= $uid->getSource() ?>
                            </td>
                            <td align="center">
                                <?= $uid->getId() ?>
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