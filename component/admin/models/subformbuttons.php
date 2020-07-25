<?php

class SubformButtons implements ArrayAccess
{
    private $add;
    private $addIndex = 0;

    private $remove;
    private $removeIndex = 0;

    private $move;
    private $moveIndex = 0;

    public function __construct(array $add = [], array $remove = [], array $move = [])
    {
        $this->add = $add;
        $this->remove = $remove;
        $this->move = $move;
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
                return true;
            } else {
                return $this->add[$this->addIndex++];
            }
        } elseif ($offset == 'remove') {
            if ($this->removeIndex == count($this->remove)) {
                return true;
            } else {
                return $this->remove[$this->removeIndex++];
            }
        } elseif ($offset == 'move') {
            if ($this->moveIndex == count($this->move)) {
                return true;
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
