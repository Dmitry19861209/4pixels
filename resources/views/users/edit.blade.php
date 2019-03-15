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
        <user-edit-component prop-user-id="{{ $userId  }}"
                             prop-token="{{ csrf_token() }}"></user-edit-component>
    </div>

@endsection
