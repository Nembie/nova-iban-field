<?php

namespace Nembie\NovaIbanField;

use Laravel\Nova\Fields\Field;

class NovaIbanField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-iban-field';
}
