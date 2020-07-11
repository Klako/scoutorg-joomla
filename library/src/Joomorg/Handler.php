<?php

namespace Scouterna\Scoutorg\Joomorg;

abstract class Handler
{
    /** @var \JDatabaseDriver */
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public abstract function getBase($id);

    public abstract function getLink($id, $name);

    public abstract function getLinks($id, $name);
}
