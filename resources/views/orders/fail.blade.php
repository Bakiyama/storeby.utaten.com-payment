@extends('layouts.default')

@section('content')
<h1>決済エラー</h1>
<p>
    決済が正常に完了しませんでした。<br>
    @if (is_null($failure_reason))
    時間を置いて再度お試し下さい。
    @else
    {{ $failure_reason }}
    @endif
</p>
@endsection