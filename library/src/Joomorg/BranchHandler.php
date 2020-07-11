<?php

namespace Scouterna\Scoutorg\Joomorg;

use Scouterna\Scoutorg\Builder\Bases\BranchBase;

class BranchHandler extends Handler
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getBase($id)
    {
        $query = $this->db->getQuery(true);

        $query->select(['id', 'name'])
            ->from('#__scoutorg_branches')
            ->where("{$query->qn('id')} = {$query->q($id)}");

        $this->db->setQuery($query);

        if (($row = $this->db->loadAssoc()) == null){
            return null;
        }

        return new BranchBase($row['name']);
    }

    public function getLink($uid, $name)
    {
        return null;
    }

    public function getLinks($uid, $name)
    {
        return [];
    }
}