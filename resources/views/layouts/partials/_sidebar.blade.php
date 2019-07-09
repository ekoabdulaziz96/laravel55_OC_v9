  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          @if (Auth::user()->foto != '-' )
            <img src="{{ Auth::user()->foto }}" class="img-circle" alt="User Image">
          @else
            <img src="#" class="pull-left"> <h6 style="color: white;font-size: 7pt"><br>belum<br>ada<br>foto</h6> 
          @endif
        </div>
        <div class="pull-left info active">
          {{-- <p>Alexander Pierce</p> --}}
          {{-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> --}}
          <p style="font-size: 18px"><u>{{ Auth::user()->nama }}</u></p>
          <small style="font-style: italic;"> 
             @if (Auth::user()->status == 'super_admin')
                  Super Admin
              @elseif (Auth::user()->status == 'ft_admin')
                  FT Admin
              @elseif (Auth::user()->status == 'ft_sponsorship')
                  FT Sponsorship
              @elseif (Auth::user()->status == 'ft_kacab')
                  FT Kepala Cabang                        
              @elseif (Auth::user()->status == 'manajer')
                  Manajer                        
              @elseif (Auth::user()->status == 'direktur')
                  Direktur                        
              @endif 
          </small>
        </div>
      </div>

      {{-- profil --}}
{{--       <div align="center" class="input-group-btn">
        <a href="" >
          <button class="btn btn-default">Profile</button>
        </a>
      </div> --}}
      <br>
      <!-- search form -->
{{--       <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> --}}
      <!-- /.search form -->

@if (Auth::user()->status =='super_admin')
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

          <li class=" " id="adminDashboard">
            <a href="{{ route('admin.index') }}">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
          </li>

         <li class="treeview" id="adminLaporan">
            <a href="#">
              <i class="fa fa-edit"></i> <span>Kelola Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview" id="acc_laporan"> 
                      <a href="#"><i class="fa fa-check-square-o"></i> Acc Laporan
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li id="acc_laporan_ft_admin"><a href="{{ route('admin.laporan-acc','ft_admin') }}"><i class="fa fa-user-o"></i>Laporan Ft Admin</a></li>
                        <li id="acc_laporan_ft_sponsorship"><a href="{{ route('admin.laporan-acc','ft_sponsorship') }}"><i class="fa fa-user-o"></i>Laporan Ft Sponsorship</a></li>
                        <li id="acc_laporan_ft_kacab"><a href="{{ route('admin.laporan-acc','ft_kacab') }}"><i class="fa fa-user-circle"></i>Laporan Ft Kepala Cabang</a></li>
                        <li id="acc_laporan_manajer"><a href="{{ route('admin.laporan-acc','manajer') }}"><i class="fa fa-user-circle-o"></i>Laporan Manajer</a></li>
                      </ul>
                </li>
                {{-- <li id="acc_laporan_individual"><a href="{{ route('admin.laporan-pilih') }}"><i class="fa fa-user-o"></i>Pantau individual </a></li>        --}}
                <li id="acc_laporan_karyawan"><a href="{{ route('admin.laporan-pilih-cabang') }}"><i class="fa fa-user-o"></i>Pantau Karyawan </a></li>
                 <li class="treeview" id="dl_laporan"> 
                      <a href="#"><i class="fa fa-check-square-o"></i> Acc Perpanjangan DL
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li id="dl_laporan_ft_admin"><a href="{{ route('admin.laporan-acc-deadline','ft_admin') }}"><i class="fa fa-user-o"></i>Laporan Ft Admin</a></li>
                        <li id="dl_laporan_ft_sponsorship"><a href="{{ route('admin.laporan-acc-deadline','ft_sponsorship') }}"><i class="fa fa-user-o"></i>Laporan Ft Sponsorship</a></li>
                        <li id="dl_laporan_ft_kacab"><a href="{{ route('admin.laporan-acc-deadline','ft_kacab') }}"><i class="fa fa-user-circle"></i>Laporan Ft Kepala Cabang</a></li>
                        <li id="dl_laporan_manajer"><a href="{{ route('admin.laporan-acc-deadline','manajer') }}"><i class="fa fa-user-circle-o"></i>Laporan Manajer</a></li>
                      </ul>
                </li>
            </ul>
          </li>

          <li class="treeview" id="adminForm">
            <a href="#">
              <i class="fa fa-edit"></i> <span>Kelola Form Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="ft_admin"><a href="{{ route('admin.form-pilih','ft_admin') }}"><i class="fa fa-user-o"></i>FT-Admin</a></li>
              <li id="ft_sponsorship"><a href="{{ route('admin.form-pilih','ft_sponsorship') }}"><i class="fa fa-user-o"></i>FT-Sponsorship</a></li>
              <li id="ft_kacab"><a href="{{ route('admin.form-pilih','ft_kacab') }}"><i class="fa fa-user-circle"></i>FT-Kepala Cabang</a></li>
              <li id="manajer"><a href="{{ route('admin.form-pilih','manajer') }}"><i class="fa fa-user-circle-o"></i>Manajer</a></li>
            </ul>
          </li>

          <li class=" " id="adminUser">
            <a href="{{ route('admin.user') }}">
              <i class="fa fa-user"></i> <span>Kelola User</span>
            </a>
          </li>          

          <li class=" " id="adminCabang">
            <a href="{{ route('admin.cabang') }}">
              <i class="fa fa-arrows"></i> <span>Kelola Cabang</span>
            </a>
          </li>          
          <li class=" " id="adminPengumuman">
            <a href="{{ route('admin.pengumuman') }}">
              <i class="fa fa-bell-o"></i> <span>Kelola Pengumuman</span>
            </a>
          </li>
    </ul>
