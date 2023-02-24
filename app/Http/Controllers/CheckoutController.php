<?php

namespace App\Http\Controllers;

use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Helpers\Cart;
use App\Helpers\Checkout;
use App\Http\Requests\CheckoutRequest;
use App\Models\CartItem;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    /**
     * Summary of Stripe
     * @return StripeClient
     */
    private function stripe(): StripeClient
    {
        return new StripeClient(getenv('STRIPE_SECRET_KEY'));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        /** @var \App\Models\Customer $user */
        $customer = $user->customer;

        /** @var \App\Helpers\Cart */
        list($totalPrice, $products, $cartItems) = Cart::getDetails();

        if ($totalPrice < 1) {
            return Redirect::route('product.index')->with('status', 'empty-cart');
        }

        $countries = Country::query()->orderBy('name')->get();

        list($billingAddress, $shippingAddress) = $this->handleExistingOrderDetails($request);

        return view('checkout.view', compact(
            'user',
            'customer',
            'billingAddress',
            'shippingAddress',
            'countries'
        ));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param   \App\Http\Requests\CheckoutRequest  $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function store(CheckoutRequest $request)
    {
        $checkoutData = $request->validated();

        $shippingData = $checkoutData['shipping'];
        $billingData = $checkoutData['billing'];

        /** @var \App\Models\User $user */
        $user = $request->user();

        /** @var \App\Models\Customer $customer */
        $customer = $user->customer;

        /** @var \App\Helpers\Cart */
        list($totalPrice, $products, $cartItems) = Cart::getDetails();

        if ($totalPrice < 1) {
            return Redirect::route('product.index')->with('status', 'empty-cart');
        }

        if ($customer) {
            $customer->update([
                'first_name' => $billingData['first_name'],
                'last_name' => $billingData['last_name'],
                'email' => $billingData['email'],
                'phone' => $billingData['phone'],
            ]);

            $customerAddress = CustomerAddress::query()->where([
                'customer_id' => $customer->id,
            ])->first();

            $customerAddress = $customerAddress->update([
                'address1' => $billingData['address1'],
                'address2'=> $billingData['address2'],
                'city'=> $billingData['city'],
                'state'=> $billingData['state'],
                'zip_code'=> $billingData['zip_code'],
                'country_code'=> $billingData['country_code'],
            ]);
        } else {
            $customer = Customer::create([
                'first_name' => $billingData['first_name'],
                'last_name' => $billingData['last_name'],
                'email' => $billingData['email'],
                'phone' => $billingData['phone'],
                'status' => CustomerStatus::Active,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            $customerAddress = CustomerAddress::create([
                'address1'=> $billingData['address1'],
                'address2'=> $billingData['address2'],
                'city'=> $billingData['city'],
                'state'=> $billingData['state'],
                'zip_code'=> $billingData['zip_code'],
                'country_code'=> $billingData['country_code'],
                'customer_id'=> $customer->id,
            ]);
        }

        $order = Order::create([
            'total_price' => $totalPrice,
            'status' => OrderStatus::Unpaid,
            'created_by' => $customer->id,
            'updated_by' => $user->id,
        ]);

        $orderDetail = OrderDetail::query()->where([
            'order_id' => $order->id,
            'customer_id' => $customer->id,
        ])->latest()->first();

        if ($orderDetail) {
            $billingDetail = OrderDetail::query()->where([
                'order_id' => $order->id,
                'customer_id' => $customer->id,
                'type' => AddressType::Billing->value
            ])->latest()->first();

            $billingDetail->update($billingData);

            $shippingDetail = OrderDetail::query()->where([
                'order_id' => $order->id,
                'customer_id' => $customer->id,
                'type' => AddressType::Shipping->value
            ])->latest()->first();

            $shippingDetail->update($shippingData);

        } else {
            $billingData['customer_id'] = $customer->id;
            $billingData['order_id'] = $order->id;
            $billingDetail = OrderDetail::create($billingData);

            $shippingData['customer_id'] = $customer->id;
            $shippingData['order_id'] = $order->id;
            $shippingDetail = OrderDetail::create($shippingData);
        }

        /** @var \App\Helpers\Cart */
        list($totalPrice, $products, $cartItems, $productsByKey) =  Cart::getDetails();

        foreach ($products as $key => $product) {
            $orderItem[] = OrderItem::create([
                'product_id' => $cartItems[$product->id]['product_id'],
                'quantity' => $cartItems[$product->id]['quantity'],
                'unit_price' => $productsByKey[$product->id]['price'],
                'order_id' => $order->id
            ]);
        }

        $cartItems = CartItem::query()->where([
            'user_id' => $user->id
        ])->delete();

        return Redirect::route('checkout.confirm');
    }

    /**
     * Summary of confirm
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function confirm()
    {
        /** @var \App\Models\User $user */
        $user = request()->user();

        /** @var \App\Models\Customer $customer */
        $customer = $user->customer;

        /** @var \App\Helpers\Checkout */
        list($totalPrice, $products, $orderItems, $productsByKey) = Checkout::getDetails();

        return view('checkout.confirm');
    }

    /**
     * Summary of checkout
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        /** @var \App\Models\Customer $customer */
        $customer = $user->customer;

        /** @var \App\Helpers\Checkout */
        list($totalPrice, $products, $orderItems, $productsByKey) = Checkout::getDetails();

        if (!$orderItems) {
            return Redirect::route('home')->with('status', 'orders-empty');
        }

        $lineItems = [];

        foreach ($products as $key => $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $productsByKey[$product->id]['title'],
                        'images' => [$productsByKey[$product->id]['image']],
                    ],
                    'unit_amount_decimal' => $orderItems[$product->id]['unit_price'] * 100,
                ],
                'quantity' => $orderItems[$product->id]['quantity'],
            ];
        }

        $checkout_session = $this->stripe()->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
        ]);

        $order = Order::query()->where([
            'status' => OrderStatus::Unpaid,
            'created_by' => $customer->id
        ])->latest()->first();

        $paymentData = [
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'status' => PaymentStatus::Pending,
            'type' => PaymentType::CreditCard,
            'session_id' => $checkout_session->id,
            'created_by' => $order->created_by,
            'updated_by' => $order->created_by,
        ];

        $payment = Payment::create($paymentData);

        return redirect($checkout_session->url);
    }

    /**
     * Summary of checkoutOrder
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkoutOrder(Request $request, Order $order)
    {
        list($totalPrice,
            $products,
            $orderItems,
            $productsByKey) = Checkout::getDetailsByOrder($order->id);

        foreach ($products as $key => $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $productsByKey[$product->id]['title'],
                        'images' => [$productsByKey[$product->id]['image']],
                    ],
                    'unit_amount_decimal' => $orderItems[$product->id]['unit_price'] * 100,
                ],
                'quantity' => $orderItems[$product->id]['quantity'],
            ];
        }

        $checkout_session = $this->stripe()->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
        ]);

        $payment = Payment::query()->where([
            'order_id' => $order->id,
            'status' => PaymentStatus::Pending,
        ])->first();

        if ($payment) {
            $payment->amount = $order->total_price;
            $payment->status = PaymentStatus::Pending;
            $payment->type = PaymentType::CreditCard;
            $payment->session_id = $checkout_session->id;
            $payment->updated_by = $order->created_by;

            $payment->save();
        } else {
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total_price,
                'status' => PaymentStatus::Pending,
                'type' => PaymentType::CreditCard,
                'session_id' => $checkout_session->id,
                'created_by' => $order->created_by,
                'updated_by' => $order->created_by,
            ]);
        }

        return redirect($checkout_session->url);
    }

    public function success()
    {
        try {
            $session_id = $_GET['session_id'];
            $session = $this->stripe()->checkout->sessions->retrieve($session_id);

            if (!$session) {
                return $this->failure('Invalid Session ID.');
            }

            $payment = Payment::query()->where([
                'session_id' => $session_id,
                'status' => PaymentStatus::Pending
            ])->first();

            if (!$payment) {
                return $this->failure('Payment does not exist.');
            }

            $payment->status = PaymentStatus::Paid;
            $payment->save();

            $order = Order::query()->where('id', $payment->order_id)->first();

            $order->status = OrderStatus::Paid;
            $order->save();

            $customer = $session->customer_details;

            return view('checkout.success', compact('customer'));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function failure(string $message = '')
    {
        return view('checkout.failure', compact('message'));
    }

    /**
     * Summary of handleExistingOrderDetails
     * @param Request $request
     * @return array
     */
    private function handleExistingOrderDetails(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        /** @var \App\Models\Customer $user */
        $customer = $user->customer ?? false;

        if ($customer) {
            $billingAddress = OrderDetail::query()->where([
                'customer_id' => $customer->id,
                'type' => AddressType::Billing->value
            ])->latest()->first();

            $shippingAddress = OrderDetail::query()->where([
                'customer_id' => $customer->id,
                'type' => AddressType::Shipping->value
            ])->latest()->first();

        } else {
            list($first_name, $last_name) = $this->separatedName($user->name);

            $billingAddress = new OrderDetail([
                'type' => AddressType::Billing,
                'email' => $user->email,
                'first_name' => $first_name,
                'last_name' => $last_name,
            ]);

            $shippingAddress = new OrderDetail([ 'type' => AddressType::Shipping ]);
        }

        return [ $billingAddress, $shippingAddress ];
    }

    /**
     * Summary of separatedName
     * @param string $name
     * @return array<string>
     */
    public function separatedName(string $name) {
        $spaces = preg_match('/ /', $name);
        if ($spaces) {
            list($first_name, $last_name) = explode(' ', $name);
        } else {
            $first_name = $name;
            $last_name = '';
        }

        return [$first_name, $last_name];
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \App\Http\Requests\UpdateCheckoutRequest  $request
    //  * @param  \App\Models\Checkout  $checkout
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(CheckoutRequest $request, Checkout $checkout)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Checkout  $checkout
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Checkout $checkout)
    // {
    //     //
    // }
}
