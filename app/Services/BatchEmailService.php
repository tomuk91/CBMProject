<?php

namespace App\Services;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Resend\Client;

class BatchEmailService
{
    /**
     * Maximum number of emails per batch (Resend API limit is 100).
     */
    const BATCH_SIZE = 100;

    protected Client $resend;

    public function __construct(Client $resend)
    {
        $this->resend = $resend;
    }

    /**
     * Send an array of emails using the Resend batch API.
     *
     * Each item in $emails should be an associative array with:
     *   - 'to'      => string (recipient email address)
     *   - 'mailable' => Mailable instance
     *
     * Returns ['sent' => int, 'failed' => int].
     */
    public function sendBatch(array $emails): array
    {
        $sent = 0;
        $failed = 0;

        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');
        $from = "{$fromName} <{$fromAddress}>";

        // Build payload array with rendered HTML for each email
        $payloads = [];
        foreach ($emails as $email) {
            try {
                /** @var Mailable $mailable */
                $mailable = $email['mailable'];
                $to = $email['to'];

                // Render the mailable to get subject and HTML
                $rendered = $mailable->render();
                $subject = $mailable->envelope()->subject;

                $payloads[] = [
                    'from' => $from,
                    'to' => [$to],
                    'subject' => $subject,
                    'html' => $rendered,
                ];
            } catch (\Exception $e) {
                Log::error("BatchEmailService: Failed to render email for {$email['to']}: " . $e->getMessage());
                $failed++;
            }
        }

        // Send in chunks of BATCH_SIZE
        $chunks = array_chunk($payloads, self::BATCH_SIZE);

        foreach ($chunks as $chunk) {
            try {
                $this->resend->batch->send($chunk);
                $sent += count($chunk);
            } catch (\Exception $e) {
                Log::error('BatchEmailService: Batch send failed: ' . $e->getMessage());
                $failed += count($chunk);
            }
        }

        return ['sent' => $sent, 'failed' => $failed];
    }
}
