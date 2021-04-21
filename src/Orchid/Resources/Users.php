<?php

namespace Bilogic\OrchidExamples\Orchid\Resources;

use App\Models\User;
use Orchid\Crud\Resource;
use Orchid\Screen\TD;

class Users extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = User::class;

    public static function label(): string
    {
        return "<H1> of the page";
    }

    public static function description(): ?string
    {
        return "Text under the <H1> in the file of `" . __FILE__ . "`";
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('name'),
            TD::make('email'),

            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    public function legend(): array
    {
        return [];
    }
}
