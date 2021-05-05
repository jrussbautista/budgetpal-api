<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct() {
        $this->authorizeResource(Transaction::class, 'transaction');
    }


    public function index() {
        
        $transactions = auth()->user()->transactions()
        ->when(request('category_id') !== null, function($query) {
            $query->where('category_id', request('category_id'));
        })->get();

        return TransactionResource::collection($transactions);
    }

    public function store(StoreTransactionRequest $request){

        $transaction = $request->validated();

        $transaction['amount'] * 100;

        $transaction = auth()->user()->transactions()->create($transaction);

        return new TransactionResource($transaction);
    }

    public function show(Transaction  $transaction) {
        return new TransactionResource($transaction);
    }

    public function update(StoreTransactionRequest $request, Transaction $transaction) {
        $validatedData = $request->validated();

        $transaction->setAmountAttribute($validatedData['amount']);
        $transaction->update($validatedData);

        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction) {
        $transaction->delete();
        return response()->noContent();
    }
}
