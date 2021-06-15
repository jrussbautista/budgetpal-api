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
            ->whereYear('happened_on', $currentYear)
            ->whereMonth('happened_on', $currentMonth)
            ->whereDate('happened_on', $today)
            ->sum('amount');

        $totalSpentMonth =  auth()
            ->user()
            ->transactions()
            ->whereYear('happened_on', $currentYear)
            ->whereMonth('happened_on', $currentMonth)
            ->sum('amount');


        $totalSpentYear =  auth()
            ->user()
            ->transactions()
            ->whereYear('happened_on', $currentYear)
            ->sum('amount');

        $recentTransaction = auth()
            ->user()
            ->transactions()
            ->orderByDesc('happened_on')
            ->first();

        $recentOnGoingBudget = auth()
            ->user()
            ->budgets()
            ->byOnGoing()
            ->first();


        return [
                'data' => [
                    'recentTransaction' =>  $recentTransaction ? new TransactionResource($recentTransaction) : null,
                    'recentOnGoingBudget' => $recentOnGoingBudget ? new BudgetResource($recentOnGoingBudget): null,
                    'analytics' => 
                        [
                            [
                                'name' => 'Total Spent Today',
                                'value' => $totalSpentToday / 100
                            ],
                            [
                                'name' => 'Total Spent This Month',
                                'value' => $totalSpentMonth / 100
                            ],
                            [
                                'name' => 'Total Spent This Year',
                                'value' => $totalSpentYear / 100
                            ],
                        ],
                    ]
            ];
    }
}
