@extends('layouts.app', [
    'title' => 'Edit Topic',
    'heading' => 'Update seminar topic',
    'subheading' => 'Adjust the topic description and registration status.',
])

@section('content')
    {{-- Edit page reuses the same shared topic form. --}}
    @include('topics.partials.form', [
        'action' => route('topics.update', $topic),
        'method' => 'PUT',
        'topic' => $topic,
        'button' => 'Save changes',
        'lecturers' => $lecturers,
    ])
@endsection
