<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OperationsResource;
use App\Models\Expense;
use App\Models\Operation;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    function profits($operations, $expenses)
    {
        $profits = 0;
        foreach ($operations as $operation) {
            $profits += $operation->sale_price - ($operation->price + $operation->discount);
        }
        return $profits - $expenses;
    }
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {

        $operations = Operation::query();
        $expenses = Expense::sum('amount');
        //profits
        $allProfits = $this->profits($operations->get(), $expenses);
        $monthProfits = $this->profits($operations->whereMonth('created_at', date('m'))->get(), Expense::whereMonth('created_at', date('m'))->sum('amount'));
        $threeMonthProfits = $this->profits($operations->whereMonth('created_at', '>', date('m', strtotime('-3months')))->get(), Expense::whereMonth('created_at', '>', date('m', strtotime('-3months')))->sum('amount'));
        $sixMonthProfits = $this->profits($operations->whereMonth('created_at', '>', date('m', strtotime('-6months')))->get(), Expense::whereMonth('created_at', '>', date('m', strtotime('-6months')))->sum('amount'));
        $yearProfits = $this->profits($operations->whereYear('created_at', date('Y'))->get(), Expense::whereYear('created_at', date('Y'))->sum('amount'));
        $operations = OperationsResource::collection($operations->latest()->paginate(50));

        return inertia('Profits', compact('allProfits', 'expenses', 'monthProfits', 'threeMonthProfits', 'sixMonthProfits', 'yearProfits', 'operations'));
    }
    function profitsFilter(Request $request)
    {
        $operations = Operation::query();
        $expenses = Expense::query();
        if ($request->from) {
            $operations = $operations->whereDate('created_at', '>=', $request->from);
            $expenses = $expenses->whereDate('created_at', '>=', $request->from);
        }
        if ($request->to) {
            $operations = $operations->whereDate('created_at', '<=', $request->to);
            $expenses = $expenses->whereDate('created_at', '<=', $request->to);
        }
        if (!$request->from && !$request->to)
            return response()->json([], 422);
        return  [
            'operations' => OperationsResource::collection($operations->latest()->paginate(50)),
            'allProfits' => $this->profits($operations->get(), $expenses->sum('amount'))
        ];
    }
}
