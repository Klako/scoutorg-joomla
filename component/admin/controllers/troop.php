<?php

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;

class ScoutOrgControllerTroop extends BaseController
{
    public function add()
    {
        $this->setRedirect(Route::_('index.php?option=com_scoutorg&view=troop'));
    }

    public function edit()
    {
        Factory::getApplication()->allowCache(false);

        $id = Factory::getApplication()->input->getString('id');

        $this->setRedirect(Route::_('index.php?option=com_scoutorg&view=troop&id=' . $id, false));
    }
}
