<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrganizationController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Summary of about
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function about()
    {
        return view('about.index');
    }

    /**
     * Summary of contact
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function contact()
    {
        return view('contact.index');
    }

    public function storeContact(StoreContactMessageRequest $request)
    {
        $contactData = $request->validated();

        ContactMessage::create($contactData);

        return Redirect::route('contact.index')->with('status', 'message-saved');
    }

    public function privacyPolicy()
    {
        return view('law.privacy-policy');
    }

    public function termsConditions()
    {
        return view('law.terms-conditions');
    }
}

