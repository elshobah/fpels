<?php

namespace App\Providers;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use Modules\Master\Datatables\BillDatatable;
use Modules\Master\Datatables\RoomDatatable;
use Modules\Master\Datatables\StudentDatatable;
use Modules\Master\Datatables\SchoolYearDatatable;
use Modules\Master\Datatables\FirstMoveRoomDatatable;
use Modules\Master\Datatables\SecondMoveRoomDatatable;
use Modules\Dashboard\Datatables\NotifPembayaranDuDatatable;
use Modules\Dashboard\Datatables\NotifPembayaranSppDatatable;

class LivewireServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /** @component master module */
        Livewire::component('room-datatable', RoomDatatable::class);
        Livewire::component('bill-datatable', BillDatatable::class);
        Livewire::component('school-year-datatable', SchoolYearDatatable::class);
        Livewire::component('student-datatable', StudentDatatable::class);
        Livewire::component('first-move-room-datatable', FirstMoveRoomDatatable::class);
        Livewire::component('second-move-room-datatable', SecondMoveRoomDatatable::class);
        Livewire::component('notif-spp-datatable', NotifPembayaranSppDatatable::class);
        Livewire::component('notif-du-datatable', NotifPembayaranDuDatatable::class);
    }
}
