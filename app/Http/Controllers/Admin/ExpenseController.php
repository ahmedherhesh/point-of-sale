<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MasterController;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpensesResource;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends MasterController
{
    public $permission = 'المصروفات';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $expenses = Expense::query();
        if ($request->from)
            $expenses->whereDate('created_at', '>=', $request->from);
        if ($request->to)
            $expenses->whereDate('created_at', '<=', $request->to);
        if (!$request->from && !$request->to)
            $expenses->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
        $sumExpenses = $expenses->sum('amount');
        $expenses = ExpensesResource::collection($expenses->latest()->paginate(100));
        return inertia('Expenses/Expenses', compact('expenses','sumExpenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Expenses/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->user()->id;
        Expense::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        return inertia('Expenses/Edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        $data = $request->all();
        $expense->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
    }
}
