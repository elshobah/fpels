@extends('layouts.app2')
{{-- <x-app-layout :title="$title"> --}}
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <x-widget
                    type="success"
                    title="Total Pemasukan"
                    :value="idr($income)"
                    icon="fad fa-dollar-sign"
                />
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <x-widget
                    type="danger"
                    title="Total Pengeluaran"
                    :value="idr($spending)"
                    icon="fad fa-dollar-sign"
                />
            </div>


            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <x-widget
                    type="success"
                    title="Saldo Kumulatif"
                    :value="idr($saldo)"
                    icon="fad fa-dollar-sign"
                />
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <x-widget
                    type="primary"
                    title="Total Siswa"
                    :value="$student"
                    icon="fad fa-users"
                />
            </div>

            {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <x-widget
                    type="warning"
                    title="Total Tagihan"
                    :value="$bill"
                    icon="far fa-money-bill-alt"
                />
            </div> --}}
        </div>

        <div class="row">
            <div class="col-12">
                <livewire:finance-dashboard-chart />
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <livewire:notif-spp-datatable />
            </div>
            <div class="col-6">
                <livewire:notif-du-datatable />
            </div>
        </div>

    </section>

    {{-- <div class="container-fluid"> --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Your content goes here -->

                    <div class="row">
                        <div class="col-12">
                            <p>Klik Menu di bawah ini untuk menuju halaman yang ingin di tuju.</p>
                        </div>
                    </div>

                    @canany(['manage_room', 'manage_school_year', 'manage_student', 'manage_bill', 'manage_document'], Auth::user())
                        <li class="menu-header">Master</li>
                    @endcanany

                    @can('manage_room', Auth::user())
                            <a class="nav-link" href="{{ route('master.room.index') }}">
                                <i class="fad fa-building"></i>
                                <span>Kelas</span>
                            </a>
                    @endcan

                    @can('manage_school_year', Auth::user())
                            <a class="nav-link" href="{{ route('master.school-year.index') }}">
                                <i class="fad fa-flag"></i>
                                <span>Tahun Ajaran</span>
                            </a>
                    @endcan

                    @can('manage_student', Auth::user())
                            <a class="nav-link" href="{{ route('master.student.index') }}">
                                <i class="fad fa-users"></i>
                                <span>Siswa</span>
                            </a>
                    @endcan

                    @can('manage_bill', Auth::user())
                            <a class="nav-link" href="{{ route('master.bill.index') }}">
                                <i class="fad fa-balance-scale"></i>
                                <span>Tagihan</span>
                            </a>
                    @endcan

                    {{-- @can('manage_document', Auth::user())
                        <li class="{{ active('document') }}">
                            <a class="nav-link" href="{{ route('document.index') }}">
                                <i class="fad fa-file-alt"></i>
                                <span>Dokumen</span>
                            </a>
                        </li>
                    @endcan --}}

                    @canany(['manage_payment', 'manage_spending'], Auth::user())
                        <li class="menu-header">Keuangan</li>
                    @endcanany

                    @can('manage_spending', Auth::user())
                            <a class="nav-link" href="{{ route('spending.index') }}">
                                <i class="fad fa-money-bill-alt"></i>
                                <span>Pengeluaran</span>
                            </a>
                    @endcan

                    @can('manage_payment', Auth::user())
                            <a class="nav-link" href="{{ route('payment.index') }}">
                                <i class="fad fa-money-bill-alt"></i>
                                <span>Pembayaran</span>
                            </a>
                    @endcan

                    @canany(['view_report', 'manage_setting'], Auth::user())
                        <li class="menu-header">Ekstra</li>
                    @endcanany

                    @can('view_report', Auth::user())
                            <a class="nav-link" href="{{ route('report.index') }}">
                                <i class="fad fa-chart-pie"></i>
                                <span>Laporan</span>
                            </a>
                    @endcan

                    @can('manage_setting', Auth::user())
                            <a class="nav-link" href="{{ route('setting.index') }}">
                                <i class="fad fa-cog"></i>
                                <span>Pengaturan</span>
                            </a>
                    @endcan

                    <div class="p-3 mt-4 mb-4 hide-sidebar-mini">
                        <a href="https://wa.me/6281217654564" class="btn btn-primary btn-lg btn-block">
                            <div>Tanya admin</div>
                        </a>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}


@stop
{{-- </x-app-layout> --}}

