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
<div id="j-sidebar-container" class="span2">
    <?= $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10 j-toggle-main">
    <?php if (empty($this->tree)) : ?>
        <div class="alert alert-no-items">
            <?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
        </div>
    <?php else : ?>
        <table id="scoutorg-table" class="table">
            <thead>
                <tr>
                    <th><?= Text::_('Name') ?></th>
                    <th><?= Text::_('Type') ?></th>
                    <th><?= Text::_('Uid') ?></th>
                    <th><?= Text::_('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                /** @var ScoutOrgViewOrgtable $this */
                echo $this->printTreeNodes($this->tree, '') ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<script>
    jQuery('#scoutorg-table').treetable({
        expandable: false
    });
</script>