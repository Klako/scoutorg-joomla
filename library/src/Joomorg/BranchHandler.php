<?php

namespace Scouterna\Scoutorg\Joomorg;

use Scouterna\Scoutorg\Builder\Bases\BranchBase;
use Scouterna\Scoutorg\Builder\Link;
use Scouterna\Scoutorg\Model\Uid;

class BranchHandler extends Handler
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getBase($id)
    {
        $query = $this->db->getQuery(true);

        $query->select(['name'])
            ->from('#__scoutorg_branches')
            ->where("{$query->qn('id')} = {$query->q($id)}");

        $this->db->setQuery($query);

        if (($row = $this->db->loadAssoc()) == null) {
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
        if ($name == 'troops') {
            return $this->getTroopLinks($uid);
        } else {
            return [];
        }
    }

    public function getTroopLinks($uid)
    {
        $query = $this->db->getQuery(true);

        $query->select(['troop'])
            ->from('#__scoutorg_branchtroops')
            ->where("{$query->qn('branch')} = {$query->quote($uid->serialize())}");

        $this->db->setQuery($query);

        $troops = [];

        foreach ($this->db->loadAssocList() as $branchtroop) {
            $troops[] = new Link(Uid::deserialize($branchtroop['troop']));
        }

        return $troops;
    }
}
