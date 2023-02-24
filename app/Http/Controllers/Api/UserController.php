<?php

namespace App\Http\Controllers\Api;

use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserListResource;
use App\Models\Customer;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\DateTime;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'asc');

        $userList = User::query()
            ->where('id', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate();

        return UserListResource::collection($userList);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return array
     */
    public function show(User $user)
    {
        return $this->userDetails($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return array
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $userData = $request->validated();

        if ($user->id !== 1) {
            /** @var \App\Models\User $authUser */
            $authUser = Auth::user();

            $user->is_admin = $userData['is_admin'];

            if ($userData['is_admin']) {
                $user->authorized_by = $authUser->id;
            } else {
                $user->authorized_by = null;
            }

            $user->save();
        }

        return $this->userDetails($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    private function userDetails($user)
    {
        $customer = Customer::query()->where(
            ['created_by' => $user->id]
        )->first();

        if ($customer) {
            $customerDetails = [
                'id' => $customer->id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'status' => $customer->status === CustomerStatus::Active->value,
                'created_by' => $customer->created_by,
                'updated_by' => $customer->updated_by,
                'created_at' => (new DateTime($customer->created_at))->format('Y-m-d H:i:s'),
                'updated_at' => (new DateTime($customer->updated_at))->format('Y-m-d H:i:s'),
                'address' => [
                    'id' => $customer->customerAddress->id,
                    'address1' => $customer->customerAddress->address1,
                    'address2' => $customer->customerAddress->address2,
                    'city' => $customer->customerAddress->city,
                    'state' => $customer->customerAddress->state,
                    'zip_code' => $customer->customerAddress->zip_code,
                    'country_code' => $customer->customerAddress->country_code,
                    'customer_id' => $customer->customerAddress->customer_id,
                    'created_at' => (new DateTime($customer->customerAddress->created_at))->format('Y-m-d H:i:s'),
                    'updated_at' => (new DateTime($customer->customerAddress->updated_at))->format('Y-m-d H:i:s'),
                ]
            ];
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => (new DateTime($user->email_verified_at))->format('Y-m-d H:i:s'),
            'created_at' => (new DateTime($user->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new DateTime($user->updated_at))->format('Y-m-d H:i:s'),
            'is_admin' => $user->is_admin ? true : false,
            'authorized_by' => $user->authorized_by,
            'is_customer' => $customer ? true : false,
            'customer' => $customer ? $customerDetails : []
        ];
    }
}
