@extends('master')

@section('title', 'View Student Details')

@section('head-extra')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">

@endsection

@section('content')
    <div style="margin-top: 100px;">
        <h1 style="text-align: center; margin-top: 0;">Student Profile</h1>

        <div class="card mb-3" style="max-width: 600px; margin: auto;">
            <div class="row g-0">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/' . $user->student_img) }}"
                         class="img-fluid rounded-start"
                         alt="Profile Image"
                         style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <p><strong>Full Name:</strong> {{ $user->full_name }}</p>
                        <p><strong>Username:</strong> {{ $user->user_name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone }}</p>
                        <p><strong>WhatsApp:</strong> {{ $user->whatsup_number }}</p>
                        <p><strong>Address:</strong> {{ $user->address }}</p>
                        <p><strong>User Role:</strong> {{ ucfirst($user->user_role) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection
