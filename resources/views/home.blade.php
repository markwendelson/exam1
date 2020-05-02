@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Login Date</th>
                            <th>Status</th>
                        </tr>
                        <tr>
                            @foreach ($users as $user)
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td></td>
                            <td></td>
                            @endforeach
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
