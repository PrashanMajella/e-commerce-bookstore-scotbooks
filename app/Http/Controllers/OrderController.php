<?php

namespace App\Http\Controllers;

use App\Enums\AddressType;
use App\Enums\OrderStatus;
use App\Helpers\Checkout;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Enum;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        /** @var \App\Models\Customer $user */
        $customer = $user->customer;

        if ($customer) {
            $orders = Order::query()
            ->where(['created_by' => $customer->id])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

            return view('order.index', compact('orders'));
        } else {
            return Redirect::route('home')->with('status', 'orders-empty');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();

        /** @var \App\Models\Customer $user */
        $customer = $user->customer;

        $this->verifyCustomer($customer, $order);

        list($totalPrice, $products, $orderItems, $productsByKey) = Checkout::getDetailsByOrder($order->id);

        return view('order.view', compact('order', 'products', 'orderItems'));
    }


    public function invoice(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();

        /** @var \App\Models\Customer $user */
        $customer = $user->customer;

        $this->verifyCustomer($customer, $order);

        list($totalPrice, $products, $orderItems, $productsByKey) = Checkout::getDetailsByOrder($order->id);

        $billingAddress = OrderDetail::query()->where([
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'type' => AddressType::Billing->value,
        ])->first();

        $shippingAddress = OrderDetail::query()->where([
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'type' => AddressType::Shipping->value,
        ])->first();

        return view('order.invoice', compact(
            'totalPrice',
            'products',
            'orderItems',
            'productsByKey',
            'billingAddress',
            'shippingAddress',
            'order'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();

        /** @var \App\Models\Customer $user */
        $customer = $user->customer;

        $this->verifyCustomer($customer, $order);

        $orderData = $request->validate([
            'status' => [new Enum(OrderStatus::class)]
        ]);

        $order->status = $orderData['status'];

        $order->save();

        return Redirect::route('order.index')->with('status', 'order-updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();

        /** @var \App\Models\Customer $user */
        $customer = $user->customer;

        $this->verifyCustomer($customer, $order);

        //
    }

    /**
     * Summary of verifyCustomer
     * @param mixed $customer
     * @param mixed $order
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    private function verifyCustomer($customer, $order)
    {
        if (!$customer) {
            return Redirect::route('home')->with('status', 'orders-empty');
        } else if ($order->created_by !== $customer->id) {
            return abort(403, 'Unauthorized action.');
        }
    }
}
