<?php

namespace App\Http\Controllers;

use App\Mail\ServiceRequestReceived;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service' => ['required', 'string', Rule::in(['locksmith', 'parts', 'tires', 'junk', 'other'])],
            'year' => ['nullable', 'string', 'regex:/^(19|20)\d{2}$/'],
            'make' => ['nullable', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'need' => ['required', 'string', 'max:5000'],
            'name' => ['required_if:service,other', 'nullable', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'regex:/^(?:\+?1[\s.-]?)?(?:\([2-9]\d{2}\)|[2-9]\d{2})[\s.-]?[2-9]\d{2}[\s.-]?\d{4}$/',
            ],
            'email' => ['required', 'email', 'max:255'],
            'runs' => ['exclude_unless:service,junk', 'required', Rule::in(['yes', 'no', 'not-sure'])],
            'zip' => ['exclude_unless:service,junk', 'required', 'regex:/^\d{5}$/'],
            'photos' => ['nullable', 'array', 'max:3'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'website' => ['nullable', 'max:0'],
        ], [
            'phone.regex' => 'Enter a valid 10-digit US phone number, with area code (for example, (215) 555-0123).',
            'photos.*.image' => 'Each uploaded file must be an image.',
            'photos.*.max' => 'Each photo must be 5 MB or smaller.',
            'website.max' => 'The request could not be submitted.',
        ]);

        $photoPaths = collect($validated['photos'] ?? [])
            ->map(fn ($photo) => $photo->store('service-requests', 'local'))
            ->all();

        $contact = Contact::create([
            ...collect($validated)->except(['photos', 'website'])->all(),
            'photos' => $photoPaths,
        ]);

        Mail::to(config('mail.admin_address'))
            ->send(new ServiceRequestReceived($contact));

        return response()->json([
            'message' => 'Your request has been sent. We will get back to you soon.',
        ], 201);
    }
}
