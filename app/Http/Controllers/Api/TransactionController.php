<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\StoreTransactionRequest;

class TransactionController extends Controller
{

    public function __construct() {
        $this->authorizeResource(Transaction::class, 'transaction');
    }


    public function index() {

        $limit = request('limit') ?? 10;

        $transactions = auth()->user()->transactions()
        ->when(request('category_id') !== null, function($query) {
            $query->where('category_id', request('category_id'));
        })
        ->when(request('type') !== null, function($query) {
            $query->where('type', request('type'));
        })
        ->when(request('title') !== null, function($query) {
            $query->where('title', 'LIKE', "%". request('title') . "%");
        })
        ->when(request('min_amount') !== null && request('max_amount') !== null, function($query) {
            $query->whereBetween('amount', [request('min_amount') * 100, request('max_amount') * 100]);
        })
        ->when(request('start_date') !== null && request('end_date') !== null, function($query) {
            $start_date = request('start_date');
            $end_date = request('end_date');
            $query->whereBetween('happened_on', [$start_date, $end_date]);
        })
        ->orderByDesc('created_at')->paginate($limit);

        return TransactionResource::collection($transactions);
    }

    public function store(StoreTransactionRequest $request){

        $transaction = $request->validated();

        $transaction['amount'] *= 100;

        $transaction = auth()->user()->transactions()->create($transaction);

        return new TransactionResource($transaction);
    }

    public function show(Transaction  $transaction) {
        return new TransactionResource($transaction);
    }

    public function update(StoreTransactionRequest $request, Transaction $transaction) {
        $validatedData = $request->validated();

        $validatedData['amount']  *= 100;
        
        $transaction->update($validatedData);

        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction) {
        $transaction->delete();
        return response()->noContent();
    }
}
