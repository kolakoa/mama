<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Order extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = [
        'client_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function inventories()
    {
        return $this->hasManyThrough(Inventory::class, 'order_inventory', 'order_id', 'id', 'id', 'inventory_id');
    }
}
