<?php
namespace App\Enums;

enum OrderStatus: string
{
    case Unpaid = 'unpaid';
    case Paid = 'paid';
    case Pending = 'pending';
    case Cancelled = 'cancelled';
    case Shipped = 'shipped';
    case Completed = 'completed';

    /**
     * Summary of getStatuses
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            self::Pending,
            self::Shipped,
            self::Completed
        ];
    }
}
