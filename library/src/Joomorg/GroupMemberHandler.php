<?php

namespace Scouterna\Scoutorg\Joomorg;

use Scouterna\Scoutorg\Builder\Bases\BranchBase;
use Scouterna\Scoutorg\Builder\Link;
use Scouterna\Scoutorg\Model\Uid;

class GroupMemberHandler extends Handler
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
        if ($name == 'roles') {
            return $this->getRoleLinks($uid);
        } else {
            return [];
        }
    }

    public function getRoleLinks($uid)
    {
        $query = $this->db->getQuery(true);

        $query->select(['role'])
            ->from('#__scoutorg_groupmemberroles')
            ->where("{$query->qn('groupmember')} = {$query->quote($uid->serialize())}");

        $this->db->setQuery($query);

        $roles = [];

        foreach ($this->db->loadAssocList() as $groupmemberrole) {
            $roles[] = new Link(Uid::deserialize($groupmemberrole['role']));
        }

        return $roles;
    }
}
