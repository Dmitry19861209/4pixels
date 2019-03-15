@extends('layouts.app')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-header">Users</div>

    <div class="card-body table-responsive">
        <user-create-component prop-token="{{ csrf_token() }}"></user-create-component>
    </div>

@endsection
