@extends('errors.minimal')

@section('title'){{ $title }}@endsection
@section('code') {{ $status_code ?? '500' }} @endsection
@section('message'){{ $title }} @endsection
