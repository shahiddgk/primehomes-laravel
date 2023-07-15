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
                My Profile
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
         
          </li>
         
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>