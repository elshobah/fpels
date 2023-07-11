<?php

namespace Modules\Payment\Observer;

use Illuminate\Support\Facades\Auth;
use Modules\Payment\Entities\Note;

class NoteObserver
{
    public function creating(Note $model)
    {
        $model->fill([
            'created_by' => Auth::id(),
        ]);
    }

    public function updating(Note $model)
    {
        $model->fill([
            'updated_by' => Auth::id(),
        ]);
    }

    public function deleting(Note $model)
    {
        $model->update([
            'deleted_by' => Auth::id(),
        ]);
    }
}
