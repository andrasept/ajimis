<nav class="navbar-default navbar-static-side" role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
      <li class="nav-header">
        <div class="dropdown profile-element">
          <img alt="image" class="rounded-circle" src="{{asset('image/user.png')}}"/>
          <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <span class="block m-t-xs font-bold">{{auth()->user()->name}}</span>
            <span class="text-muted text-xs block">
              @if (auth()->user()->department != null)
                {{auth()->user()->department->code}} 
              @endif
            </span>
          </a>
        </div>
        <div class="logo-element">AJI<b>MIS</b></div>
      </li>
      @auth

        @role('admin')
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Masters</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <li><a href="{{ route('departments.index') }}">Departments</a></li>
            </ul>
          </li>
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Access Control</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <li><a href="{{ route('users.index')}}">Users</a></li>
              <li><a href="{{ route('roles.index')}}">Roles</a></li>
              <li><a href="{{ route('permissions.index')}}">Permissions</a></li>
            </ul>
          </li>
          <li>
            <a href="{{ route('logs.index') }}"><i class="fa fa-th"></i> <span class="nav-label">Logs History</span></a>
          </li>   
        @endrole

        @role('user')
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Files</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <li><a href="{{ route('files.index')}}">Files</a></li>
              <li><a href="{{ route('files.alldept')}}">Files All Dept</a></li>
            </ul>
          </li>
          <li>
            <a href="{{ route('categories.index') }}"><i class="fa fa-th"></i> <span class="nav-label">Categories</span></a>
          </li> 
        @endrole

        @role('delivery.superadmin')
          <li>
            <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Master Data</span> <span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse" aria-expanded="false">
                  <li><a href="{{route('delivery.master.master_part')}}">Part</a></li>
                  {{-- <li><a href="">Part</a></li> --}}
                  <li><a href="{{route('delivery.master.master_packaging')}}">Packaging</a></li>
                  <li><a href="{{route('delivery.master.master_line')}}">Line</a></li>
                  <li><a href="{{route('delivery.master.master_customer')}}">Customer </a></li>
                  <li><a href="{{route('delivery.master.master_partcard')}}">Part Card </a></li>
                  {{-- <li><a href="#">Users </a></li>
                  <li><a href="#">Man Power </a></li> --}}
              </ul>
          </li>
        @endrole
        
      @endauth 
    </ul>
  </div>
</nav>