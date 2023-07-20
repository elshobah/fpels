<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Master\Repository\BillRepository;
use Modules\Master\Repository\StudentRepository;
use Modules\Report\Repository\IncomeRepository;
use Modules\Payment\Repository\SpendingRepository;

class ReportController extends Controller
{
    protected BillRepository $bill;
    protected IncomeRepository $income;
    protected StudentRepository $student;
    protected SpendingRepository $spending;

    public function __construct(
        BillRepository $bill,
        IncomeRepository $income,
        StudentRepository $student,
        SpendingRepository $spending,
    ) {
        $this->bill = $bill;
        $this->income = $income;
        $this->student = $student;
        $this->spending = $spending;
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
            'bills' => $this->bill->all()->orderBy('payments_sum_pay', 'desc')->get(),
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
