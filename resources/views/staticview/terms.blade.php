@extends('layouts.app')
@section('pageHeaders')
    <title>{{ trans('home.rapletTerms') }}</title>
@endsection
@section('content')
    <div class="container">
            {!! $ruleContent !!}
    </div>
@endsection