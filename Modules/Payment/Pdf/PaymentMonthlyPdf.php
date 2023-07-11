<?php

namespace Modules\Payment\Pdf;

use DOMPDF;
use Modules\Utils\Semester;
use Modules\Payment\Entities\Payment;

class PaymentMonthlyPdf
{
    protected $user;
    protected $bill;
    protected $year;
    protected $month;

    public function __construct($user, $bill, $month, $year)
    {
        $this->user = $user;
        $this->bill = $bill;
        $this->year = $year;
        $this->month = $month;
    }

    public function loadView($view)
    {
        if (is_null($this->user) || is_null($this->year) || is_null($this->bill) || is_null($this->month)) {
            notify('red', 'Gagal!', 'Data pembayaran tidak ditemukan.');
            return redirect()->route('payment.index');
        }
        
        $payments = Payment::query()
            ->with(['bill', 'student', 'school_year'])
            ->where('bill_id', $this->bill)
            ->where('year_id', $this->year)
            ->where('student_id', $this->user)
            ->whereMonth('month', $this->month)
            ->get();

        if (count($payments)) {
            return view($view, [
                'title' => $payments->first()->student->name . '-NotaMonthly -' . date('Ymd-His'),
                'rows' => $payments,
            ]);
        }

        notify('red', 'Gagal!', 'Data tidak ditemukan.');
        return redirect()->route('payment.index');
    }
}
