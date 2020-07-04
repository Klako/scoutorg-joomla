<?php

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die;

HTMLHelper::_('formbehavior.chosen', 'select');

$saveOrderingUrl = 'index.php?option=com_scoutorg&task=userprofilefields.saveOrderAjax&tmpl=component';
HTMLHelper::_('sortablelist.sortable', 'fieldlist', 'adminForm', 'asc', $saveOrderingUrl);

?>
<form action="<?php echo Route::_('index.php?option=com_scoutorg&view=userprofilefields'); ?>" method="post" id="adminForm" name="adminForm">
    <div id="j-sidebar-container" class="span2">
    	<?= $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10 j-toggle-main">
		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
			</div>
		<?php else : ?>
			<table class="table table-striped" id="fieldlist">
				<thead>
					<tr>
						<th width="1%" class="nowrap center hidden-phone">
							-
						</th>
						<th width="1%">
							<?php echo HTMLHelper::_('grid.checkall'); ?>
						</th>
						<th width="1%">
							Status
						</th>
						<th width="20%">
							<?php echo Text::_('COM_SCOUTORG_ADMIN_USERPROFILEFIELD_TITLE_LABEL'); ?>
						</th>
						<th class="nowrap hidden-phone">
							<?php echo Text::_('COM_SCOUTORG_ADMIN_USERPROFILEFIELD_FIELDTYPE_LABEL'); ?>
						</th>
                        <th>
							<?php echo Text::_('JGRID_HEADING_ACCESS'); ?>
						</th>
						<th width="1%" class="nowrap hidden-phone">
                            <?= Text::_('JGRID_HEADING_ID') ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="5">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) : ?>
					<tr class="row<?= $i % 2 ?>">
						<td class="order nowrap center hidden-phone">
							<span class="sortable-handler">
								<span class="icon-menu" aria-hidden="true"></span>
							</span>
							<input type="text" style="display:none" name="order[]" size="5" value="<?= $item->ordering ?>" class="width-20 text-area-order" />
						</td>
						<td class="center">
							<?= HTMLHelper::_('grid.id', $i, $item->id) ?>
						</td>
						<td>
							<?= HTMLHelper::_('jgrid.published', $item->published, $i, 'userprofilefields.') ?>
						</td>
						<td>
							<a href="<?= Route::_('index.php?option=com_scoutorg&task=userprofilefield.edit&id=' . $item->id); ?>">
								<?= $this->escape($item->title) ?>
                            </a>
						</td>
						<td class="hidden-phone">
							<?= ScoutOrgHelper::evalFieldname($item->fieldtype) ?>
						</td>
						<td class="small hidden-phone">
							<?= $this->escape($item->access_level); ?>
						</td>
						<td class="hidden-phone">
							<?= (int) $item->id ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo HTMLHelper::_('form.token'); ?>
	</div>
</form>
