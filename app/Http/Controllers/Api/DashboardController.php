<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BudgetResource;
use App\Http\Resources\TransactionResource;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function __invoke() {

        $today = Carbon::today();
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;

        $totalSpentToday = auth()
            ->user()
            ->transactions()
            ->whereDate('created_at', $today)
            ->sum('amount') / 100;

        $totalSpentMonth =  auth()
            ->user()
            ->transactions()
            ->whereMonth('created_at', $currentMonth)
            ->sum('amount') / 100;

        $totalSpentYear =  auth()
            ->user()
            ->transactions()
            ->whereYear('created_at', $currentYear)
            ->sum('amount') / 100;


        $recentTransaction = auth()
            ->user()
            ->transactions()
    
            ->first();

        $recentOnGoingBudget = auth()
            ->user()
            ->budgets()
            ->first();

        return [
                'data' => [
                    'recentTransaction' =>  new TransactionResource($recentTransaction),
                    'recentOnGoingBudget' => new BudgetResource($recentOnGoingBudget),
                    'analytics' => 
                        [
                            [
                                'name' => 'Total Spent Today',
                                'value' => number_format($totalSpentToday, 2)
                            ],
                            [
                                'name' => 'Total Spent This Month',
                                'value' => number_format($totalSpentMonth, 2)
                            ],
                            [
                                'name' => 'Total Spent This Year',
                                'value' => number_format($totalSpentYear, 2)
                            ],
                        ],
                    ]
            ];
    }
}
