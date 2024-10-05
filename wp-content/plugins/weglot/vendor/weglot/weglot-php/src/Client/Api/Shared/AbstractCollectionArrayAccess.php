<?php

namespace Weglot\Client\Api\Shared;

/**
 * Trait AbstractCollectionArrayAccess
 * @package Weglot\Client\Api\Shared
 */
trait AbstractCollectionArrayAccess
{
    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset) {
        return isset($this->collection[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this->collection[$offset]) ? $this->collection[$offset] : null;
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if (isset($this->collection[$offset]) && $value instanceof AbstractCollectionEntry) {
            $this->collection[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }
}
