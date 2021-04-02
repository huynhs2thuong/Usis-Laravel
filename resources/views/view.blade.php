@extends('layouts.app')

@section('content')
    @foreach($datas as $k => $data)
        <p><strong>{{ $k }}</strong> :
        @if(is_array($data))
        </p>
            @foreach($data as $k_ => $_d)
                @if(is_array($_d))
                    @foreach($_d as $_k => $_da)
                    <p style="padding-left: 20px">- <strong>{{ $_k }}</strong> : {{ $_da }}</p>
                    @endforeach
                @else
                    <p style="padding-left: 20px">- <strong>{{ $k_ }}</strong> : {{ $_d }}</p>
                @endif
            @endforeach
        @else
            {{ $data }}</p>
        @endif
    @endforeach
@endsection
