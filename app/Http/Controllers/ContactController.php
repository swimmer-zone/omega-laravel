<?php

namespace App\Http\Controllers;

use App\Mail\ContactConfirmation;
use App\Mail\ContactMessage;
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
            'website' => ['nullable', 'string', 'max:255'],
        ]);

        /*
         * Honeypot.
         *
         * If a bot filled in the hidden website field, pretend
         * everything worked without actually sending anything.
         */
        if (!empty($validated['website'])) {
            return response()->json([
                'message' => 'Your message has been sent.',
            ]);
        }

        $contactEmail = config('mail.contact_address');

        if (!$contactEmail) {
            throw new \RuntimeException(
                'CONTACT_EMAIL is not configured.'
            );
        }

        /*
         * Send the message to you.
         */
        Mail::to($contactEmail)
            ->send(new ContactMessage($validated));

        /*
         * Send a confirmation to the person who contacted you.
         */
        Mail::to($validated['email'])
            ->send(new ContactConfirmation($validated));

        return response()->json([
            'message' => 'Your message has been sent.',
        ]);
    }
}
