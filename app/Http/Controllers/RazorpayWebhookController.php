<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentSetting;
use App\Traits\FinalizesOrderPayment;
use Illuminate\Http\Request;

class RazorpayWebhookController extends Controller
{
    use FinalizesOrderPayment;

    private const TAG = '[RZP-WEBHOOK]';

    public function handle(Request $request)
    {
        $body = $request->getContent();
        $signature = (string) $request->header('X-Razorpay-Signature');

        // STEP 1: request aayi
        \Log::info(self::TAG . ' 1. Request received', [
            'event' => $request->input('event'),
            'ip' => $request->ip(),
            'body_length' => strlen($body),
            'has_signature' => $signature !== '',
            'razorpay_event_id' => $request->header('X-Razorpay-Event-Id'),
        ]);

        // STEP 2: secret load
        $setting = PaymentSetting::first();
        $mode = $setting?->live_mode ? 'live' : 'test';
        $secret = $setting?->live_mode ? $setting->live_webhook_secret : $setting?->test_webhook_secret;

        \Log::info(self::TAG . ' 2. Settings loaded', [
            'mode' => $mode,
            'settings_row_found' => (bool) $setting,
            'secret_configured' => !empty($secret),
        ]);

        if (!$secret || !$signature) {
            \Log::warning(self::TAG . ' 2x. Secret or signature missing', [
                'mode' => $mode,
                'secret_configured' => !empty($secret),
                'has_signature' => $signature !== '',
            ]);
            return response()->json(['message' => 'Not configured'], 400);
        }

        // STEP 3: signature verify
        if (!hash_equals(hash_hmac('sha256', $body, $secret), $signature)) {
            \Log::warning(self::TAG . ' 3x. Invalid signature (secret dashboard se match nahi karta ya mode galat hai)', [
                'mode' => $mode,
                'body_length' => strlen($body),
            ]);
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        \Log::info(self::TAG . ' 3. Signature verified', ['mode' => $mode]);

        // STEP 4: payload parse
        $event = $request->input('event');
        $payment = $request->input('payload.payment.entity', []);
        $rzpOrderId = $payment['order_id'] ?? $request->input('payload.order.entity.id');

        \Log::info(self::TAG . ' 4. Payload parsed', [
            'event' => $event,
            'razorpay_order_id' => $rzpOrderId,
            'razorpay_payment_id' => $payment['id'] ?? null,
            'payment_status' => $payment['status'] ?? null,
            'payment_method' => $payment['method'] ?? null,
            'amount_paise' => $payment['amount'] ?? null,
        ]);

        if (!$rzpOrderId) {
            \Log::warning(self::TAG . ' 4x. No razorpay order id in payload, ignored', ['event' => $event]);
            return response()->json(['message' => 'ignored']);
        }

        // STEP 5: order lookup
        $order = Order::where('razorpay_order_id', $rzpOrderId)->first();

        if (!$order) {
            \Log::warning(self::TAG . ' 5x. Order not found', [
                'razorpay_order_id' => $rzpOrderId,
                'event' => $event,
            ]);
            return response()->json(['message' => 'order not found']); // 200 so Razorpay stops retrying
        }

        \Log::info(self::TAG . ' 5. Order found', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'payment_status' => $order->payment_status,
            'order_status' => $order->status,
            'grand_total' => $order->grand_total,
        ]);

        // STEP 6: event handle
        try {
            switch ($event) {
                case 'payment.captured':
                case 'order.paid':
                    \Log::info(self::TAG . ' 6. Handling paid event', [
                        'event' => $event,
                        'order_id' => $order->id,
                    ]);

                    // Amount must match what we asked Razorpay to charge
                    $expected = (int) round($order->grand_total * 100);

                    if (isset($payment['amount']) && (int) $payment['amount'] !== $expected) {
                        \Log::warning(self::TAG . ' 6x. Amount mismatch, order NOT marked paid', [
                            'order_id' => $order->id,
                            'expected_paise' => $expected,
                            'received_paise' => (int) $payment['amount'],
                        ]);

                        $this->logPayment([
                            'order_id' => $order->id,
                            'order_number' => $order->order_number,
                            'gateway' => 'razorpay',
                            'payment_id' => $payment['id'] ?? null,
                            'amount' => ($payment['amount'] ?? 0) / 100,
                            'method' => $payment['method'] ?? null,
                            'status' => 'failed',
                            'error_message' => 'Webhook amount mismatch',
                        ]);
                        break;
                    }

                    if ($order->payment_status === 'paid') {
                        \Log::info(self::TAG . ' 6a. Order already paid (browser callback ya pehla event), skipping', [
                            'order_id' => $order->id,
                            'event' => $event,
                        ]);
                        break;
                    }

                    \Log::info(self::TAG . ' 6b. Finalizing payment', [
                        'order_id' => $order->id,
                        'razorpay_payment_id' => $payment['id'] ?? null,
                    ]);

                    $processed = $this->finalizeRazorpayPayment(
                        $order->id,
                        $payment['id'] ?? '',
                        null,
                        'Razorpay Webhook'
                    );

                    if ($processed) {
                        \Log::info(self::TAG . ' 6c. Order marked PAID by webhook', [
                            'order_id' => $processed->id,
                            'order_number' => $processed->order_number,
                        ]);
                    } else {
                        \Log::info(self::TAG . ' 6c. Already paid by another request (lock check), nothing done', [
                            'order_id' => $order->id,
                        ]);
                    }
                    break;

                case 'payment.failed':
                    \Log::info(self::TAG . ' 6. Handling payment.failed', [
                        'order_id' => $order->id,
                        'error_code' => $payment['error_code'] ?? null,
                        'error_description' => $payment['error_description'] ?? null,
                    ]);

                    if ($order->payment_status !== 'paid') {
                        $this->logPayment([
                            'order_id' => $order->id,
                            'order_number' => $order->order_number,
                            'gateway' => 'razorpay',
                            'payment_id' => $payment['id'] ?? null,
                            'amount' => $order->grand_total,
                            'method' => $payment['method'] ?? 'razorpay',
                            'status' => 'failed',
                            'customer_name' => $order->customer_name,
                            'customer_email' => $order->customer_email,
                            'error_message' => $payment['error_description'] ?? 'Payment failed',
                            'meta' => !empty($payment['error_code']) ? ['error_code' => $payment['error_code']] : null,
                        ]);

                        \Log::info(self::TAG . ' 6a. Failed payment logged in payment_logs', [
                            'order_id' => $order->id,
                        ]);
                    } else {
                        \Log::info(self::TAG . ' 6a. Order already paid, failed event ignored', [
                            'order_id' => $order->id,
                        ]);
                    }
                    break;

                default:
                    \Log::info(self::TAG . ' 6. Event not handled, ignored', ['event' => $event]);
                    break;
            }
        } catch (\Throwable $e) {
            \Log::error(self::TAG . ' 6x. Exception while processing', [
                'event' => $event,
                'order_id' => $order->id,
                'message' => $e->getMessage(),
                'file' => $e->getFile() . ':' . $e->getLine(),
            ]);
            return response()->json(['message' => 'error'], 500); // Razorpay will retry
        }

        // STEP 7: done
        \Log::info(self::TAG . ' 7. Done, responding 200', [
            'event' => $event,
            'order_id' => $order->id,
        ]);

        return response()->json(['message' => 'ok']);
    }
}