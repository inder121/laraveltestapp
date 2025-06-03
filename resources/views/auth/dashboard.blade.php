@extends('layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Dashboard')}}</div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @else
                    <div class="alert alert-success">
                        {{ __('You are logged in!') }}
                    </div>       
                @endif                
            </div>
        </div>
    </div>    
</div>
    
@endsection
