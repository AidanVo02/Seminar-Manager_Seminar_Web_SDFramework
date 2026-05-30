@extends('layouts.app', [
    'title' => 'Create User',
    'heading' => 'Create user account',
    'subheading' => 'Add a new admin, lecturer, or student account.',
])

@section('content')
    {{-- Create user page forwards to the shared form. --}}
    @include('users.form', [
        'action' => route('users.store'),
        'method' => 'POST',
        'user' => null,
        'button' => 'Create user',
    ])
@endsection
