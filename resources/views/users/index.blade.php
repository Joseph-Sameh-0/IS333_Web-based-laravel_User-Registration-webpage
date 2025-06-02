@extends('master')

@section('title', 'Index Users')

@section('head-extra')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')

    @if($message = Session::get('success'))

        <div class="alert alert-success">
            {{ $message }}
        </div>

    @endif

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6"><b>Student Data</b></div>
                <div class="col col-md-6">
                    <a href="{{ url('/') }}" class="btn btn-success btn-sm float-end">Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                @if(count($users) > 0)

                    @foreach($users as $row)

                        <tr>
                            <td><img src="{{ asset('images/' . $row->student_img) }}" width="75" /></td>
                            <td>{{ $row->user_name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->user_role }}</td>
                            <td>
                                <form method="post" action="{{ route('users.destroy', $row->student_id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('users.show', $row->student_id) }}" class="btn btn-primary btn-sm">View</a>
                                    <a href="{{ route('users.edit', $row->student_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <input type="submit" class="btn btn-danger btn-sm" value="Delete" />
                                </form>

                            </td>
                        </tr>

                    @endforeach

                @else
                    <tr>
                        <td colspan="5" class="text-center">No Data Found</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>

@endsection
