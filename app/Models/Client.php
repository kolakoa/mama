<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Client extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = [
        'name',
        'last_conversation'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected function lastConversation(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_null($value) ? 'Не было' : $value,
        );
    }
}
