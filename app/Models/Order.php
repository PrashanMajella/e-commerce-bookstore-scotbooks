<?php

namespace App\Models;

use App\Enums\AddressType;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'total_price', 'created_by', 'updated_by'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'id', 'created_by');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }

    public function billingAddress(): HasOne
    {
        return $this->hasOne(OrderDetail::class, 'order_id', 'id')
            ->where('type', '=', AddressType::Billing->value);
    }

    public function shippingAddress(): HasOne
    {
        return $this->hasOne(OrderDetail::class, 'order_id', 'id')
            ->where('type', '=', AddressType::Shipping->value);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function isPaid()
    {
        return $this->status === OrderStatus::Paid->value;
    }

    public static function deleteUnpaidOrders($hours)
    {
        return Order::query()->where('status', OrderStatus::Unpaid->value)
            ->where('created_at', '<', Carbon::now()->subHours($hours))
            ->delete();
    }
}
