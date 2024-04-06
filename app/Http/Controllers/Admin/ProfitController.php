<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MasterController;
use App\Http\Resources\OperationsResource;
use App\Models\Expense;
use App\Models\ExtraProfit;
use App\Models\Operation;
use Illuminate\Http\Request;

class ProfitController extends MasterController
{
    public $permission = 'إجمالي الأرباح';

    function profits($operations, $extraProfits, $expenses)
    {
        $profits = 0;
        foreach ($operations as $operation) {
            $profits += $operation->sale_price - ($operation->price + $operation->discount);
        }
        //profits = ((sale price - (price + discount)) + extra profits ) - expenses
        return [
            'profits' => ($profits + $extraProfits) - $expenses,
            'discounts' => $operations->sum('discount'),
            'price' => $operations->sum('price'),
            'sale_price' => $operations->sum('sale_price')
        ];
    }
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {

        $operations = Operation::query();
        $expenses = Expense::query();
        $extraProfits = ExtraProfit::query();
        $monthProfits = $this->profits(
            operations: Operation::whereMonth('created_at', now()->month)->get(),
            extraProfits: ExtraProfit::whereMonth('created_at', now()->month)->sum('amount'),
            expenses: Expense::whereMonth('created_at', now()->month)->sum('amount')
        );
        $threeMonthProfits = $this->profits(
            operations: Operation::whereBetween('created_at',  [now()->subMonths(3), now()])->whereYear('created_at', now()->year)->get(),
            extraProfits: ExtraProfit::whereBetween('created_at',  [now()->subMonths(3), now()])->whereYear('created_at', now()->year)->sum('amount'),
            expenses: Expense::whereBetween('created_at',  [now()->subMonths(3), now()])->whereYear('created_at', now()->year)->sum('amount')
        );
        $sixMonthProfits = $this->profits(
            operations: Operation::whereBetween('created_at',  [now()->subMonths(6), now()])->whereYear('created_at', now()->year)->get(),
            extraProfits: ExtraProfit::whereBetween('created_at',  [now()->subMonths(6), now()])->whereYear('created_at', now()->year)->sum('amount'),
            expenses: Expense::whereBetween('created_at',  [now()->subMonths(6), now()])->whereYear('created_at', now()->year)->sum('amount')
        );
        $yearProfits = $this->profits(
            operations: Operation::whereYear('created_at', date('Y'))->get(),
            extraProfits: ExtraProfit::whereYear('created_at', date('Y'))->sum('amount'),
            expenses: Expense::whereYear('created_at', date('Y'))->sum('amount')
        );
        if ($request->from) {
            $operations = $operations->whereDate('created_at', '>=', $request->from);
            $extraProfits = $extraProfits->whereDate('created_at', '>=', $request->from);
            $expenses = $expenses->whereDate('created_at', '>=', $request->from);
        }
        if ($request->to) {
            $operations = $operations->whereDate('created_at', '<=', $request->to);
            $extraProfits = $extraProfits->whereDate('created_at', '<=', $request->to);
            $expenses = $expenses->whereDate('created_at', '<=', $request->to);
        }
        if (!$request->from && !$request->to) {
            $operations = $operations->whereMonth('created_at',  now()->month);
            $extraProfits = $extraProfits->whereMonth('created_at',  now()->month);
            $expenses = $expenses->whereMonth('created_at',  now()->month);
        }
        //profits
        $extraProfits = $extraProfits->sum('amount');
        $expenses = $expenses->sum('amount');
        $allProfits = $this->profits(
            operations: $operations->get(),
            extraProfits: $extraProfits,
            expenses: $expenses
        );
        $operations = OperationsResource::collection($operations->latest()->paginate(20));
        return inertia('Profits', compact('allProfits', 'extraProfits', 'expenses', 'monthProfits', 'threeMonthProfits', 'sixMonthProfits', 'yearProfits', 'operations'));
    }
}
