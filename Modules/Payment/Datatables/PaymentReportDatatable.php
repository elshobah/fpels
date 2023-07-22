<?php

namespace Modules\Payment\Datatables;

use Livewire\Event;
use Livewire\Component;
use App\Datatables\Column;
use App\Datatables\Traits\Notify;
use App\Datatables\TableComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Payment\Entities\Spending;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Entities\Note;
use App\Datatables\Traits\HtmlComponents;
use Illuminate\Database\Eloquent\Builder;
use Modules\Payment\Http\Requests\SpendingRequest;
use Modules\Payment\Http\Requests\PaymentReportRequest;

class PaymentReportDatatable extends TableComponent
{
    use HtmlComponents,
        Notify;

    /** @var array */
    public ?array $bills;
    public ?array $notes;
    public ?array $payments;
    public ?array $year;
    public ?array $students;
    public ?array $months;


    /** @var null|string */
    public $pid = null;


    public $pay_date = null;
    public $month = null;
    public $pay = null;
    public $year_id = null;
    public $student_id = null;
    public $bill_id = null;



    /** @var string table component */
    public $cardHeaderAction = 'payment::payment.componentReport';



    public function mount()
    {
        $this->pay_date = date('Y-m-d');
        // $this->spending_date = date('Y-m-d');
    }

    /**
     * Reset value
     *
     * @return void
     */
    protected function resetValue(): void
    {
        $this->pid = null;
        $this->$pay_date = null;
        $this->$month = null;
        $this->$pay = null;
        $this->$year_id = null;
        $this->$student_id = null;
        $this->$bill_id = null;
    }

    public ?array $filters = [
        'pay_date' => '',
        'bill_name' => '',
        'student_name' => '',
        'month' => '',
    ];

    public function query(): Builder
    {
        $query = Payment::query();

        // Apply filters to the query based on the input values
        if (!empty($this->filters['bill_name'])) {
            $query->whereHas('bill', function ($studentQuery) {
                $studentQuery->where('name', 'like', '%' . $this->filters['bill_name'] . '%');
            });
        }

        if (!empty($this->filters['student_name'])) {
            $query->whereHas('student', function ($studentQuery) {
                $studentQuery->where('name', 'like', '%' . $this->filters['student_name'] . '%');
            });
        }

        if (!empty($this->filters['month'])) {
            $query->where('month', 'like', '%' . $this->filters['month'] . '%');
        }

        if (!empty($this->filters['pay_date'])) {
            $query->whereDate('pay_date', 'like', '%' . $this->filters['pay_date'] . '%');
        }

        return $query;
    }

    public function columns(): array
    {
        return [
            Column::make('no')->rowIndex(),
            // Column::make('nama', 'name')
            //     ->searchable()
            //     ->sortable(),
            Column::make('Tgl Pembayaran', 'pay_date')
                ->searchable()
                ->sortable()
                ->format(function (Payment $model) {
                    return format_date($model->pay_date);
                }),
            Column::make('Nama', 'student_id')
                ->searchable()
                ->sortable()
                ->format(function (Payment $model) {
                    return $model->student->name;
                }),
            Column::make('Tagihan', 'bill_id')
                ->searchable()
                ->sortable()
                ->format(function (Payment $model) {
                    return $model->bill->name;
                }),
            Column::make('Untuk Bulan', 'month')
                ->searchable()
                ->format(function (Payment $model) {
                    return $model->month;
                }),
            Column::make('Pembayaran', 'pay')
                ->searchable()
                ->sortable()
                ->format(function (Payment $model) {
                    return idr($model->pay);
                }),
            // Column::make('tanggal', 'spending_date')
            //     ->sortable()
            //     ->searchable()
            //     ->format(function (Spending $model) {
            //         return format_date($model->spending_date);
            //     }),
            // Column::make('aksi')
            //     ->format(function (Spending $model) {
            //         return view('payment::spending.action', ['model' => $model]);
            //     })
        ];
    }
}
