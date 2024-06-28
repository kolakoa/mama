<?php

namespace App\Orchid\Screens\Clients;

use App\Models\Client;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class ClientsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'clients' => Client::paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Клиенты';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить клиента')
                ->route('platform.client'),
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
            Layout::table('clients', [
                TD::make('name', 'Имя'),
                TD::make('last_conversation', 'Последний разговор'),
                TD::make('action', 'Действие')
                    -> render(function (Client $client) {
                        return Link::make('Редактировать')
                            ->route('platform.client', [
                                'client_id' => $client->id,
                            ]);
                    }),
            ]),
        ];
    }
}
