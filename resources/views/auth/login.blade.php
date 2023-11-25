@extends('layouts.app')

@section('content')
    <login-component url_login="{{ route('login') }}" csrf_token="{{ @csrf_token() }}" />
@endsection
