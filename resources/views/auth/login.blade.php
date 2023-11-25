@extends('layouts.app')

@section('content')
    <login-component base_url="{{ route('login') }}" csrf_token="{{ @csrf_token() }}" />
@endsection
