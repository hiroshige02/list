@extends('errors.minimal')

@section('title'){{ $message }}@endsection
@section('code') {{ $status_code ?? '500' }} @endsection

@section('message')
{{ $message }}
@endsection
