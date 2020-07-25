<?php

namespace Scouterna\Scoutorg\Joomorg;

use RuntimeException;
use Scouterna\Scoutorg\Builder\Bases\TroopBase;
use Scouterna\Scoutorg\Builder\Link;
use Scouterna\Scoutorg\Model\Uid;

class TroopHandler extends Handler
{

    public function getBase($id)
    {
        $query = $this->db->getQuery(true);

        $query->select(['name'])
            ->from('#__scoutorg_troops')
            ->where("{$query->qn('id')} = {$query->quote($id)}");

        $this->db->setQuery($query);

        if (($row = $this->db->loadAssoc()) == null) {
            return null;
        }

        return new TroopBase($row['name']);
    }

    public function getLink($uid, $name)
    {
        if ($name == 'branch') {
            return $this->getBranchLink($uid);
        } else {
            return null;
        }
    }

    /**
     * @param Uid $uid 
     * @return null|Link 
     * @throws RuntimeException 
     */
    private function getBranchLink($uid)
    {
        $query = $this->db->getQuery(true);

        $query->select(['branch'])
            ->from('#__scoutorg_branchtroops')
            ->where("{$query->qn('troop')} = {$query->quote($uid->serialize())}");

        $this->db->setQuery($query);

        if (($row = $this->db->loadAssoc()) == null) {
            return null;
        }

        return new Link(Uid::deserialize($row['branch']));
    }

    public function getLinks($uid, $name)
    {
        if ($name == 'patrols') {
            return $this->getPatrolLinks($uid);
        }
        return [];
    }

    /**
     * @param Uid $uid 
     * @return Link[]
     * @throws RuntimeException 
     */
    private function getPatrolLinks($uid)
    {
        $query = $this->db->getQuery(true);

        $query->select('id')
            ->from('#__scoutorg_patrols')
            ->where($query->qn('troop') . '=' . $query->q($uid->serialize()));

        $this->db->setQuery($query);

        $patrols = [];
        foreach ($this->db->loadAssocList() as $patrol) {
            $patrols[] = new Link(new Uid('joomla', $patrol['id']));
        }
        return $patrols;
    }
}
