<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'city',
        'street',
        'postal_code',
        'phone',
        'is_default',
        // 'country',  // если добавишь колонку в таблицу
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute(): string
    {
        return trim(sprintf(
            '%s, %s%s%s',
            $this->city,
            $this->street,
            $this->postal_code ? ', ' . $this->postal_code : '',
            $this->phone ? ' (тел. ' . $this->phone . ')' : ''
        ));
    }
}
