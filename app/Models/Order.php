<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED = 'canceled';

    public const STATUS_LABELS = [
        self::STATUS_PENDING => 'Ожидает оплаты',
        self::STATUS_PAID => 'Оплачен',
        self::STATUS_SHIPPED => 'Отправлен',
        self::STATUS_COMPLETED => 'Завершен',
        self::STATUS_CANCELED => 'Отменен',
    ];

    // 1. Обновляем способы оплаты по инструкции
    public const PAYMENT_METHOD_CASH = 'cash';
    public const PAYMENT_METHOD_YOOKASSA = 'yookassa';

    public const PAYMENT_METHODS = [
        self::PAYMENT_METHOD_CASH,
        self::PAYMENT_METHOD_YOOKASSA,
    ];

    public const PAYMENT_METHOD_LABELS = [
        self::PAYMENT_METHOD_CASH => 'Наличными при получении',
        self::PAYMENT_METHOD_YOOKASSA => 'Онлайн-оплата (ЮKassa)',
    ];

    protected $fillable = [
        'user_id',
        'address_id',
        'total',
        'status',
        'payment_method',
        'shipping_address'
    ];

    public function user(): BelongsTo // <-- Добавьте этот метод
    {
        return $this->belongsTo(User::class);
    }
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // 2. Добавляем связи с платежами
    public function payments(): HasMany
    {
        return $this->hasMany(OrderPayment::class);
    }

    // Связь для получения самой последней попытки оплаты
    public function latestPayment(): HasOne
    {
        return $this->hasOne(OrderPayment::class)->latestOfMany();
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return self::PAYMENT_METHOD_LABELS[$this->payment_method] ?? $this->payment_method;
    }
}
