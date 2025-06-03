@extends('layouts')

@section('content')
<h2>{{ __('Create Contact') }}</h2>
<form action="{{ route('contacts.import') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>{{ _('Upload XML File') }}</label>
        <input type="file" name="xmlfile" class="form-control" required accept="text/xml" >
        @if ($errors->has('xmlfile'))
            <span class="text-danger">{{ $errors->first('xmlfile') }}</span>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
</form>
@endsection
