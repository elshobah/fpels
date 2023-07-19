<?php

namespace Modules\Payment\Http\Controllers;

use Modules\Utils\Month;
use Illuminate\Http\Request;
use Modules\Master\Entities\Bill;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Student;
use Modules\Master\Entities\SchoolYear;
use Modules\Payment\Pdf\PaymentYearlyPdf;
use Modules\Payment\Pdf\PaymentMonthlyPdf;
use Illuminate\Contracts\Support\Renderable;
use Modules\Payment\Pdf\PaymentNotMonthlyPdf;

class PaymentController extends Controller
{
    /**
     * View payment page
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('payment::payment.index', [
            'title' => 'Pembayaran',
            'bills' => Bill::query()->select(['id', 'name'])->get(),
            'years' => SchoolYear::query()->select(['id', 'year'])->get(),
            'students' => Student::query()->active()->select(['id', 'name', 'nis', 'nisn'])->get(),
        ]);
    }

    public function report2(): Renderable
    {
        $data = [
            'title' => 'Laporan Pembayaran',
            'bills' => Bill::query()->select(['id', 'name'])->get(),
            'years' => SchoolYear::query()->select(['id', 'year'])->get(),
            'months' => Month::prefixName(),
            // 'students' => Student::query()->get(),
            'students' => Student::query()->active()->select(['id', 'name', 'nis', 'nisn'])->get(),
        ];
        // dd($data['months']);

        return view('payment::payment.report2', $data);
    }

    public function printYearly(Request $request)
    {
        $user = $request->query('user');
        $bill = $request->query('bill');
        $year = $request->query('year');
        $type = $request->query('type');

        return (new PaymentYearlyPdf($user, $bill, $year, $type))->loadView('payment::payment.print.yearly');
    }

    public function printMonthly(Request $request)
    {
        $user = $request->query('user');
        $bill = $request->query('bill');
        $year = $request->query('year');
        $month = $request->query('month');

        return (new PaymentMonthlyPdf($user, $bill, $month, $year))->loadView('payment::payment.print.monthly');
    }

    public function printNotMonthly(Request $request)
    {
        $user = $request->query('user');
        $bill = $request->query('bill');
        $year = $request->query('year');

        return (new PaymentNotMonthlyPdf($user, $year, $bill))->loadView('payment::payment.print.not-monthly');
    }
}
