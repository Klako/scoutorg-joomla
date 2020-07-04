<?php

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die('Restricted Access');

HTMLHelper::_('formbehavior.chosen', 'select');

?>
<form action="index.php?option=com_scoutorg&view=troops" method="post" id="adminForm" name="adminForm">
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
					<th width="45%">
						<?= Text::_('COM_SCOUTORG_TROOP_TROOP_LABEL') ?>
					</th>
        	        <th width="45%">
        	            <?= Text::_('COM_SCOUTORG_TROOP_BRANCH_LABEL') ?>
        	        </th>
					<th width="2%">
						<?= Text::_('COM_SCOUTORG_TROOP_ID_LABEL') ?>
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
					<?php foreach ($this->items as $i => $row) :
        	            $link = Route::_('index.php?option=com_scoutorg&task=troop.edit&id=' . $row->id);
        	            jimport('scoutorg.loader');
        	            $troops = ScoutOrgLoader::load()->getScoutGroup()->getTroops(true);
						$troop = $troops[intval($row->troop)];
					?>
						<tr>
							<td>
								<?= $this->pagination->getRowOffset($i); ?>
							</td>
							<td>
								<?= HTMLHelper::_('grid.id', $i, $row->id); ?>
							</td>
							<?php if ($troop) : ?>
								<td>
									<a href="<?= $link ?>" title="<?= Text::_('COM_SCOUTORG_EDIT_TROOP') ?>">
										<?= $troop->getName() ?>
									</a>
								</td>
        	                	<td>
        	                	    <?= $troop->getBranch()->getName() ?>
        	                	</td>
							<?php else : ?>
								<td>
									<a href="<?= $link ?>" title ="<?= Text::_('COM_SCOUTORG_ERROR_TROOP_NOT_FOUND') ?>">
										<?= $row->troop.': '.Text::_('COM_SCOUTORG_ERROR_TROOP_NOT_FOUND') ?>
									</a>
								</td>
								<td>
        	                	    <?= $row->branch ?>
        	                	</td>
							<?php endif; ?>
							<td align="center">
									<?= $row->id; ?>
								</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="boxchecked" value="0"/>
		<?= HTMLHelper::_('form.token'); ?>
	</div>
</form>

