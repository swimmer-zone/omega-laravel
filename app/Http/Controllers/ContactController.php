<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use App\Mail\ContactConfirmation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $contactEmail = config('mail.contact_address');

        // Send the message to you.
        Mail::to($contactEmail)
            ->send(new ContactMessage($validated));

        // Send a confirmation to the person who contacted you.
        Mail::to($validated['email'])
            ->send(new ContactConfirmation($validated));

        return response()->json([
            'message' => 'Your message has been sent.',
        ]);
    }
}
