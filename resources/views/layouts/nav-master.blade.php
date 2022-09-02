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
                {{-- {{auth()->user()->npk}}  --}}
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
          <li >
              <a href="#" aria-expanded="true"><i class="fa fa-truck"></i> <span class="nav-label">Delivery </span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level " aria-expanded="true" style="">
                  <li class="">
                    <a href="#" aria-expanded="true">Dashboard<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level " aria-expanded="true" style="">
                      <li><a href="{{route('delivery.dashboard')}}"> Shipment Operation Diagram</a></li>
                      <li><a href="{{route('delivery.all.graph')}}"> Dashboard All</a></li>
                    </ul>
                  </li>
                  <li class="">
                    <a href="#" aria-expanded="true">Henkaten<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level " aria-expanded="true" style="">
                      <li><a href="{{route('delivery.skillmatrix')}}"> Matrix</a></li>
                      <li><a href="{{route('delivery.planning_refreshment')}}"> Planning Refreshment</a></li>
                      <li><a href="{{route('delivery.layout_area')}}"> Layout Area</a></li>
                      <li><a href="{{route('delivery.henkaten_detail')}}"> History</a></li>
                    </ul>
                  </li>
                  <li class="">
                      <a href="#" aria-expanded="true">Master Data <span class="fa arrow"></span></a>
                      <ul class="nav nav-third-level " aria-expanded="true" style="">
                        <li><a href="{{route('delivery.master.master_part')}}">Part</a></li>
                        <li><a href="{{route('delivery.master.master_packaging')}}">Packaging</a></li>
                        <li><a href="{{route('delivery.master.master_line')}}">Line</a></li>
                        <li><a href="{{route('delivery.master.master_customer')}}">Customer </a></li>
                        <li><a href="{{route('delivery.master.master_partcard')}}">Part Card </a></li>
                        <li><a href="{{route('delivery.master.master_manpower')}}">Man Power </a></li>
                        <li><a href="{{route('delivery.skills')}}"> Skill </a></li>
                      </ul>
                    </li>
                    <li class="">
                      <a href="#" aria-expanded="true">Preparation & Delivery<span class="fa arrow"></span></a>
                      <ul class="nav nav-third-level " aria-expanded="true" style="">
                        <li><a href="{{route('delivery.pickupcustomer')}}"> Reference Data</a></li>
                        <li><a href="{{route('delivery.preparation')}}">Schedule </a></li>
                      </ul>
                    </li>
                    <li class="">
                      <a href="#" aria-expanded="true">Claim <span class="fa arrow"></span></a>
                      <ul class="nav nav-third-level " aria-expanded="true" style="">
                        <li><a href="{{route('delivery.claim.claim')}}">List Claim</a></li>
                        {{-- <li><a href="#">  Dashboard</a></li> --}}
                      </ul>
                    </li>
                    <li class="">
                      <a href="#" aria-expanded="true">Delivery note<span class="fa arrow"></span></a>
                      <ul class="nav nav-third-level " aria-expanded="true" style="">
                        <li><a href="{{route('delivery.delivery_note')}}">List Delivery Note</a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
        @endrole
        @role('delivery.preparation.member')
                <li >
                  <a href="#" aria-expanded="true"><i class="fa fa-truck"></i> <span class="nav-label">Delivery</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level " aria-expanded="true" style="">
                  <li><a href="{{route('delivery.preparation.member')}}">Preparation</a></li>
                </ul>
            </li>
        @endrole
        @role('security')
              <li >
                  <a href="#" aria-expanded="true"><i class="fa fa-truck"></i> <span class="nav-label">Delivery</span><span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level " aria-expanded="true" style="">
                    <li><a href="{{route('delivery.preparation.security')}}">Arrival & Departure</a></li>
                    <li><a href="{{route('delivery.preparation.security.history')}}">History</a></li>
                  </ul>
              </li>
        @endrole
        
        
      @endauth 
    </ul>
  </div>
</nav>