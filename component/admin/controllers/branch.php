<?php

use Joomla\CMS\MVC\Controller\FormController;

require_once 'orgobject.php';

class ScoutOrgControllerBranch extends OrgObjectController
{
    protected function getListViewName()
    {
        return 'branches';
    }
}
