<?php

namespace Bilogic\OrchidExamples;

use Bilogic\OrchidExamples\AmountListener;
// use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class DOMUpdateScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'DOM Update';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = "HTML update based on interactions";

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        // 'platform.example.email.index',
    ];

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('a')
                    ->title('First argument')
                    ->type('number'),

                Input::make('b')
                    ->title('Second argument')
                    ->type('number'),
            ]),
            AmountListener::class,
        ];
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'a' => 1,
            'b' => 2,
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            // Button::make('Send Message')
            //     ->icon('paper-plane')
            //     ->method('sendMessage'),
        ];
    }

    public function asyncSum(int $a = null, int $b = null)
    {
        return [
            'sum' => $a + $b,
        ];
    }

}
