<?php

namespace Scouterna\Scoutorg\Joomorg;

use Scouterna\Scoutorg\Builder\Bases\PatrolBase;

class PatrolHandler extends Handler
{

    public function getBase($id)
    {
        $query = $this->db->getQuery(true);

        $query->select(['name'])
            ->from('#__scoutorg_patrols')
            ->where("{$query->qn('id')} = {$query->quote($id)}");

        $this->db->setQuery($query);

        if (($row = $this->db->loadAssoc()) == null) {
            return null;
        }

        return new PatrolBase($row['name']);
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
