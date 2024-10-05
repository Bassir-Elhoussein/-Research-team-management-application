<?php

namespace WPUM\Carbon_Fields\Container\Fulfillable\Translator;

use WPUM\Carbon_Fields\Container\Fulfillable\Fulfillable;
use WPUM\Carbon_Fields\Container\Fulfillable\Fulfillable_Collection;
use WPUM\Carbon_Fields\Container\Condition\Condition;
use WPUM\Carbon_Fields\Exception\Incorrect_Syntax_Exception;
abstract class Translator
{
    /**
     * Translate a Fulfillable to foreign data
     *
     * @param  Fulfillable $fulfillable
     * @return mixed
     */
    public function fulfillable_to_foreign(Fulfillable $fulfillable)
    {
        if (\is_a($fulfillable, 'WPUM\\Carbon_Fields\\Container\\Condition\\Condition')) {
            return $this->condition_to_foreign($fulfillable);
        }
        if (\is_a($fulfillable, 'WPUM\\Carbon_Fields\\Container\\Fulfillable\\Fulfillable_Collection')) {
            return $this->fulfillable_collection_to_foreign($fulfillable);
        }
        Incorrect_Syntax_Exception::raise('Attempted to translate an unsupported object: ' . \print_r($fulfillable, \true));
        return null;
    }
    /**
     * Translate a Condition to foreign data
     *
     * @param  Condition $condition
     * @return mixed
     */
    protected abstract function condition_to_foreign(Condition $condition);
    /**
     * Translate a Fulfillable_Collection to foreign data
     *
     * @param  Fulfillable_Collection $fulfillable_collection
     * @return mixed
     */
    protected abstract function fulfillable_collection_to_foreign(Fulfillable_Collection $fulfillable_collection);
    /**
     * Translate foreign data to a Fulfillable
     *
     * @param  mixed       $foreign
     * @return Fulfillable
     */
    public abstract function foreign_to_fulfillable($foreign);
}
