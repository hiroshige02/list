@extends('errors.minimal')

@section('title'){{ $message }}@endsection
@section('code') {{ $status_code ?? '404' }} @endsection
@section('message') {{ $message }} @endsection