@elseif (Auth::user()->status =='ft_admin')
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
          <li class=" " id="ftAdminDashboard">
            <a href="{{ route('ft-admin.index',Auth::user()->id) }}">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>

         <li class="treeview" id="ftAdminLaporan">
            <a href="#">
              <i class="fa fa-edit"></i> <span>Kelola Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="ftAdminLaporan_baru"><a href="{{ route('ft-admin.laporan-status',[Auth::user()->id,'baru']) }}"><i class="fa fa-pencil-square-o"></i>Laporan Baru</a></li>        
               <li id="ftAdminLaporan_proses"><a href="{{ route('ft-admin.laporan-status',[Auth::user()->id,'proses']) }}"><i class="fa fa-paper-plane-o"></i>Proses Persetujuan</a></li>
              <li id="ftAdminLaporan_perbaikan"><a href="{{ route('ft-admin.laporan-status',[Auth::user()->id,'perbaikan']) }}"><i class="fa fa-wrench"></i>Laporan Perbaikan</a></li>
              <li id="ftAdminLaporan_disetujui"><a href="{{ route('ft-admin.laporan-status',[Auth::user()->id,'disetujui']) }}"><i class="fa fa-check-square-o"></i>Laporan Disetujui</a></li>

            </ul>
          </li>
    </ul>

@elseif (Auth::user()->status =='ft_sponsorship')
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION </li>
          <li class=" " id="ftSponsorshipDashboard">
            <a href="{{ route('ft-sponsorship.index',Auth::user()->id) }}">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>

         <li class="treeview" id="ftSponsorshipLaporan">
            <a href="#">
              <i class="fa fa-edit"></i> <span>Kelola Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="ftSponsorshipLaporan_baru"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'baru']) }}"><i class="fa fa-pencil-square-o"></i>Laporan Baru</a></li>        
               <li id="ftSponsorshipLaporan_proses"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'proses']) }}"><i class="fa fa-paper-plane-o"></i>Proses Persetujuan</a></li>
              <li id="ftSponsorshipLaporan_perbaikan"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'perbaikan']) }}"><i class="fa fa-wrench"></i>Laporan Perbaikan</a></li>
              <li id="ftSponsorshipLaporan_disetujui"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'disetujui']) }}"><i class="fa fa-check-square-o"></i>Laporan Disetujui</a></li>              <li id="ftSponsorshipLaporan_kedaluwarsa"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'kedaluwarsa']) }}"><i class="fa fa-calendar-times-o"></i>--Laporan Kedaluwarsa--</a></li>

            </ul>
          </li>
    </ul>
{{-- @elseif (Auth::user()->status =='ft_admin') --}}
@elseif (Auth::user()->status =='ft_kacab')
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION </li>
        
        <li id="ftKacab_Dashboard">
          <a href="{{ route('ft-kacab.index',Auth::user()->id) }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="treeview" id="ftKacab_Laporan">
            <a href="#">
              <i class="fa fa-edit"></i> <span>Kelola Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview" id="ftKacab_acc_laporan"> 
                      <a href="#"><i class="fa fa-check-square-o"></i> Acc Laporan
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li id="ftKacab_acc_laporan_ft_admin"><a href="{{ route('ft-Kacab.laporan-acc',[Auth::user()->id,'ft_admin']) }}"><i class="fa fa-user-o"></i>Laporan Ft Admin</a></li>
                        <li id="ftKacab_acc_laporan_ft_sponsorship"><a href="{{ route('ft-Kacab.laporan-acc',[Auth::user()->id,'ft_sponsorship']) }}"><i class="fa fa-user-o"></i>Laporan Ft Sponsorship</a></li>
                      </ul>
                </li>
                <li class="treeview" id="ftKacab_laporan"> 
                      <a href="#"><i class="fa fa-check-square-o"></i> Laporan
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                         {{--  <li id="ftSponsorshipLaporan_baru"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'baru']) }}"><i class="fa fa-pencil-square-o"></i>Laporan Baru</a></li>        
                           <li id="ftSponsorshipLaporan_proses"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'proses']) }}"><i class="fa fa-paper-plane-o"></i>Proses Persetujuan</a></li>
                          <li id="ftSponsorshipLaporan_perbaikan"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'perbaikan']) }}"><i class="fa fa-wrench"></i>Laporan Perbaikan</a></li>
                          <li id="ftSponsorshipLaporan_disetujui"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'disetujui']) }}"><i class="fa fa-check-square-o"></i>Laporan Disetujui</a></li>              <li id="ftSponsorshipLaporan_kedaluwarsa"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'kedaluwarsa']) }}"><i class="fa fa-calendar-times-o"></i>Laporan Kedaluwarsa</a></li> --}}
                     </ul>
                </li>
              </ul>
            </li>

          </ul>

