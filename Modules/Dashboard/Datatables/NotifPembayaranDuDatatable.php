<?php

namespace Modules\Dashboard\Datatables;

use Livewire\Event;
use Livewire\Component;
use App\Datatables\Column;
use App\Datatables\Traits\Notify;
use App\Datatables\TableComponent;
use Modules\Payment\Entities\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Master\Entities\Student;
use Modules\Payment\Entities\Spending;
use App\Datatables\Traits\HtmlComponents;
use Illuminate\Database\Eloquent\Builder;
use Modules\Master\Constants\StudentConstant;
use Modules\Payment\Http\Requests\SpendingRequest;

class NotifPembayaranDuDatatable extends TableComponent
{
    use HtmlComponents,
        Notify;

    /** @var array */
    public ?array $bills;
    public ?array $notes;

    /** @var null|string */
    public $pid = null;
    public $note_id = null;
    public $nominal = null;
    public $bill_id = null;
    public $description = null;
    public $spending_date = null;

    /** filter in card header form */
    public int $filter = StudentConstant::ACTIVE;

    public function updatedBillId($value)
    {
        if ($value) {
            $this->note_id = $value;
        }
    }

    /** @var string table component */
    // public $cardHeaderAction = 'payment::spending.component';

    protected SpendingRequest $request;

    public function __construct(string $id = null)
    {
        parent::__construct($id);
        $this->request = new SpendingRequest;
    }

    public function mount()
    {
        $this->spending_date = date('Y-m-d');
    }

    /**
     * Reset value
     *
     * @return void
     */
    protected function resetValue(): void
    {
        $this->pid = null;
        $this->note_id = null;
        $this->bill_id = null;
        $this->nominal = null;
        $this->description = null;
    }

    // public function create()
    // {
    //     $this->resetValue();
    //     return $this->emit('modal:toggle');
    // }

    // public function save(): Event
    // {
    //     $validated = $this->validate($this->request->rules($this->bill_id), [], $this->request->attributes());
    //     $result = array_merge($validated, ['nominal' => clean_currency_format($validated['nominal'])]);

    //     if ($this->query()->create($result)) {
    //         $this->resetValue();
    //         return $this->success('Berhasil!', 'Pengeluaran berhasil ditambahkan.');
    //     }

    //     return $this->error('Oopss!', 'Terjadi kesalahan saat menambah pengeluaran.');
    // }

    // public function edit(string $id): Event
    // {
    //     $this->pid = $id;
    //     $query = $this->query()->whereId($id)->first();

    //     if (!$query) {
    //         return $this->error('Oopss!', 'Pengeluaran tidak ditemukan.');
    //     }

    //     $this->note_id = $query->note_id;
    //     $this->nominal = $query->nominal;
    //     $this->bill_id = $query->bill_id;
    //     $this->spending_date = \Carbon\Carbon::parse($query->spending_date)->format('Y-m-d');
    //     $this->description = $query->description;

    //     return $this->emit('modal:toggle', $query->description);
    // }

    // public function update(): Event
    // {
    //     $spending = $this->query()->whereId($this->pid)->first();

    //     if (!$spending) {
    //         return $this->error('Oopss!', 'Pengeluaran tidak ditemukan.');
    //     }

    //     $validated = $this->validate($this->request->rules($this->bill_id, $isUpdate = true), [], $this->request->attributes());
    //     $result = array_merge($validated, ['nominal' => clean_currency_format($validated['nominal'])]);

    //     if ($spending->update($result)) {
    //         return $this->success('Berhasil!', 'Pengeluaran berhasil diubah.');
    //     }

    //     return $this->error('Oopss!', 'Terjadi kesalahan saat mengubah pengeluaran.');
    // }

    // public function delete(string $id, string $password)
    // {
    //     if (Hash::check($password, Auth::user()->password)) {
    //         if ($this->query()->whereId($id)->delete()) {
    //             return $this->success('Berhasil!', 'Pengeluaran berhasil dihapus.');
    //         }

    //         return $this->error('Oopss!', 'Terjadi kesalahan saat menghapus pengeluaran.');
    //     }

    //     return $this->error('', 'Password yang anda masukan salah.');
    // }

    public function query(): Builder
    {
        return Student::query()->where('status', $this->filter)
            ->with(['payment' => function ($query) {
                $query->whereNull('month');
                $query->with(['bill' => function ($query) {
                    $query->where('monthly', false);
                }]);
            }])
            ->withSum(['payment' => function ($query) {
                $query->whereNull('month');
            }], 'pay');
    }

    public function columns(): array
    {
        return [
            Column::make('no')->rowIndex(),
            // Column::make('nama', 'name')
            //     ->searchable()
            //     ->sortable(),
            Column::make('Nama', 'name')
                ->searchable()
                ->sortable()
                ->format(function (Student $model) {
                    return $model->name;
                }),
            Column::make('Pembayaran', 'note_id')
                ->searchable()
                ->sortable()
                ->format(function (Student $model) {
                    return $model->payment[0]->bill?->name ?? "-";
                }),
            // Column::make('Sumber dana', 'bill_id')
            //     ->searchable()
            //     ->sortable()
            //     ->format(function (Student $model) {
            //         return $model->bill;
            //     }),
            Column::make('per tanggal', 'spending_date')
                ->sortable()
                ->searchable()
                ->format(function (Student $model) {
                    return format_date($model->spending_date);
                }),
            Column::make('nominal')
                ->searchable()
                ->sortable()
                ->format(function (Student $model) {
                    return idr($model->payment_sum_pay);
                }),
            // Column::make('keterangan', 'description')
            //     ->searchable()
            //     ->format(function (Student $model) {
            //         return $model->description === '' || is_null($model->description) ? '-' : $this->html($model->description);
            //     }),
            // Column::make('aksi')
            //     ->format(function (Student $model) {
            //         return view('payment::spending.action', ['model' => $model]);
            //     })
        ];
    }
}
