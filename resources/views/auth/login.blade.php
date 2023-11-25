@extends('layouts.app')

@section('content')
    <login-component base_url="{{ config('app.url') }}" csrf_token="{{ @csrf_token() }}" />
@endsection
