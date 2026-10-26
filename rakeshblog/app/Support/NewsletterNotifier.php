<?php

namespace App\Support;

use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class NewsletterNotifier
{
    public static function notify(string $title, ?string $summary, string $url): void
    {
        $subscribers = NewsletterSubscriber::whereNotNull('confirmed_at')->get();

        if ($subscribers->isEmpty()) {
            return;
        }

        $summary = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $summary))), 220);

        foreach ($subscribers as $subscriber) {
            try {
                $unsubscribeUrl = URL::signedRoute('newsletter.unsubscribe', ['subscriber' => $subscriber->id]);

                Mail::send('emails.newsletter-update', [
                    'title' => $title,
                    'summary' => $summary,
                    'url' => $url,
                    'unsubscribeUrl' => $unsubscribeUrl,
                ], function ($mail) use ($subscriber, $title) {
                    $mail->to($subscriber->email)
                        ->subject('New on Rakesh Rajbhat: ' . $title);
                });
            } catch (\Throwable $e) {
                Log::error('Newsletter send failed for ' . $subscriber->email . ': ' . $e->getMessage());
            }
        }
    }
}
