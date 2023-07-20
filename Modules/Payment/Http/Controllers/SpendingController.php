<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Repository\BillRepository;
use Modules\Payment\Repository\NoteRepository;

use Livewire\Component;

class SpendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  BillRepository  $bill
     * @param  NoteRepository  $note
     * @return Renderable
     */
    public function index(BillRepository $bill, NoteRepository $note): Renderable
    {
        $billId = $_REQUEST['bill_id'] ?? null; // Replace with the actual bill ID parameter name

        $bills = $bill->all()->get()->toArray();

        // untuk update / edit menggunakan script ini
        // $notes = $note->all()->toArray();

        // $notes = [];

        // untuk add new data menggunakan script ini
        if (!empty($bills)) {
            $billId = $bills[1]['id']; // Get the first bill's ID or choose the desired bill ID

            $notes = $note->getByBillId($billId)->toArray();
        }


        // if ($billId) {
        //     $notes = $note->getByBillId($billId)->toArray();
        // }

        return view('payment::spending.index', [
            'title' => 'Pengeluaran',
            'bills' => $bills,
            'notes' => $notes,
            'selectedBillId' => $billId,
        ]);
    }

}




// ini yang lama

// class SpendingController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      *
//      * @return Renderable
//      */
//     public function index(BillRepository $bill, NoteRepository $note): Renderable
//     {
//     $bills = $bill->all()->get()->toArray();
//     $billId = $_REQUEST; // Replace with the actual bill ID
//     $notes = $note->getByBillId($billId)->toArray();

//     return view('payment::spending.index', [
//         'title' => 'Pengeluaran',
//         'bills' => $bills,
//         'notes' => $notes,
//     ]);
//     }
// }
