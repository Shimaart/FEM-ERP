<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

final class PaymentController extends Controller
{
    public function index()
    {
        return view('payments.index');
    }

    public function statistics()
    {
        return view('payments.statistics');
    }

    public function cashStatistics()
    {
        return view('payments.cash-statistics');
    }

    public function cashlessStatistics()
    {
        return view('payments.cashless-statistics');
    }

    public function cashboxDetail(Request $request)
    {
        $periodFrom = now()->firstOfMonth()->format('Y-m-d');
        $periodTo = now()->lastOfMonth()->format('Y-m-d');
        $type = 'income';
        if ($request->input('type') && $request->input('type') === 'outgoing') {
            $type = 'outgoing';
        }

        if ($request->input('periodFrom')) {
            try {
                $periodFrom = Carbon::createFromFormat('Y-m-d', $request->input('periodFrom'))->format('Y-m-d');
            } catch (\Exception $e) {

            }
        }

        if ($request->input('periodTo')) {
            try {
                $periodTo = Carbon::createFromFormat('Y-m-d', $request->input('periodTo'))->format('Y-m-d');
            } catch (\Exception $e) {

            }
        }

        return view('payments.cashbox-detail', [
            'type' => $type,
            'periodFrom' => $periodFrom,
            'periodTo' => $periodTo,
        ]);
    }
}
