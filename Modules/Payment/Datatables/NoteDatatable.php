<?php

namespace Modules\Payment\Datatables;

use Livewire\Event;
use App\Datatables\Column;
use App\Datatables\Traits\Notify;
use App\Datatables\TableComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Payment\Entities\Note;
use App\Datatables\Traits\HtmlComponents;
use Illuminate\Database\Eloquent\Builder;
use Modules\Payment\Http\Requests\NoteRequest;

class NoteDatatable extends TableComponent
{
    use HtmlComponents,
        Notify;

    /** @var array */
    public ?array $bills;

    /** @var null|string */
    public $pid = null;
    public $bill_id = null;
    public $name = null;
    public $description = null;
    public $spending_date = null;

    /** @var string table component */
    public $cardHeaderAction = 'payment::note.component';

    protected NoteRequest $request;

    public function __construct(string $id = null)
    {
        parent::__construct($id);
        $this->request = new NoteRequest;
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
        $this->name = null;
        $this->bill_id = null;
        $this->description = null;
    }

    public function create()
    {
        $this->resetValue();
        return $this->emit('modal:toggle');
    }

    public function save(): Event
    {
        $validated = $this->validate($this->request->rules($this->bill_id), [], $this->request->attributes());
        $result = array_merge($validated, ['name' => ($validated['name'])]);

        if ($this->query()->create($result)) {
            $this->resetValue();
            return $this->success('Berhasil!', 'Catatan berhasil ditambahkan.');
        }

        return $this->error('Oopss!', 'Terjadi kesalahan saat menambah catatan.');
    }

    public function edit(string $id): Event
    {
        $this->pid = $id;
        $query = $this->query()->whereId($id)->first();

        if (!$query) {
            return $this->error('Oopss!', 'catatan tidak ditemukan.');
        }

        $this->name = $query->name;
        $this->description = $query->description;
        $this->bill_id = $query->bill_id;
        $this->spending_date = \Carbon\Carbon::parse($query->spending_date)->format('Y-m-d');
        $this->description = $query->description;

        return $this->emit('modal:toggle', $query->description);
    }

    public function update(): Event
    {
        $spending = $this->query()->whereId($this->pid)->first();

        if (!$spending) {
            return $this->error('Oopss!', 'Catatan tidak ditemukan.');
        }

        $validated = $this->validate($this->request->rules($this->bill_id, $isUpdate = true), [], $this->request->attributes());
         $result = array_merge($validated, ['name' => ($validated['name'])]);

        if ($spending->update($result)) {
            return $this->success('Berhasil!', 'Catatan berhasil diubah.');
        }

        return $this->error('Oopss!', 'Terjadi kesalahan saat mengubah catatan.');
    }

    public function delete(string $id, string $password)
    {
        if (Hash::check($password, Auth::user()->password)) {
            if ($this->query()->whereId($id)->delete()) {
                return $this->success('Berhasil!', 'Catatan berhasil dihapus.');
            }

            return $this->error('Oopss!', 'Terjadi kesalahan saat menghapus catatan.');
        }

        return $this->error('', 'Password yang anda masukan salah.');
    }

    public function query(): Builder
    {
        return Note::query();
    }

    public function columns(): array
    {
        return [
            Column::make('no')->rowIndex(),
            // Column::make('nama', 'name')
            //     ->searchable()
            //     ->sortable(),
            Column::make('Income', 'bill_id')
                ->searchable()
                ->sortable()
                ->format(function (Note $model) {
                    return $model->bill->name;
                }),
            Column::make('For outcome','name')
                ->searchable()
                ->sortable()
                ->format(function (Note $model) {
                    return ($model->name);
                }),
            Column::make('keterangan', 'description')
                ->searchable()
                ->format(function (Note $model) {
                    return $model->description === '' || is_null($model->description) ? '-' : $this->html($model->description);
                }),
            // Column::make('tanggal', 'spending_date')
            //     ->sortable()
            //     ->searchable()
            //     ->format(function (Note $model) {
            //         return format_date($model->spending_date);
            //     }),
            Column::make('aksi')
                ->format(function (note $model) {
                    return view('payment::note.action', ['model' => $model]);
                })
        ];
    }
}
