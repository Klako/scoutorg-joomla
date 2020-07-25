<?php

namespace Scouterna\Scoutorg\Joomorg;

use Scouterna\Scoutorg\Builder\Link;
use Scouterna\Scoutorg\Model\Uid;

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
        } elseif ($name == 'troops') {
            return $this->getTroopLinks();
        } elseif ($name == 'grouproles') {
            return $this->getGroupRoleLinks();
        }
        return [];
    }

    private function getBranchLinks()
    {
        $query = $this->db->getQuery(true);
        $query->select(['id'])->from('#__scoutorg_branches');

        $this->db->setQuery($query);

        $links = [];
        foreach ($this->db->loadAssocList() as $row) {
            $links[] = new Link(new Uid('joomla', $row['id']));
        }
        return $links;
    }

    private function getTroopLinks()
    {
        $query = $this->db->getQuery(true);
        $query->select(['id'])->from('#__scoutorg_troops');

        $this->db->setQuery($query);

        $links = [];
        foreach ($this->db->loadAssocList() as $row) {
            $links[] = new Link(new Uid('joomla', $row['id']));
        }
        return $links;
    }

    private function getGroupRoleLinks()
    {
        $query = $this->db->getQuery(true);
        $query->select(['id'])->from('#__scoutorg_grouproles');

        $this->db->setQuery($query);

        $links = [];
        foreach ($this->db->loadAssocList() as $row) {
            $links[] = new Link(new Uid('joomla', $row['id']));
        }
        return $links;
    }
}
