<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">

      <li class="header">Master</li>
      <!-- Optionally, you can add icons to the links -->
      <li ><a href="/users"><i class="fa fa-link"></i> <span>Register Pengguna</span></a></li>
      <li ><a href="/obat"><i class="fa fa-link"></i> <span>Obat</span></a></li>
      <li ><a href="/satuan"><i class="fa fa-link"></i> <span>Satuan</span></a></li>
      <li class="header">Mutasi</li>
      <li><a href="/mutasi"><i class="fa fa-link"></i> <span>Mutasi</span></a></li>
      <li class="header">Laporan</li>
      <li><a href="/penerimaan"><i class="fa fa-link"></i> <span>Laporan Penerimaan</span></a></li>
      <li><a href="/pengeluaran"><i class="fa fa-link"></i> <span>Laporan Pengeluaran</span></a></li>
      <li><a href="/bulanan"><i class="fa fa-link"></i> <span>Laporan Bulanan</span></a></li>
      <li class="header">Profile</li>
      <li> <a class="dropdown-item" href="{{ route('logout') }}"
         onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form></li>
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
