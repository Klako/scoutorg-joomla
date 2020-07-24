<?php

namespace Scouterna\Scoutorg\Joomorg;

use Scouterna\Scoutorg\Builder\Bases;
use Scouterna\Scoutorg\Model;
use Scouterna\Scoutorg\Builder;

class PartProvider implements Builder\IPartProvider
{
    /** @var Handler[] */
    private $handlers;

    public function __construct($db)
    {
        $this->handlers = [];
        $this->handlers[Bases\ScoutGroupBase::class] = new ScoutGroupHandler($db);
        $this->handlers[Bases\BranchBase::class] = new BranchHandler($db);
        $this->handlers[Bases\TroopBase::class] = new TroopHandler($db);
        $this->handlers[Bases\PatrolBase::class] = new PatrolHandler($db);
        $this->handlers[Bases\GroupRoleBase::class] = new GroupRoleHandler($db);
        $this->handlers[Bases\GroupMemberBase::class] = new GroupMemberHandler($db);
    }

    /**
     * @inheritdoc
     */
    public function getBasePart($id, string $type): ?Bases\ObjectBase
    {
        if (!isset($this->handlers[$type])) {
            return null;
        }
        return $this->handlers[$type]->getBase($id);
    }

    /**
     * @inheritdoc
     */
    public function getLinkPart(Model\Uid $uid, string $type, string $name): ?Builder\Link
    {
        if (!isset($this->handlers[$type])) {
            return null;
        }

        return $this->handlers[$type]->getLink($uid, $name);
    }

    /**
     * @inheritdoc
     */
    public function getLinkParts(Model\Uid $uid, string $type, string $name): array
    {
        if (!isset($this->handlers[$type])) {
            return [];
        }

        return $this->handlers[$type]->getLinks($uid, $name);
    }
}