@elseif (Auth::user()->status =='manajer')
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION </li>
        
        <li id="manajer_Dashboard">
          <a href="{{ route('ft-kacab.index',Auth::user()->id) }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="treeview" id="manajer_Laporan">
            <a href="#">
              <i class="fa fa-edit"></i> <span>Kelola Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview" id="manajer_acc_laporan"> 
                      <a href="#"><i class="fa fa-check-square-o"></i> Acc Laporan
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li id="manajer_acc_laporan_ft_admin"><a href="{{ route('manajer.laporan-acc',[Auth::user()->id,'ft_admin']) }}"><i class="fa fa-user-o"></i>Laporan Ft Admin</a></li>
                        <li id="manajer_acc_laporan_ft_sponsorship"><a href="{{ route('manajer.laporan-acc',[Auth::user()->id,'ft_sponsorship']) }}"><i class="fa fa-user-o"></i>Laporan Ft Sponsorship</a></li>
                        <li id="manajer_acc_laporan_ft_kacab"><a href="{{ route('manajer.laporan-acc',[Auth::user()->id,'ft_kacab']) }}"><i class="fa fa-user-circle"></i>Laporan Ft Kepala Cabang</a></li>
                      </ul>
                </li>
                <li class="treeview" id="manajer_laporan"> 
                      <a href="#"><i class="fa fa-check-square-o"></i> Laporan
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                         {{--  <li id="ftSponsorshipLaporan_baru"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'baru']) }}"><i class="fa fa-pencil-square-o"></i>Laporan Baru</a></li>        
                           <li id="ftSponsorshipLaporan_proses"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'proses']) }}"><i class="fa fa-paper-plane-o"></i>Proses Persetujuan</a></li>
                          <li id="ftSponsorshipLaporan_perbaikan"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'perbaikan']) }}"><i class="fa fa-wrench"></i>Laporan Perbaikan</a></li>
                          <li id="ftSponsorshipLaporan_disetujui"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'disetujui']) }}"><i class="fa fa-check-square-o"></i>Laporan Disetujui</a></li>              <li id="ftSponsorshipLaporan_kedaluwarsa"><a href="{{ route('ft-sponsorship.laporan-status',[Auth::user()->id,'kedaluwarsa']) }}"><i class="fa fa-calendar-times-o"></i>Laporan Kedaluwarsa</a></li> --}}
                     </ul>
                </li>
              </ul>
            </li>

          </ul>

@elseif (Auth::user()->status =='direktur')
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION </li>
        
        <li id="direktur_Dashboard">
          <a href="{{ route('ft-kacab.index',Auth::user()->id) }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="treeview" id="direktur_Laporan">
            <a href="#">
              <i class="fa fa-edit"></i> <span>Kelola Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="treeview" id="direktur_acc_laporan"> 
                      <a href="#"><i class="fa fa-check-square-o"></i> Acc Laporan
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li id="direktur_acc_laporan_ft_admin"><a href="{{ route('ft-Kacab.laporan-acc',[Auth::user()->id,'ft_admin']) }}"><i class="fa fa-user-o"></i>Laporan Ft Admin</a></li>
                        <li id="direktur_acc_laporan_ft_sponsorship"><a href="{{ route('ft-Kacab.laporan-acc',[Auth::user()->id,'ft_sponsorship']) }}"><i class="fa fa-user-o"></i>Laporan Ft Sponsorship</a></li>
                        <li id="direktur_acc_laporan_ft_kacab"><a href="{{ route('ft-Kacab.laporan-acc',[Auth::user()->id,'ft_kacab']) }}"><i class="fa fa-user-circle"></i>Laporan Ft Kepala Cabang</a></li>
                        <li id="direktur_acc_laporan_manajer"><a href="{{ route('ft-Kacab.laporan-acc',[Auth::user()->id,'manajer']) }}"><i class="fa fa-user-circle-o"></i>Laporan Manajer</a></li>
                      </ul>
                </li>
              </ul>
            </li>

          </ul>

@endif
    </section>
    <!-- /.sidebar -->
  </aside>





