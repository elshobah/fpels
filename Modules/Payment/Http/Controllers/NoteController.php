<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Master\Repository\BillRepository;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(BillRepository $bill): Renderable
    {
        return view('payment::note.index', [
            'title' => 'Note',
            'bills' => $bill->all()->get()->toArray(),
        ]);
    }
}
