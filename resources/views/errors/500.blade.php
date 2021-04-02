@extends('layouts.app')
@push('scripts')
<style type="text/css">
   .title{font-size: 50px;text-align: center;padding: 50px 0;line-height: 50px} 
   h2{text-align: center;margin-bottom: 100px}
</style>
@endpush
@section('content')
        <div class="container">
            <div class="content">
                <div class="title">Sorry!<br />Something went wrong.</div>
                <h2>{{$e->getMessage()}}</h2>
            </div>
        </div>
@endsection
