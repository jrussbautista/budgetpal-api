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

        $validatedData['amount'] *= 100;

        $star_date = $validatedData['start_date'];
        $end_date = $validatedData['end_date'];
        $category_id = $validatedData['category_id'];

       $isExist = $this->isBudgetExists($category_id, $star_date, $end_date);

        if($isExist) {
            return response(['message' => 'Budget for this category and date was already created'], 409);
        }

        $budget = auth()->user()->budgets()->create($validatedData);

        return new BudgetResource($budget);
    }

    public function show(Budget $budget) {
        return new BudgetResource($budget);
    }

    public function update(StoreBudgetRequest $request, Budget $budget) {

        $validatedData = $request->validated();

        $validatedData['amount']  *= 100;

        $star_date = $validatedData['start_date'];
        $end_date = $validatedData['end_date'];
        $category_id = $validatedData['category_id'];

       $isExist = $this->isBudgetExists($category_id, $star_date, $end_date);

        if($isExist) {
            return response(['message' => 'Budget for this category and date was already created'], 409);
        }

        $budget->update($validatedData);

        return new BudgetResource($budget);

    }

    public function destroy(Budget $budget) {
        $budget->delete();
        return response()->noContent();
    }

    private function isBudgetExists($category_id, $star_date, $end_date) {
        
        return auth()->user()
            ->budgets()
            ->byCategory($category_id)
            ->byDates($star_date, $end_date)
            ->count();
    }
}
