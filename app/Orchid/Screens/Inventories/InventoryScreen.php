<?php

namespace App\Orchid\Screens\Inventories;

use App\Models\Inventory;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class InventoryScreen extends Screen
{
    public $inventory;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        if (intval(request() -> route('inventory_id'))) {
            return [
                'inventories' => Inventory::findOrFail(request() -> route('inventory_id')),
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
        return $this -> inventory ? 'Изменить инвентарь' : 'Создать инвентарь';
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
                Input::make('inventory.name')
                    -> title('Название')
                    -> required(),
                Input::make('inventory.quantity')
                    -> title('Количество')
                    -> type('number')
                    -> required(),
                Select::make('inventory.type')
                    ->title('Тип')
                    ->options(Inventory::$types)
                    ->required(),
            ]),
        ];
    }

    public function save()
    {
        if (intval(request() -> route('inventory_id'))) {
            Inventory::findOrFail(request() -> route('inventory_id')) -> update(request() -> input('inventory'));
        } else {
            Inventory::create(request() -> input('inventory'));
        }

        return redirect()->route('platform.inventories');
    }
}
