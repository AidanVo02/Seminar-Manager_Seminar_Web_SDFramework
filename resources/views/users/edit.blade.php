@extends('layouts.app', [
    'title' => 'Edit User',
    'heading' => 'Edit user account',
    'subheading' => 'Update account details and role permissions.',
])

@section('content')
    {{-- Edit user page forwards to the shared form. --}}
    @include('users.form', [
        'action' => route('users.update', $user),
        'method' => 'PUT',
        'user' => $user,
        'button' => 'Save user',
    ])
@endsection
