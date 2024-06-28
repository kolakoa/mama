<?php

namespace App\Orchid\Screens\Orders;

use App\Models\Client;
use App\Models\Inventory;
use App\Models\Order;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class OrderScreen extends Screen
{
    public $order;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        if (intval(request() -> route('order_id'))) {
            return [
                'orders' => Order::findOrFail(request() -> route('order_id')),
            ];
        } else {
            return [];
        }
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this -> order ? 'Изменить заказ' : 'Создать заказ';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать')
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
                Relation::make('order.client_id')
                    ->title('Заказчик')
                    ->fromModel(Client::class, 'name', 'id')
                    ->required(),
                Matrix::make('order.inventories')
                    ->title('Товары')
                    ->columns([
                        'Товар' => 'inventory_id',
                    ])
                    ->fields([
                        'inventory_id' => Relation::make()
                            ->fromModel(Inventory::class, 'name', 'id'),
                    ])
            ]),
        ];
    }

    public function save()
    {
        if (intval(request() -> route('order_id'))) {
            $this -> order -> update(request() -> get('order'));
        } else {
            Order::create(request() -> get('order'));
        }

        return redirect()->route('platform.orders');
    }
}
