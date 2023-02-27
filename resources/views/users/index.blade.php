@extends("layouts.app")

@section("title") Users List @endsection

@section("main")

<div class="main-content">
    <section class="section">
        
        <div class="card">
            <div class="card-header">{{ __('User List') }}</div>

                <div class="card-body">

                    <a href="{{route('users.create')}}">
                        <button class="btn btn-primary">Create User</button>
                    </a>
                    <br/>

                    <table class="table table-bordered">
                        <thead>
                            <th><b>Name</b></th>
                            <th><b>Email</b></th>
                            <th><b>Level</b></th>
                            <th><b>Action</b></th>
                        </thead>

                        <tbody>
                            @foreach ($users as $user )

                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->level }}</td>
                                    <td>[TODO: actions]</td>
                                </tr>
                        
                            @endforeach
                        </tbody>

                    </table>
                
                </div>
            </div>
        </div>


@endsection