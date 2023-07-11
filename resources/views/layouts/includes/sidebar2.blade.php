<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <center>
                {{-- <img src="{{ asset("storage/$setting->logo") }}" alt="Logo Sekolah"> --}}
                <img style="max-width: 15%" src="{{ asset("https://ezzat.ac.id/wp-content/uploads/2020/11/ezzat-logo-main-png.png") }}" alt="Logo Sekolah">
                <a href="{{ url('/') }}">SIT Ezzat El-Fathir</a>
            </center>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ active('dashboard') }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fad fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- @can('manage_bill', Auth::user())
                <li class="{{ active('bill*') }}">
                    <a class="nav-link" href="{{ route('master.bill.index') }}">
                        <i class="fad fa-balance-scale"></i>
                        <span>Tagihan</span>
                    </a>
                </li>
            @endcan --}}

        </ul>
        <div class="p-3 mt-4 mb-4 hide-sidebar-mini">
           <p>Selamat datang <br>di Sistem Informasi pencatantan Keuangan Ezzat.</p>
        </div>
    </aside>
</div>
