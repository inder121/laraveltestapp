@extends('layouts')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>{{ __('contact List') }}</h2>
</div>
<div class="d-flex justify-content-end mb-3">
    <a class="btn btn-primary mx-2" href="{{ route('contacts.uploadxml') }}">{{ __('Import Contacts') }}</a>
    <a class="btn btn-primary mx-2" href="{{ route('contacts.create') }}">{{ __('Add Contact') }}</a>
</div>


@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <tr>
        <th>{{ __('ID') }}</th>
        <th>{{ __('Name') }}</th>
        <th>{{ __('Phone') }}</th>
        <th>{{ __('Action') }}</th>
    </tr>
    @foreach ($contacts as $contact)
    <tr>
        <td>{{ $contact->id }}</td>
        <td>{{ $contact->name }}</td>
        <td>{{ $contact->phone }}</td>
        <td>
            <a class="btn btn-info btn-sm" href="{{ route('contacts.show', $contact) }}">{{ __('Show') }}</a>
            <a class="btn btn-warning btn-sm" href="{{ route('contacts.edit', $contact) }}">{{ __('Edit') }}</a>
            <form action="{{ route('contacts.destroy', $contact) }}" method="post" class="d-inline">
                @csrf 
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $contacts->links() }}
@endsection