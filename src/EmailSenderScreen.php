<?php

namespace Bilogic\OrchidExamples;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
// use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class EmailSenderScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Send email';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = "Let's you send an email";

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
                Input::make('subject_variable')
                    ->title('Subject')
                    ->required()
                    ->placeholder('Message subject line')
                    ->help('Enter the subject line for your message'),

                Relation::make('users.')
                    ->title('Recipients')
                    ->multiple()
                    ->required()
                    ->placeholder('Email addresses')
                    ->help('Enter the users that you would like to send this message to.')
                    ->fromModel(User::class, 'name', 'email'),

                SimpleMDE::make('content')
                    ->title('Content')
                    ->required()
                    ->placeholder('Insert text here ...')
                    ->help('Add the content for the message that you would like to send.'),

            ]),
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
            'subject_variable' => date('F') . ' Campaign News',
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
            Button::make('Send Message')
                ->icon('paper-plane')
                ->method('sendMessage'),
        ];
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        if (!Auth::user()->hasAccess("platform.systems.email.send")) {
            Alert::error('Sorry, you have no permission to send email.');
            return;
        }

        $request->validate([
            'subject' => 'required|min:6|max:50',
            'users' => 'required',
            'content' => 'required|min:10',
        ]);

        Mail::raw($request->get('content'), function (Message $message) use ($request) {

            $message->subject($request->get('subject'));

            foreach ($request->get('users') as $email) {
                $message->to($email);
            }
        });

        Alert::info('Your email message has been sent successfully.');
    }

}
