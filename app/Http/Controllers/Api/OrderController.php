<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function updateStatus(Request $request)
    {
        $order = Order::where('transaction_id', $request->order_id)->first();

        $reason = '';
        $is_invalid_request = is_null($order) || $order->status->value !== OrderStatus::OPEN;

        if (is_null($order)) {
            $reason = "決済データが存在しません [transaction_id: {$request->order_id}]";
        } elseif ($order->status->value !== OrderStatus::OPEN) {
            $reason = "処理済みの決済データです [transaction_id: {$request->order_id}]";
        }

        if ($is_invalid_request) {
            $this->fail($reason);

            $response_text = "NG,{$reason}";
            \Log::channel('sbps_payment_error')->error('----- Response -----');
            \Log::channel('sbps_payment_error')->error($response_text);

            return response($response_text, 200)
                ->header('Content-type', 'text/plain');
        }

        try {
            if ($request->res_result !== 'OK') {
                throw new \Exception('決済失敗');
            }

            // TODO@ Verify Chekicha link
            // TODO@ Subtract product's quantity
            // TODO@ Remove all items in cart

            $order->payment_number = $request->res_tracking_id;
            $order->status = OrderStatus::SUCCESS;
            $order->save();

            // TODO@ Send mail to announce payment process completed

            $response_text = 'OK,';

            \Log::channel('sbps_payment')->info('----- Response -----');
            \Log::channel('sbps_payment')->info($response_text);
        } catch (\Exception $e) {
            $reason = $e->getMessage();

            $this->fail($reason, $order);

            $response_text = "NG,{$reason}";
            \Log::channel('sbps_payment_error')->error('----- Response -----');
            \Log::channel('sbps_payment_error')->error($response_text);
        }

        return response($response_text, 200)
            ->header('Content-type', 'text/plain');
    }

    private function fail(string $reason, Order $order = null, bool $is_display_reason = false)
    {
        if (!is_null($order)) {
            if ($is_display_reason) {
                $order->failure_reason = $reason;
            }

            $order->status = OrderStatus::FAILED;
            $order->save();
        }

        if ($reason !== '') {
            \Log::channel('sbps_payment_error')->error("NG Reason: {$reason}");
        }
    }
}
