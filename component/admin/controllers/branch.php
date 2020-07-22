<?php

require_once 'orgobject.php';

class ScoutOrgControllerBranch extends OrgObjectController
{
    protected function getListViewName()
    {
        return 'branches';
    }
}
