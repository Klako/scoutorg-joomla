<?php

include_once 'orgobject.php';

class ScoutOrgControllerTroop extends OrgObjectController
{
    protected function getListViewName()
    {
        return 'troops';
    }
}
