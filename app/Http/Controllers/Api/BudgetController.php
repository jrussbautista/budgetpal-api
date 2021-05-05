<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBudgetRequest;
use App\Http\Resources\BudgetResource;
use App\Models\Budget;


class BudgetController extends Controller
{
    public function __construct() {
        $this->authorizeResource(Budget::class, 'budget');
    }

    public function index() {
        $budgets = auth()->user()->budgets()->orderByDesc('created_at')->get();
        
        return BudgetResource::collection($budgets);
    }

    public function store(StoreBudgetRequest $request) {

        $validatedData = $request->validated();

        $budget = auth()->user()->budgets()->create(
            [
                'amount' => $validatedData['amount'],
                'category_id' => $validatedData['category_id']
            ]
        );

        return new BudgetResource($budget);
    }

    public function show(Budget $budget) {
        return new BudgetResource($budget);
    }

    public function update(StoreBudgetRequest $request, Budget $budget) {

        $validatedData = $request->validated();

        $budget->update($validatedData);

        return new BudgetResource($budget);

    }

    public function destroy(Budget $budget) {
        $budget->delete();
        return response()->noContent();
    }
}
