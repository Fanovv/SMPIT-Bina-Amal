@extends('layouts.app')

@section('main')

<div class="main-content">
    <section class="section">
        
            <div class="card">
                <div class="card-header">
                    {{ __('Dashboard') }}
                    <br/>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in as ') }} 
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-primary">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Manage Users</h4>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{route('users.index')}}">
                                            <button class="btn btn-primary">Edit Users</button>
                                        </a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-warning">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Manage Siswa</h4>
                                    </div>
                                    <div class="card-body">
                                        <button class="btn btn-warning">Edit Siswa</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>

                <div class="card-footer">
                    <form action="{{route("logout")}}" method="GET">
                        @csrf
                        <button class="btn btn-danger" style="cursor:pointer">Sign Out</button>
                       </form>
                </div>
            </div>
    </section>
</div>
@endsection
