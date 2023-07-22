<?php

namespace Modules\Payment\Providers;

use Illuminate\Support\ServiceProvider;

class LivewireServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        \Livewire\Livewire::component('payment', \Modules\Payment\Http\Livewire\StudentPayment::class);
        \Livewire\Livewire::component('report2', \Modules\Payment\Http\Livewire\PaymentReport::class);
        \Livewire\Livewire::component('spending-datatable', \Modules\Payment\Datatables\SpendingDatatable::class);
        \Livewire\Livewire::component('payment-report-datatable', \Modules\Payment\Datatables\PaymentReportDatatable::class);
        \Livewire\Livewire::component('spending-report-datatable', \Modules\Payment\Datatables\SpendingReportDatatable::class);
        \Livewire\Livewire::component('note-datatable', \Modules\Payment\Datatables\NoteDatatable::class);
    }
}
