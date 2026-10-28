<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request)
    {
        $status = $this->status($request);

        $subscribers = NewsletterSubscriber::query()
            ->withStatus($status)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.newsletter.index', [
            'subscribers' => $subscribers,
            'status' => $status,
        ]);
    }

    public function export(Request $request): StreamedResponse|\Illuminate\Http\RedirectResponse
    {
        $status = $this->status($request);

        $subscribers = NewsletterSubscriber::query()
            ->withStatus($status)
            ->orderBy('email')
            ->get();

        if ($subscribers->isEmpty()) {
            return redirect()
                ->route('admin.newsletter.index', $status === 'all' ? [] : ['status' => $status])
                ->with('error', 'No subscriber emails to export.');
        }

        $filename = 'newsletter-subscribers'.($status === 'all' ? '' : '-'.$status).'.csv';

        return response()->streamDownload(function () use ($subscribers) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['Email']);

            foreach ($subscribers as $subscriber) {
                fputcsv($file, [$subscriber->email]);
            }

            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function status(Request $request): string
    {
        $status = $request->query('status', 'all');

        return in_array($status, ['all', 'confirmed', 'pending', 'unsubscribed'], true)
            ? $status
            : 'all';
    }
}
