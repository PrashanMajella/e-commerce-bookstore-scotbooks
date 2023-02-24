<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactMessageListResource;
use App\Models\ContactMessage;
use App\Http\Requests\StoreContactMessageRequest;
use App\Http\Requests\UpdateContactMessageRequest;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\DateTime;

class ContactMessageController extends Controller
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
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $contactMessageList = ContactMessage::query()
            ->where('id', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate();

        return ContactMessageListResource::collection($contactMessageList);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactMessageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function show(ContactMessage $contactMessage)
    {
        return $this->messageDetails($contactMessage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactMessageRequest  $request
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return array
     */
    public function update(UpdateContactMessageRequest $request, ContactMessage $contactMessage)
    {
        $messageData = $request->validated();

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $contactMessage->seen = $messageData['seen'];

        if ($messageData['seen']) {
            $contactMessage->seen_by = $authUser->id;
        } else {
            $contactMessage->seen_by = null;
        }

        $contactMessage->save();

        return $this->messageDetails($contactMessage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactMessage $contactMessage)
    {
        //
    }

    private function messageDetails($message)
    {
        return [
            'id' => $message->id,
            'first_name' => $message->first_name,
            'last_name' => $message->last_name,
            'email' => $message->email,
            'phone' => $message->phone,
            'subject' => $message->subject,
            'message' => $message->message,
            'seen' => $message->seen ? true : false,
            'created_at' => (new DateTime($message->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new DateTime($message->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
