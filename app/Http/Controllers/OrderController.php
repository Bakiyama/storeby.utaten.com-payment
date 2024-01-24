<?php

namespace App\Http\Controllers;

use App\Models\{
    Order,
    OrderDetail
};
use App\Enums\OrderStatus;
use App\Services\SbpsLinkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $now = now();

        $subtotal = rand(10, 99) * 100;
        $tax = $subtotal / 10;
        $shipping_charge = rand(10, 99) * 10;

        try {
            DB::beginTransaction();

            $now = now();

            $order = Order::create([
                'user_id' => 1, // TODO@ Store logged-in user's id column value
                'status' => OrderStatus::OPEN,
                'subtotal' => $subtotal, // TODO@ Calculate requested parameter
                'tax_rate' => 10,
                'tax' => $tax, // TODO@ Calculate requested parameter
                'shipping_charge' => $shipping_charge, // TODO@ Calculate requested parameter
                'shipping_charge_tax' => 0, // TODO@ Calculate requested parameter
                'total_amount' => $subtotal + $tax + $shipping_charge, // TODO@ Calculate requested parameter
                'paid_at' => $now,
                'orderer_name' => fake()->name(), // TODO@ Store requested parameter
                'orderer_name_kana' => fake()->kanaName(), // TODO@ Store requested parameter
                'orderer_prefecture' => rand(1, 47), // TODO@ Store requested parameter
                'orderer_city' => fake()->city(), // TODO@ Store requested parameter
                'orderer_address' => fake()->streetAddress() . fake()->secondaryAddress(), // TODO@ Store requested parameter
                'orderer_tel' => fake()->phoneNumber(), // TODO@ Store requested parameter
                'payment_method' => $request->payment_method,
                'order_date' => $now->format('Y-m-d'),
                'transaction_id' => Str::random(30),
            ]);

            $order_detail_count = rand(1, 5);

            $price_total = 0;

            for ($i=1; $i<=$order_detail_count; $i++) {
                /** 
                 * Calculate example price per product_variation.
                 * This process is not required in actual development.
                 */
                if ($i < $order_detail_count) {
                    $price = floor($subtotal / $order_detail_count);
                    $price_total += $price;
                } else {
                    $price = $subtotal - $price_total;
                }

                $order_detail = OrderDetail::create([
                    'order_id' => $order->id,
                    'product_variation_id' => rand(1, 10), // TODO@ Store request product_variation's id column value
                    'product_name' => fake()->word(), // TODO@ Store request product's name column value
                    'variation_name' => fake()->word(), // TODO@ Store request product_variation's name column value
                    'description' => fake()->text(), // TODO@ Store requested parameter
                    'quantity' => rand(1, 10), // TODO@ Store requested parameter
                    'price' => $price,
                ]);
            }

            $sbps_link_service = new SbpsLinkService($request->payment_method);

            $success_url = route('orders.complete', [$order]);
            $error_url = route('orders.fail', [$order]);
            $cancel_url = route('orders.cancel');
            $pagecon_url = route('api.orders.update-status');

            if (config('app.env') === 'local') {
                $ngrok_test_domain = 'javelin-liked-primate.ngrok-free.app';

                $success_url = "https://{$ngrok_test_domain}" . parse_url($success_url)['path'];
                $error_url = "https://{$ngrok_test_domain}" . parse_url($error_url)['path'];
                $cancel_url = "https://{$ngrok_test_domain}" . parse_url($cancel_url)['path'];
                $pagecon_url = "https://{$ngrok_test_domain}" . parse_url($pagecon_url)['path'];
            }

            $sbps_link_params = $sbps_link_service->createParams([
                'cust_code' => $order->user_id,
                'order_id' => $order->transaction_id,
                'item_id' => $order->id,
                'item_name' => 'STORE by UtaTen 商品購入',
                'amount' => $order->total_amount,
                'success_url' => $success_url,
                'error_url' => $error_url,
                'cancel_url' => $cancel_url,
                'pagecon_url' => $pagecon_url,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->view('orders.post-sbps', [
                'request_url' => $sbps_link_service->url,
                'params' => $sbps_link_params,
            ])
            ->header('Content-Type', 'text/html; charset=Shift_JIS');
    }

    public function complete(Request $request, Order $order)
    {
        /**
         * Determine logged-in user
         * If user are not logged-in, just display message that means payment process completed
         */
        $order->load('orderDetails');

        return view('orders.complete', [
            'order' => $order,
        ]);
    }

    public function fail(Request $request, Order $order)
    {
        return view('orders.fail', [
            'failure_reason' => $order->failure_reason,
        ]);
    }

    public function cancel(Request $request)
    {
        return view('orders.cancel');
    }
}
