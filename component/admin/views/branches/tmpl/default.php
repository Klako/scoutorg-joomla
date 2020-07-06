<?php

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted Access');

HTMLHelper::_('formbehavior.chosen', 'select');

?>
<form action="index.php?option=com_scoutorg&view=branches" method="post" id="adminForm" name="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?= $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10 j-toggle-main">
		<?php if (empty($this->items)) : ?>
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
						<th width="90%">
							<?= Text::_('COM_SCOUTORG_BRANCH_NAME_LABEL') ?>
						</th>
						<th width="2%">
							<?= Text::_('COM_SCOUTORG_BRANCH_ID_LABEL') ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="5">
							<?= $this->pagination->getListFooter() ?>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($this->items as $i => $row) : ?>
						<tr>
							<td><?= $this->pagination->getRowOffset($i); ?></td>
							<td>
								<?= HTMLHelper::_('grid.id', $i, $row->id); ?>
							</td>
							<td>
								<a href="<?= Route::_('index.php?option=com_scoutorg&task=branch.edit&id=' . $row->id) ?>" title="<?= Text::_('COM_SCOUTORG_EDIT_BRANCH'); ?>">
									<?= $row->name; ?>
								</a>
							</td>
							<td align="center">
								<?= $row->id; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?= HTMLHelper::_('form.token'); ?>
	</div>
</form>