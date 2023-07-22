<?php

namespace Modules\Payment\Repository\Eloquent;

use Modules\Payment\Entities\Note;
use Modules\Payment\Repository\NoteRepository;

class NoteEloquent implements NoteRepository
{
    /** @var Note */
    protected $note;

    public function __construct(Note $note)
    {
        $this->note = $note;
    }

    /**
     * Get all notes
     *
     * @return object|null
     */
    public function all(): ?object
    {
        return $this->note->all();
    }

    public function getNote()
    {
        return $this->note->query()->get();
    }

       /**
     * Get bill where id
     *
     * @param string $id
     * @return object
     */
    public function whereId(string $id): object
    {
        return $this->note->whereId($id);
    }


    /**
     * Save note
     *
     * @param array $request
     * @return boolean
     */
    public function save(array $request): bool
    {
        return $this->note->create($request) ? true : false;
    }

    // get bill by id
    public function getByBillId($billId)
    {
        return Note::where('bill_id', $billId)->get();
    }

    /**
     * Delete bill
     *
     * @param string $id
     * @return boolean
     */
    public function delete(string $id): bool
    {
        return $this->bill->findOrFail($id)->delete() ? true : false;
    }
}
