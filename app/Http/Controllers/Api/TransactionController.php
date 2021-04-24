<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index() {
        $transactions = auth()->user()->transactions;
        return TransactionResource::collection($transactions);
    }

    public function store(StoreTransactionRequest $request){

        $validatedData = $request->validated();

        $transaction = auth()->user()->transactions()->create($validatedData);

        return new TransactionResource($transaction);
    }

    public function show(Transaction  $transaction) {
        return new TransactionResource($transaction);
    }

    public function update(StoreTransactionRequest $request, Transaction $transaction) {
        $validatedData = $request->validated();

        $transaction->update($validatedData);

        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction) {
        $transaction->delete();
        return response()->noContent();
    }
}
