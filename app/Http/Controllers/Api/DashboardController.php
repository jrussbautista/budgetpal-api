<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function __invoke() {

        $today = Carbon::today();
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;

        $total_spent_today = auth()
            ->user()
            ->transactions()
            ->whereDate('created_at', $today)
            ->sum('amount') / 100;

        $total_monthly_spent =  auth()
            ->user()
            ->transactions()
            ->whereMonth('created_at', $currentMonth)
            ->sum('amount') / 100;

        $total_monthly_budget = auth()
            ->user()
            ->budgets()
            ->whereMonth('created_at', $currentMonth)
            ->sum('amount') / 100;

        $total_remaining_budget = $total_monthly_budget - $total_monthly_spent;

        return [
                'data' => [
                    'date' => Carbon::today()->format('F Y'),
                    'analytics' => 
                        [
                            [
                                'name' => 'Total Spent Today',
                                'value' => number_format($total_spent_today, 2, '.', '')
                            ],
                            [
                                'name' => 'Total Spent Monthly',
                                'value' => number_format($total_monthly_spent, 2, '.', '')
                            ],
                            [
                                'name' => 'Total Remaining Budget',
                                'value' => number_format($total_remaining_budget, 2, '.', '')
                            ],
                        ]
                    ]   
            ];
    }
}
