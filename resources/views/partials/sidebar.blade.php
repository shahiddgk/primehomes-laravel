<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{URL('/home')}}" class="brand-link">
      
      <span class="brand-text font-weight-light">PRIMEHOMES PORTAL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

   

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ URL('/home') }}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
           
          </li>
         
          <li class="nav-header">General</li>
          
          <li class="nav-item {{ Request::segment(1) === 'owners' || (Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Owners') ? 'menu-open' : null }}">
            <a href="#" class="nav-link {{ Request::segment(1) === 'owners' || (Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Owner') ? 'active' : null }}">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                Owners
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('owners.create') }}" class="nav-link {{ Request::segment(1) === 'owners' && Request::segment(2) === 'create' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ route('owners.index') }}" class="nav-link {{ Request::segment(1) === 'owners' && Request::segment(2) === 'show' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Show</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ URL('activity_log/Owners') }}" class="nav-link {{ Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Owners' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Activity Log</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Request::segment(1) === 'tenants' || (Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Tenants') ? 'menu-open' : null }}">
            <a href="#" class="nav-link {{ Request::segment(1) === 'tenants' || (Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Tenants') ? 'active' : null }}">
              <i class="nav-icon fas fa-door-open"></i>
           
              <p>
                Tenants
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('tenants.create') }}" class="nav-link {{ (request()->is('tenants.create')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ route('tenants.index') }}" class="nav-link {{ (request()->is('tenants.index')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Show</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('activity_log/Tenants') }}" class="nav-link {{ Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Tenants' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Activity Log</p>
                </a>
              </li>
            </ul>
          </li>
         
          <li class="nav-item {{ Request::segment(1) === 'units'  || (Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Units')? 'menu-open' : null }}">
            <a href="#" class="nav-link {{ Request::segment(1) === 'units' || (Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Units') ? 'active' : null }}">
              <i class="nav-icon fas fa-grip-horizontal"></i>
              
              <p>
                Units
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('units.create') }}" class="nav-link {{ Request::segment(1) === 'units' && Request::segment(2) === 'create' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ route('units.index') }}" class="nav-link {{ (request()->is('units')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Show</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ URL('activity_log/Units') }}" class="nav-link {{ Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Units' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Activity Log</p>
                </a>
              </li>
            </ul>
            
          </li>
          <li class="nav-header">Lease & Billings</li>
          
          <li class="nav-item {{ Request::segment(1) === 'leases' ? 'menu-open' : null }}">
            <a href="#" class="nav-link {{ Request::segment(1) === 'leases' ? 'active' : null }}">
              <i class="nav-icon fas fa-award"></i>
           
              <p>
                Lease Profiling
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('leases.create')}}" class="nav-link {{ Request::segment(1) === 'leases' && Request::segment(2) === 'create'  ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{route('leases.index')}}" class="nav-link {{ Request::segment(1) === 'leases' && Request::segment(2) === 'index' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Show</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item {{ Request::segment(1) === 'leasese' ? 'menu-open' : null }}">
            <a href="#" class="nav-link {{ Request::segment(1) === 'leasees' ? 'active' : null }}">
            <i class="nav-icon fas fa-sync-alt fa-spin"></i>
           
              <p>
                Billings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('billings.create')}}" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Billing</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="" class="nav-link }">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Water Readings</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link }">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Voilation Charges</p>
                </a>
              </li> -->
              <li class="nav-item">
              <a href="{{route('billings.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Invoices</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-header">Settings</li>
          <li class="nav-item {{ Request::segment(1) === 'projects' || (Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Buildings') ? 'menu-open' : null }}">
            <a href="#" class="nav-link {{ Request::segment(1) === 'projects' || (Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Buildings') ? 'active' : null }}">
              
              <i class="nav-icon far fa-building"></i>
              <p>
                Manage Buildings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('projects.create') }}" class="nav-link {{ Request::segment(1) === 'projects' && Request::segment(2) === 'create' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ route('projects.index') }}" class="nav-link {{ (request()->is('projects')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Show</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ URL('activity_log/Buildings') }}" class="nav-link {{ Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Owner' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Activity Log</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ Request::segment(1) === 'amenities' ? 'menu-open' : null }}">
            <a href="#" class="nav-link {{ Request::segment(1) === 'amenities' ? 'active' : null }}">
              
              <i class="nav-icon fas fa-bath"></i>
              <p>
                Manage Amenities
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('amenities.create') }}" class="nav-link {{ Request::segment(1) === 'amenities' && Request::segment(2) === 'create' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ route('amenities.index') }}" class="nav-link {{ (request()->is('amenities')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Show</p>
                </a>
              </li>
            
            </ul>
          </li>
          
          <li class="nav-item {{ Request::segment(1) === 'users' || (Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Users') ? 'menu-open' : null }}">
            <a href="#" class="nav-link {{ Request::segment(1) === 'users' || (Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Users') ? 'active' : null }}">
              
              <i class="nav-icon fas fa-users"></i>
              <p>
              Manage Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users.create') }}" class="nav-link {{ Request::segment(1) === 'users' && Request::segment(2) === 'create' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ route('users.index') }}" class="nav-link {{ (request()->is('users')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Show</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ URL('activity_log/Users') }}" class="nav-link {{ Request::segment(1) === 'activity_log' &&  Request::segment(2) === 'Users' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Activity Log</p>
                </a>
              </li>
            </ul>
          </li>

         
          <li class="nav-item {{ Request::segment(1) === 'roles' ? 'menu-open' : null }}">
            <a href="#" class="nav-link {{ Request::segment(1) === 'roles' ? 'active' : null }}">
              
              <i class="nav-icon fas fa-user-secret"></i>
              <p>
              Manage roles
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('roles.create') }}" class="nav-link {{ Request::segment(1) === 'roles' && Request::segment(2) === 'create' ? 'active' : null }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ route('roles.index') }}" class="nav-link {{ (request()->is('roles')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Show</p>
                </a>
              </li>
            </ul>
          </li>
        
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>