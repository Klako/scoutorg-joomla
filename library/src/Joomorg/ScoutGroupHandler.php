<?php

namespace Scouterna\Scoutorg\Joomorg;

use Scouterna\Scoutorg\Builder\Uid;

class ScoutGroupHandler extends Handler
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getBase($id)
    {
        return null;
    }

    public function getLink($uid, $name)
    {
        return null;
    }

    public function getLinks($uid, $name)
    {
        if ($name == 'branches') {
            return $this->getBranchLinks();
        } else {
            return [];
        }
    }

    private function getBranchLinks()
    {
        $query = $this->db->getQuery(true);
        $query->select(['id'])->from('#__scoutorg_branches');

        $this->db->setQuery($query);

        $uids = [];
        foreach ($this->db->loadAssocList() as $row){
            $uids[] = new Uid('joomla', $row['id']);
        }

        return $uids;
    }
}
