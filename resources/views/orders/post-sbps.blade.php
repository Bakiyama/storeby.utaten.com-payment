<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="Shift_JIS" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    </head>
    <body onload=document.forms[0].submit()>
        {{ Form::open(['url' => $request_url, 'method' => 'post', 'accept-charset' => 'Shift_JIS']) }}
            @foreach ($params as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{!! $value !!}">
            @endforeach
        {{ Form::close() }}
    </body>
</html>