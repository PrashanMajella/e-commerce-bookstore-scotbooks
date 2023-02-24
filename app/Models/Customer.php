<?php

namespace App\Models;

use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'status', 'created_by', 'updated_by'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class, 'created_by', 'id');
    }

    public function customerAddress(): HasOne
    {
       return $this->hasOne(CustomerAddress::class, 'customer_id', 'id');
    }

    public function billingAddress(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'customer_id', 'id')
            ->where('type', '=', AddressType::Billing->value);
    }

    public function shippingAddress(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'customer_id', 'id')
            ->where('type', '=', AddressType::Shipping->value);
    }
}
