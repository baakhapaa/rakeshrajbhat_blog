<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'consent' => ['accepted'],
            'website' => ['nullable', 'max:0'],
        ]);

        $email = Str::lower(trim($validated['email']));
        $subscriber = NewsletterSubscriber::where('email', $email)->first();

        if ($subscriber?->confirmed_at) {
            return back()->with('newsletter_error', 'This email is already subscribed.');
        }

        $token = Str::random(64);
        $subscriber = $subscriber ?: new NewsletterSubscriber(['email' => $email]);
        $subscriber->forceFill([
            'email' => $email,
            'confirmation_token' => $token,
            'consented_at' => now(),
        ])->save();

        $confirmUrl = route('newsletter.confirm', ['token' => $token]);
        $unsubscribeUrl = URL::signedRoute('newsletter.unsubscribe', ['subscriber' => $subscriber->id]);

        Mail::send('emails.newsletter-confirm', [
            'confirmUrl' => $confirmUrl,
            'unsubscribeUrl' => $unsubscribeUrl,
        ], function ($mail) use ($email) {
            $mail->to($email)->subject('Confirm your Rakesh Rajbhat newsletter subscription');
        });

        return back()->with('newsletter_success', 'Please check your email to confirm your subscription.');
    }

    public function confirm(string $token)
    {
        $subscriber = NewsletterSubscriber::where('confirmation_token', $token)->firstOrFail();
        $subscriber->forceFill([
            'confirmed_at' => $subscriber->confirmed_at ?: now(),
            'confirmation_token' => null,
        ])->save();

        return redirect()->route('home')->with('newsletter_success', 'Your newsletter subscription is confirmed.');
    }

    public function unsubscribe(NewsletterSubscriber $subscriber)
    {
        $subscriber->forceFill([
            'confirmed_at' => null,
        ])->save();

        return redirect()->route('home')->with('newsletter_success', 'You have been unsubscribed from the newsletter.');
    }
}
