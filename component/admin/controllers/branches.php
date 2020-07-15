<?php

use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;

class ScoutOrgControllerBranches extends BaseController
{
	public function getModel($name = 'Branches', $prefix = 'ScoutOrgModel', $config = array())
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function delete()
	{
		// Check for request forgeries
		$this->checkToken();

		// Get items to remove from the request.
		$cid = $this->input->get('cid', array(), 'array');

		if (!is_array($cid) || count($cid) < 1) {
			Log::add(Text::_('COM_SCOUTORG_NO_ITEM_SELECTED'), Log::WARNING, 'jerror');
		} else {
			// Get the model.
			$model = $this->getModel();

			// Remove the items.
			if ($model->delete($cid)) {
				$this->setMessage(Text::plural('COM_SCOUTORG_N_ITEMS_DELETED', count($cid)));
			} else {
				$this->setMessage($model->getError(), 'error');
			}
		}

		$this->setRedirect(Route::_('index.php?option=com_scoutorg&view=branches'));
	}
}
