  <header class="main-header " >
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" style="font-size: 12px"><b>OC</b> ind</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"> <b>OneCare</b><span style="font-size: 75%"> Indonesia</span></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top bg-green disabled color-palette">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        {{-- nama --}}
    
          <!-- pengaturan -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              {{ Auth::user()->nama }}&nbsp;&nbsp;<i class="fa fa-gears"></i>
              {{-- <span class="label label-warning">10</span> --}}
            </a>
            <ul class="dropdown-menu success" style="width: 15%">
              <li class="header text-center">Pengaturan</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">                 
                  <li>
                    <a onclick="userUpdateProfil({{ Auth::user()->id}})" href="#">Profil
                      <i class="fa fa-address-card  pull-right"  aria-hidden="true"></i>
                    </a>
                  </li>
                  <li>
                    <a onclick="userUpdateEmail({{ Auth::user()->id}})"  href="#">Ubah Email
                      <i class="fa fa-user-secret  pull-right"  aria-hidden="true"></i>
                    </a>
                  </li> 
                  <li>
                    <a onclick="userUpdatePassword({{ Auth::user()->id}})" href="#">Ubah Password
                      <i class="fa fa-unlock  pull-right"  aria-hidden="true"></i>
                    </a>
                  </li>
                  <li>
                      <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                       Sign Out 
                      <i class="fa fa-sign-out text-red pull-right"  aria-hidden="true"></i>
                    </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

      
      {{-- //pengaturan --}}
{{--           <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> --}}

        </ul>
      </div>
    </nav>
  </header>