<?php

use Scouterna\Scoutorg\Model\Uid;

require_once 'orgobject.php';

class ScoutOrgModelCustomlist extends OrgObjectModel
{

    protected function fetchFormData() { }

    public function save(?Uid &$uid, $data) { }

    public function delete($uids) { }
    
}