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

<<<<<<< HEAD
<<<<<<< HEAD
=======
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
        
>>>>>>> 938aa837b758ca12fdbc5bd4a2525c7933c96a87
        @role('Admin Quality')
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Quality Masters</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <li><a href="{{ route('quality.area.index') }}">Area</a></li>
              <li><a href="{{ route('quality.process.index') }}">Process</a></li>
              <li><a href="{{ route('quality.machine.index') }}">Machine</a></li>
              <li><a href="{{ route('quality.model.index') }}">Model</a></li>
              <li><a href="{{ route('quality.part.index') }}">Part</a></li>
              <li><a href="{{ route('quality.ngcategory.index') }}"><br/>NG Category</a></li>
            </ul>
          </li>
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Quality Checksheets</span> <span class="fa arrow"></span></a>

            <ul class="nav nav-second-level">
              <li><a href="{{ route('quality.monitor.index') }}">Monitoring</a></li>
            </ul>

          </li>  
        @endrole

        @role('User Quality')
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Quality Checksheets</span> <span class="fa arrow"></span></a>

            <ul class="nav nav-second-level">
              <li><a href="{{ route('quality.monitor.index') }}">Monitoring</a></li>
            </ul>

          </li>  
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Quality IPQC</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <li><a href="{{ route('quality.ipqc.index') }}">List</a></li>
              <li><a href="{{ route('quality.ipqc.create') }}">Create</a></li>
            </ul>
          </li>
        @endrole

        @role('Leader Quality')
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Quality IPQC</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <!-- <li><a href="{{ route('quality.monitor.index') }}">Monitoring</a></li> -->
              <li><a href="{{ route('quality.ipqc.index') }}">List</a></li>
              <li><a href="{{ route('quality.ipqc.leader_approval') }}">Leader Approval</a></li>
            </ul>
          </li>

        @endrole

        @role('Foreman Quality')
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Quality IPQC</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <li><a href="{{ route('quality.ipqc.index') }}">List</a></li>
              <li><a href="{{ route('quality.ipqc.leader_approval') }}">Foreman Approval</a></li>
            </ul>
          </li>  
        @endrole

        @role('Supervisor Quality')
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Quality IPQC</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <li><a href="{{ route('quality.ipqc.index') }}">List</a></li>
              <li><a href="{{ route('quality.ipqc.leader_approval') }}">Supervisor Approval</a></li>
            </ul>
          </li>  
        @endrole

        @role('Dept Head Quality')
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Quality IPQC</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <!-- <li><a href="{{ route('quality.monitor.index') }}">Monitoring</a></li>
              <li><a href="{{ route('quality.monitor.index') }}">Dept Head Approval</a></li> -->
              <li><a href="{{ route('quality.ipqc.index') }}">List</a></li>
              <li><a href="{{ route('quality.ipqc.leader_approval') }}">Dept Head Approval</a></li>
            </ul>
          </li>  
        @endrole

        @role('Director Quality')
          <li class="">
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Quality IPQC</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <li><a href="{{ route('quality.ipqc.index') }}">List</a></li>
              <li><a href="{{ route('quality.ipqc.leader_approval') }}">Director Approval</a></li>
            </ul>
          </li>  
        @endrole
<<<<<<< HEAD
=======
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
        
>>>>>>> delivery
=======
>>>>>>> 938aa837b758ca12fdbc5bd4a2525c7933c96a87
        
      @endauth 
    </ul>
  </div>
</nav>