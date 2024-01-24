<?php

namespace App\Services;

use App\Enums\OrderPaymentMethod;

class SbpsLinkService
{
    public string $url;
    protected string $pay_method;
    protected array $config;

    public function __construct(string $payment_method)
    {
        if (in_array($payment_method, OrderPaymentMethod::getValues())) {
            $this->pay_method = OrderPaymentMethod::fromValue($payment_method)->getSbpsPayMethod();
        }

        $this->url = match (config('app.env')) {
            'production' => 'https://stbfep.sps-system.com/f01/FepBuyInfoReceive.do',
            default => 'https://stbfep.sps-system.com/Extra/BuyRequestAction.do',
        };

        $this->config = config('sbps');
    }

    public function createParams(array $params)
    {
        $query = array_merge(array(
            'pay_method' => $this->pay_method,
            'merchant_id' => $this->config['account_id'],
            'service_id' => $this->config['service']['key'],
            'cust_code' => '',
            'order_id' => '',
            'item_id' => '',
            'item_name' => '',
            'amount' => '',
            'pay_type' => 0,
            'auto_charge_type' => '',
            'service_type' => 0,
            'div_settele' => '',
            'camp_type' => '', // 0: キャンペーンなし, 1: 初月無料
            'tracking_id' => '',
            'success_url' => '',
            'cancel_url' => '',
            'error_url' => '',
            'pagecon_url' => '',
            'free1' => '',
            'free2' => '',
            'free3' => '',
            'request_date' => now()->format('YmdHis'),
            'sps_hashcode' => '',
        ), $params);

        $query['sps_hashcode'] = sha1(implode('', $query) . $this->config['service']['secret']);
        $query['item_name'] = mb_convert_encoding($query['item_name'], 'SJIS-win', 'UTF-8');

        return $query;
    }
}