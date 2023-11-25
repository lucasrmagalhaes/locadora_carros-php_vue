@extends('layouts.app')

@section('content')
    <login-component base_url="{{ url('/') }}" csrf_token="{{ @csrf_token() }}" />
@endsection
