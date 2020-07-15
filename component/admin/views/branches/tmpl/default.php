<?php

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Scouterna\Scoutorg\Builder\Uid;
use Scouterna\Scoutorg\Lib;

defined('_JEXEC') or die('Restricted Access');

HTMLHelper::_('formbehavior.chosen', 'select');

?>
<form action="index.php?option=com_scoutorg&view=branches" method="post" id="adminForm" name="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?= $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10 j-toggle-main">
		<?php if (empty($this->branches)) : ?>
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
					/** @var Lib\Branch $branch */
					foreach ($this->branches as $branch) : ?>
						<tr>
							<td><?= $i ?></td>
							<?php if ($branch->source == 'joomla') : ?>
								<td>
									<?= HTMLHelper::_('grid.id', $i, (new Uid($branch->source, $branch->id))->serialize()); ?>
								</td>
								<td>
									<a href="<?= Route::_('index.php?option=com_scoutorg&task=branch.edit&id=' . $branch->id) ?>" title="<?= Text::_('COM_SCOUTORG_EDIT_BRANCH'); ?>">
										<?= $branch->name; ?>
									</a>
								</td>
							<?php else : ?>
								<td></td>
								<td>
									<?= $branch->name ?>
								</td>
							<?php endif; ?>
							<td>
								<?= $branch->source ?>
							</td>
							<td align="center">
								<?= $branch->id; ?>
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