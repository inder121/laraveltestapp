@extends('layouts')

@section('content')
    <div class="my-3">
        <span>{{ __('Name:') }}</span>
        <span>{{ $contact->name }}</span>
    </div>
    <div class="mb-3">
        <span>{{ __('Phone:') }}</span>
        <span>{{ $contact->phone }}</span>
    </div>
@endsection
