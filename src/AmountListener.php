<?php

namespace Bilogic\OrchidExamples;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;

class AmountListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'a',
        'b',
    ];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncSum';

    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        return [
            Layout::rows([
                Input::make('a')
                    ->title('First argument')
                    ->type('number'),

                Input::make('b')
                    ->title('Second argument')
                    ->type('number'),

                Input::make('sum')
                // ->readonly()
                    ->canSee($this->query->has('sum')),
            ]),
        ];
    }
}
