<?php

namespace Bilogic\OrchidExamples\Facades;

use Illuminate\Support\Facades\Facade;

class OrchidExamples extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'orchidexamples';
    }
}
