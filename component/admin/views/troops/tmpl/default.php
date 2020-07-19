<?php

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Scouterna\Scoutorg\Model;

defined('_JEXEC') or die('Restricted Access');

HTMLHelper::_('formbehavior.chosen', 'select');

/** @var Model\ScoutGroup */
$scoutgroup = $this->scoutgroup;

?>
<form action="index.php?option=com_scoutorg&view=troops" method="post" id="adminForm" name="adminForm">
	<div id="j-sidebar-container" class="span2">
		<?= $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10 j-toggle-main">
		<?php if (empty($scoutgroup->troops)) : ?>
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
						<th width="30%">
							<?= Text::_('COM_SCOUTORG_TROOP_TROOP_LABEL') ?>
						</th>
						<th width="30%">
							<?= Text::_('COM_SCOUTORG_TROOP_BRANCH_LABEL') ?>
						</th>
						<th width="30%">
							Source
						</th>
						<th width="2%">
							<?= Text::_('COM_SCOUTORG_TROOP_ID_LABEL') ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0;
					foreach ($scoutgroup->troops as $troop) :
						$serializedUid = $this->escape($troop->uid->serialize());
					?>
						<tr>
							<td>
								<?= $i ?>
							</td>
							<?php if ($troop->uid->getSource() == 'joomla') : ?>
								<td>
									<?= HTMLHelper::_('grid.id', $i, $serializedUid); ?>
								</td>
								<td>
									<a href="<?= Route::_('index.php?option=com_scoutorg&task=troop.edit&uid=' . $serializedUid); ?>" title="<?= Text::_('COM_SCOUTORG_EDIT_TROOP') ?>">
										<?= $troop->name ?>
									</a>
								</td>
							<?php else : ?>
								<td></td>
								<td>
									<?= $troop->name ?>
								</td>
							<?php endif; ?>
							<td>
								<?= $troop->branch->name ?? 'None' ?>
							</td>
							<td>
								<?= $troop->uid->getSource() ?>
							</td>
							<td align="center">
								<?= $troop->uid->getId() ?>
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