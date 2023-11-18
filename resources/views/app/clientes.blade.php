@extends('layouts.app')

@section('content')
    <clientes-component base_url="{{ config('app.url') }}" />
@endsection
