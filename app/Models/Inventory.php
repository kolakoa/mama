<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Inventory extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = [
        'type',
        'name',
        'quantity'
    ];

    static $types = [
        'service' => 'Услуга',
        'product' => 'Товар',
    ];

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => self::$types[$value],
        );
    }
}
