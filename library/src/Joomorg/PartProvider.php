<?php

namespace Scouterna\Scoutorg\Joomorg;

use Scouterna\Scoutorg\Builder\Bases;
use Scouterna\Scoutorg\Builder\IPartProvider;
use Scouterna\Scoutorg\Builder\Uid;

class PartProvider implements IPartProvider
{
    /** @var Handler[] */
    private $handlers;

    public function __construct($db)
    {
        $this->handlers = [];
        $this->handlers[Bases\ScoutGroupBase::class] = new ScoutGroupHandler($db);
        $this->handlers[Bases\BranchBase::class] = new BranchHandler($db);
        $this->handlers[Bases\TroopBase::class] = new TroopHandler($db);
    }

    /**
     * @inheritdoc
     */
    public function getBasePart($id, string $type): ?Bases\ObjectBase
    {
        if (!isset($this->handlers[$type])){
            return null;
        }
        return $this->handlers[$type]->getBase($id);
    }

    /**
     * @inheritdoc
     */
    public function getLinkPart(Uid $uid, string $type, string $name): ?Uid
    {
        if (!isset($this->handlers[$type])){
            return null;
        }

        return $this->handlers[$type]->getLink($uid, $name);
    }

    /**
     * @inheritdoc
     */
    public function getLinkParts(Uid $uid, string $type, string $name): array
    {
        if (!isset($this->handlers[$type])){
            return [];
        }

        return $this->handlers[$type]->getLinks($uid, $name);
    }
}