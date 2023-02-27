@extends("layouts.app")

@section("title") Create User @endsection

@section("main")
    
<div class="main-content">
    <section class="section">

        <div class="col-md-8">

            @if(session('status'))
                <div class="alert alert-success">
                {{session('status')}}
                </div>
            @endif
            
            <div class="card">
                <div class="card-header">
                    <h3>Create User</h3>
                    
                </div>

                <div class="card-body">

                    <form 
                        enctype="multipart/form-data" class="bg-white shadow-sm p-3"
                        action="{{ route('users.store') }}" method="POST">
                        
                        @csrf

                        <label for="name">Nama</label>
                        <input
                        class="form-control"
                        placeholder="Name"
                        type="text"
                        name="name"
                        id="name"/>
                        <br>

                        <label for="level">
                            <span class=""> Select Level: </span>
                            <select class="block w-full mt-1" name="level">
                                <option value="admin">Admin</option>
                                <option value="tu">Tata Usaha</option>
                                <option value="bk">Guru BK</option>
                                <option value="wali">Wali Kelas/Wali Asrama</option>
                                <option value="guru">Guru/Staff</option>
                            </select>
                        </label>
                        <br/>

                        <label for="email">Email</label>
                        <input
                        class="form-control"
                        placeholder="user@mail.com"
                        type="text"
                        name="email"
                        id="email"/>
                        <br>

                        <label for="password">Password</label>
                        <input
                        class="form-control"
                        placeholder="password"
                        type="password"
                        name="password"
                        id="password"/>
                        <br>

                        <label for="password_confirmation">Password Confirmation</label>
                        <input
                        class="form-control"
                        placeholder="password confirmation"
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"/>
                        <br>

                        <input
                            class="btn btn-primary"
                            type="submit"
                            value="Save"/>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection