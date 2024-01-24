@extends('layouts.default')

@section('content')
<h1>ご購入完了</h1>
<p>
    @if (!is_null($order))
    以下の注文番号で、ご注文が完了いたしました。<br>
    【注文番号】{{ $order->id }}
    @endif
    ご注文が完了いたしました。<br>
    <span style="color:red;">
    ご注文完了メールを送信しました。<br>
    特典会のシリアルコードや詳細はメールにてご確認ください。<br>
    なおシリアルコードはマイページでも確認ができます。<br>
    </span>
    商品のご到着まで今しばらくお待ちください。
</p>
@if (!is_null($order))
<div style="display: none;">
    <div id="GTM_ORDER_ID"><?= $order->id ?></div>
    <div id="GTM_ORDER_AFFILIATION">STORE by UtaTen</div>
    <div id="GTM_ORDER_REVENUE"><?= $order->total_amount ?></div>
    <div id="GTM_ORDER_SHIPPING"><?= $order->shipping_charge ?></div>
    <div id="GTM_ORDER_TAX"><?= $order->tax + $order->shipping_charge_tax ?></div>
    @foreach ($order->orderDetails as $order_detail)
    <div class="GTM_ORDER_ITEM">
        <div class="GTM_ORDER_ITEM_NAME">{{ $order_detail->product_name }}({{ $order_detail->variation_name }})</div>
        <div class="GTM_ORDER_ITEM_ID">{{ $order_detail->product_variation_id }}</div>
        {{-- ↓ 本実装時はproductsテーブルのカテゴリーを出力 ↓ --}}
        <div class="GTM_ORDER_ITEM_CATEGORY">test</div> 
        <div class="GTM_ORDER_ITEM_PRICE">{{ $order_detail->price }}</div>
        <div class="GTM_ORDER_ITEM_QUANTITY">{{ $order_detail->quantity }}</div>
    </div>
    @endforeach
</div>
@endif
@endsection

{{-- 本実装時にJSのdataLayer.pushで決済情報、商品情報のメタデータをGTMに送信する --}}