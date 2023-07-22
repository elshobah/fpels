<x-app-layout :title="$title">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('report.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Ekstra</a></div>
                <div class="breadcrumb-item"><a href="{{ route('report.index') }}">Laporan</a></div>
                <div class="breadcrumb-item">Keuangan</div>
            </div>
        </div>

        <div class="section-body">
            <div>
                <h2 class="section-title">Pemasukan</h2>
                <p class="section-lead">Semua data pemasukan ini belum dikurangi dengan pengeluaran.</p>
            </div>
            <div class="row">
                @foreach ($stats as $key => $item)
                    <x-percentage :result="$stats[$key]" />
                @endforeach
            </div>

            {{-- tambahan --}}

            {{-- akhir tambahan --}}


        </div>
        <div class="section-body">
            <h2 class="section-title">Pemasukan & Pengeluaran</h2>
            <p class="section-lead">Semua data pemasukan & pengeluaran.</p>

            <div class="row">
                {{-- <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <livewire:finance-income-chart key="income-chart-{{ time() }}" />
                </div> --}}
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-title">Pemasukan Berdasarkan Tagihan</h4>
                        </div>
                        <div class="card-body" style="height: 489px!important;overflow-y:scroll;">
                            <x-widget type="success" title="Total Pemasukan" class="card-list-icon"
                                icon="fad fa-dollar-sign"
                                :value="idr(array_sum($bills2->pluck('payments_sum_pay')->toArray()))" />
                            @foreach ($bills2 as $bill)
                                <x-widget type="success" :title="$bill->name" class="card-list-icon"
                                    icon="fad fa-money-bill-alt" :value="idr($bill->payments_sum_pay)" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-title">Pengeluaran Berdasarkan Tagihan</h4>
                        </div>
                        <div class="card-body" style="height: 489px!important;overflow-y:scroll;">
                            <x-widget type="danger" title="Total Pengeluaran" class="card-list-icon"
                                icon="fad fa-dollar-sign"
                                :value="idr(array_sum($bills2->pluck('spendings_sum_nominal')->toArray()))" />
                            @foreach ($bills2 as $bill)
                                <x-widget type="danger" :title="$bill->name" class="card-list-icon"
                                    icon="fad fa-money-bill-alt" :value="idr($bill->spendings_sum_nominal)" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-title">Saldo</h4>
                        </div>
                        <div class="card-body" style="height: 489px!important;overflow-y:scroll;">
                            <x-widget type="success" title="Saldo Kumulatif" class="card-list-icon"
                                icon="fad fa-dollar-sign"
                                :value="idr(array_sum($bills2->pluck('payments_sum_pay')->toArray()) - array_sum($bills2->pluck('spendings_sum_nominal')->toArray()))" />
                                {{-- :value="idr(array_sum($bills->pluck('payments_sum_pay')->toArray()))" /> --}}
                            @foreach ($bills2 as $bill)
                                <x-widget type="success" :title="$bill->name" class="card-list-icon"
                                    icon="fad fa-money-bill-alt" :value="idr($bill->payments_sum_pay - $bill->spendings_sum_nominal)" />
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>


            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <livewire:finance-income-chart key="spending-chart-{{ time() }}" />
                </div><div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <livewire:finance-spending-chart key="spending-chart-{{ time() }}" />
                </div>
                {{-- <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-title">Laporan pemasukan</h4>
                        </div>
                        <div class="card-body" style="height: 489px!important;overflow-y:scroll;">
                            <tr>
                                <th>Tagihan</th>
                                <th>Total</th>
                            </tr>
                            @foreach ($income as $inc)
                            <tr>
                                <td>{{$inc->name}}</td>
                                <td>{{$inc->payments_sum_pay}}</td>
                            </tr>
                            @endforeach
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
    <livewire:spending-report-datatable :title="$title" :bills="$bills" :notes="$notes" />
</x-app-layout>
