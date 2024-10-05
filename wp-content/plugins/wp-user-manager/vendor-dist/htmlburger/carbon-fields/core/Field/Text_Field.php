<?php

namespace WPUM\Carbon_Fields\Field;

use WPUM\Carbon_Fields\Exception\Incorrect_Syntax_Exception;
/**
 * Text field class.
 */
class Text_Field extends Field
{
    /**
     * {@inheritDoc}
     */
    protected $allowed_attributes = array('max', 'maxLength', 'min', 'pattern', 'placeholder', 'readOnly', 'step', 'type');
}
