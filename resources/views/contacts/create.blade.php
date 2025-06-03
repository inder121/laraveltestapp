@extends('layouts')

@section('content')
<h2>{{ __('Create Contact') }}</h2>
<form action="{{ route('contacts.store') }}" method="post">
    @csrf
    <div class="mb-3">
        <label>{{ _('Name') }}</label>
        <input type="text" name="name" class="form-control" required>
        @if ($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
        @endif
    </div>
    <div class="mb-3">
        <label>{{ __('Phone') }}</label>
        <input type="text" name="phone" class="form-control" required>
        @if ($errors->has('phone'))
            <span class="text-danger">{{ $errors->first('phone') }}</span>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
</form>
@endsection
