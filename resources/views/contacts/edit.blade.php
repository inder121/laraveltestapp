@extends('layouts')

@section('content')
<h2>{{ __('Edit Contact') }}</h2>
<form action="{{ route('contacts.update', $contact) }}" method="post">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>{{ __('Name') }}</label>
        <input type="text" name="name" value="{{ $contact->name }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>{{ __('Phone') }}</label>
        <input type="text" name="phone" class="form-control" value="{{ $contact->phone }}" required>
    </div>
    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
</form>
@endsection
