<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index() {   

        $transactions = auth()->user()
        ->transactions()
        ->when(request('start_date') !== null  && request('end_date'), function($query) {
           $query->whereBetween('happened_on', [request('start_date'), request('end_date')]);
        })
        ->get();

        return [
            'data'  => $transactions
        ];
    }
}
