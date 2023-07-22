<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Master\Repository\BillRepository;
use Modules\Master\Repository\StudentRepository;
use Modules\Report\Repository\IncomeRepository;
use Modules\Payment\Repository\SpendingRepository;
use Modules\Payment\Repository\PaymentRepository;
use Modules\Payment\Repository\NoteRepository;

class ReportController extends Controller
{
    protected BillRepository $bill;
    protected IncomeRepository $income;
    protected StudentRepository $student;
    protected SpendingRepository $spending;
    protected PaymentRepository $payment;
    protected NoteRepository $note;

    public function __construct(
        BillRepository $bill,
        IncomeRepository $income,
        StudentRepository $student,
        SpendingRepository $spending,
        PaymentRepository $payment,
        NoteRepository $note
    ) {
        $this->bill = $bill;
        $this->income = $income;
        $this->student = $student;
        $this->spending = $spending;
        $this->payment = $payment;
        $this->note = $note;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('report::index', [
            'title' => 'Laporan'
        ]);
    }

    public function finance(): Renderable
    {
        return view('report::finance.index', [
            'title' => 'Laporan Keuangan',
            'bills2' => $this->bill->all()->orderBy('payments_sum_pay', 'desc')->get(),
            'income' => $this->income->getIncome(),
            'spending' => $this->spending->getSpending(),
            'bills' => $this->bill->getBill()->toArray(),
            'payment' => $this->payment->all(),
            'notes' => $this->note->getNote()->toArray(),
            'stats' => [
                'daily' => $this->income->dailyPercentage(),
                'weekly' => $this->income->weeklyPercentage(),
                'monthly' => $this->income->monthlyPercentage(),
                'yearly' => $this->income->yearlyPercentage(),
            // 'saldo' => $this->income->income() - $this->spending->spending(),
            ],
        ]);
    }

    public function student(): Renderable
    {
        return view('report::student.index', [
            'title' => 'Laporan Siswa',
            'students' => $this->student->groupByStatusCount(),
        ]);
    }
}
