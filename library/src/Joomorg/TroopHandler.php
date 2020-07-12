<?php

namespace Scouterna\Scoutorg\Joomorg;

use Scouterna\Scoutorg\Builder\Bases\TroopBase;
use Scouterna\Scoutorg\Builder\Uid;

class TroopHandler extends Handler
{

    public function getBase($id)
    {
        $query = $this->db->getQuery(true);

        $query->select(['id', 'name'])
            ->from('#__scoutorg_troops')
            ->where("{$query->qn('id')} = {$query->quote($id)}");

        $this->db->setQuery($query);

        if (($row = $this->db->loadAssoc()) == null){
            return null;
        }

        return new TroopBase($row['name']);
    }

    public function getLink($uid, $name)
    {
        if ($uid->getSource() != 'joomla'){
            return null;
        }

        $query = $this->db->getQuery(true);

        $query->select(['id', 'branch'])
            ->from('#__scoutorg_troops')
            ->where("{$query->qn('id')} = {$query->quote($uid->getId())}");

        $this->db->setQuery($query);

        if (($row = $this->db->loadAssoc()) == null){
            return null;
        }

        return new Uid('joomla', $row['branch']);
    }

    public function getLinks($uid, $name)
    {
    }
}
