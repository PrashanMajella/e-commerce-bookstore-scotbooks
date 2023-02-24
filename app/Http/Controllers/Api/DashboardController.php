<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        /** @var \App\Models\Customer $clients */
        $clients = Customer::query()->count();

        /** @var \App\Models\Payment $sales */
        $sales = Payment::query()->sum('amount');

        /** @var \App\Models\Payment $payments */
        $payments = Payment::query()->count();

        /** @var \App\Models\Order $newOrders */
        $orders = Order::query()->count();

        /** @var \App\Models\Order $newOrders */
        $newOrders = Order::query()->where([
            'status' => OrderStatus::Paid->value
        ])->count();

        /** @var \App\Models\ContactMessage $newMessages */
        $messages = ContactMessage::query()->count();

        /** @var \App\Models\ContactMessage $newMessages */
        $newMessages = ContactMessage::query()->where([
            'seen' => false,
        ])->count();

        $users = User::query()->count();

        /** @var \App\Models\User $adminUsers */
        $adminUsers = User::query()->where([
            'is_admin' => true,
        ])->count();

        return [
            'clients' => $clients,
            'sales' => $sales,
            'payments' => $payments,
            'orders' => $orders,
            'new_orders' => $newOrders,
            'messages' => $messages,
            'new_messages' => $newMessages,
            'users' => $users,
            'adminUsers' => $adminUsers,
        ];
    }
}
