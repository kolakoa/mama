<?php

namespace App\Orchid\Screens\Inventories;

use App\Models\Inventory;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class InventoriesScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'inventories' => Inventory::paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Инвентарь';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать')
                ->route('platform.inventory'),
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
            Layout::table('inventories', [
                TD::make('name', 'Название'),
                TD::make('type', 'Тип'),
                TD::make('quantity', 'Количество'),
                TD::make('delete', 'Удалить')
                    ->render(function (Inventory $inventory) {
                        return Button::make('Удалить')
                            ->method('delete', ['inventory_id' => $inventory->id]);
                    })
            ]),
        ];
    }

    public function delete()
    {
        Inventory::findOrFail(request('inventory_id'))->delete();
    }
}
