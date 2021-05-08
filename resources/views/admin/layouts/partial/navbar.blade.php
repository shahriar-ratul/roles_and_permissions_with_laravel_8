<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('home')}}" class="nav-link">Home</a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>

          <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('img/avatar.jpg') }}" class="user-image img-circle elevation-2" alt="User Image">
              <span class="d-none d-md-inline"> {{auth()->user()->name}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- User image -->
              <li class="user-header bg-primary">
                <img src="{{ asset('img/avatar.jpg') }}" class="img-circle elevation-2" alt="User Image">

                <p>
                  {{auth()->user()->name}}
                  <small>Member since {{auth()->user()->create_account_time()}}</small>
                  <small>Account was created ({{auth()->user()->account_time()}})</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-md-12 text-center">
                    <a href="{{ route('userGetPassword') }}"><i class="fas fa-lock nav-icon"></i> Change Password</a>
                  </div>
                </div>
                <div class="row pt-md-3">
                  <div class="col-md-6 text-center">
                    <a href="#"><i class="fas fa-image nav-icon"></i> Photo</a>
                  </div>

                  <div class="col-md-6 text-center">
                    <a href="#">
                        <i class="fas fa-bell nav-icon"></i>
                        Notifications
                    </a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <a href="{{ route('user.profile') }}" class="btn btn-default text-dark"><i class="nav-icon fas fa-user"></i> Profile</a>
                <a href="{{ route('logout') }}" class="btn btn-default text-dark float-right" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <p>
                        <i class="nav-icon fas fa-power-off"></i>
                        Logout
                    </p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

              </li>
            </ul>
          </li>


    </ul>
</nav>
<!-- /.navbar -->
