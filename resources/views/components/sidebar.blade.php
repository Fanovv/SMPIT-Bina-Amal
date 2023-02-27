<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="{{ URL::to('/assets/img/Logo-Bina-Amal.png') }}"
                alt="logo"
                width="50"
                class="shadow-light rounded-circle">
        </div>
       
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
                <a href="{{route('admin.dashboard')}}"
                    class="nav-link has-dropdown"><i class="fas fa-layout"></i><span>Dashboard</span></a>
                
            </li>
            <li class="menu-header">User</li>
                <a href="{{route('users.create')}}"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-user"></i> <span>Manager User</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('users.index') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{route('users.index')}}">User List</a>
                    </li>
                    <li class="{{ Request::is('users.create') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('users.create') }}">Create User</a>
                    </li>
            
                </ul>
            </li>
        </ul>

        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs"
                class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
