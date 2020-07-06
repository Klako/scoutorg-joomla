<?php

namespace Scouterna\Scoutorg\Joomorg;

use Scouterna\Scoutorg\Builder\Bases\ObjectBase;
use Scouterna\Scoutorg\Builder\IPartProvider;
use Scouterna\Scoutorg\Builder\Uid;

class PartProvider implements IPartProvider
{
    /**
     * @inheritdoc
     */
    public function getBasePart($id, string $type): ?ObjectBase
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getLinkPart(Uid $uid, string $type, string $name): ?Uid
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getLinkParts(Uid $uid, string $type, string $name): array
    {
        return [];
    }
}