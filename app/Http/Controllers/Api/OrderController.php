<?php

namespace App\Http\Controllers\Api;

use App\Enums\AddressType;
use App\Enums\OrderStatus;
use App\Helpers\Checkout;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderListResource;
use App\Models\Customer;
use App\Models\Order;
use App\Http\Requests\OrderRequest;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $orderList = Order::query()
            ->where('created_by', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate();

        return OrderListResource::collection($orderList);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return array
     */
    public function show(Order $order)
    {
        return $this->orderDetails($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $orderData = $request->validated();

        $order->status = $orderData['status'];
        $order->updated_by = $user->id;

        $order->save();

        return $this->orderDetails($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    private function orderDetails($order)
    {
        list($totalPrice, $products, $orderItems, $productsByKey) = Checkout::getDetailsByOrder($order->id);

        $billingAddress = OrderDetail::query()->where([
            'order_id' => $order->id,
            'type' => AddressType::Billing->value,
        ])->first();

        $shippingAddress = OrderDetail::query()->where([
            'order_id' => $order->id,
            'type' => AddressType::Shipping->value,
        ])->first();

        $customer = Customer::query()->where([
            'id' => $order->created_by,
        ])->first();

        $orderItems = $products->map(function ($product) use ($orderItems) {
            return [
                'id' => $product->id,
                'slug' => $product->slug,
                'image_url' => $product->image ?? null,
                'title' => $product->title,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $orderItems[$product->id]['quantity'],
                'total' => number_format($product->price * $orderItems[$product->id]['quantity'], 2),
            ];
        });

        $orderStatuses = OrderStatus::getStatuses();

        return [
            'order' => new OrderListResource($order),
            'billing' => new OrderDetailResource($billingAddress),
            'shipping' => new OrderDetailResource($shippingAddress),
            'customer' => new CustomerResource($customer),
            'order_items' => $orderItems,
            'total_price' => $totalPrice,
            'order_statuses' => $orderStatuses
        ];
    }
}
