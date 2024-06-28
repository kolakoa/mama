<?php

namespace App\Orchid\Screens\Clients;

use App\Models\Client;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ClientScreen extends Screen
{
    public $client;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        if (request() -> route('client_id') !== null) {
            return [
                'client' => Client::findOrFail(request() -> route('client_id')),
            ];
        } else return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        if ($this -> client) {
            return 'Редактирование клиента';
        } else {
            return 'Добавление клиента';
        }
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->method('save'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('client.name')
                    -> title('Имя')
                    -> required(),
                DateTimer::make('client.last_conversation')
                    -> title('Последний разговор')
                    -> form('d.m.Y H:i'),
            ]),
        ];
    }

    public function save()
    {
        if (intval(request() -> route('client_id'))) {
            Client::findOrFail(request() -> route('client_id')) -> update(request() -> input('client'));
        } else {
            Client::create(request() -> input('client'));
        }

        Toast::success('Клиент успешно сохранен');
        return redirect()
            -> route('platform.clients');
    }
}
