<?php

class SubformButtons implements ArrayAccess
{
    private $add;
    private $addIndex = 0;
    private $defaultAdd;

    private $remove;
    private $removeIndex = 0;
    private $defaultRemove;

    private $move;
    private $moveIndex = 0;
    private $defaultMove;

    public function __construct(
        array $add = [],
        bool $defaultAdd,
        array $remove = [],
        bool $defaultRemove,
        array $move = [],
        bool $defaultMove
    ) {
        $this->add = $add;
        $this->defaultAdd = $defaultAdd;
        $this->remove = $remove;
        $this->defaultRemove = $defaultRemove;
        $this->move = $move;
        $this->defaultMove = $defaultMove;
    }

    public function offsetExists($offset)
    {
        switch ($offset) {
            case 'add':
            case 'remove':
            case 'move':
                return true;
        }
        return false;
    }

    public function offsetGet($offset)
    {
        if ($offset == 'add') {
            if ($this->addIndex == count($this->add)) {
                return $this->defaultAdd;
            } else {
                return $this->add[$this->addIndex++];
            }
        } elseif ($offset == 'remove') {
            if ($this->removeIndex == count($this->remove)) {
                return $this->defaultRemove;
            } else {
                return $this->remove[$this->removeIndex++];
            }
        } elseif ($offset == 'move') {
            if ($this->moveIndex == count($this->move)) {
                return $this->defaultMove;
            } else {
                return $this->move[$this->moveIndex++];
            }
        } else {
            return null;
        }
    }

    public function offsetSet($offset, $value)
    {
        // Nope

    }

    public function offsetUnset($offset)
    {
        // Nope
    }
}
