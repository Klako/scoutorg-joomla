<?php

namespace Scouterna\Scoutorg\Joomorg;

use Scouterna\Scoutorg\Builder\Bases\ObjectBase;
use Scouterna\Scoutorg\Builder\Uid;

abstract class Handler
{
    /** @var \JDatabaseDriver */
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Gets org object base from id (source is joomla)
     * @param int|string $id 
     * @return ObjectBase 
     */
    public abstract function getBase($id);

    /**
     * Gets link of org object from uid
     * @param Uid $uid 
     * @param string $name 
     * @return Uid 
     */
    public abstract function getLink($uid, $name);

    /**
     * Gets list of links of org object from uid
     * @param Uid $uid 
     * @param string $name 
     * @return Uid[]
     */
    public abstract function getLinks($uid, $name);
}
