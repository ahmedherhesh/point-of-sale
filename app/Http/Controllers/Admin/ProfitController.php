<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OperationsResource;
use App\Models\Operation;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        //operations
        $operations = Operation::query();
        $month_operations = $operations->whereMonth('created_at', date('m'))->get();
        $three_month_operations = $operations->whereMonth('created_at', '>', date('m', strtotime('-3months')))->get();
        $six_month_operations   = $operations->whereMonth('created_at', '>', date('m', strtotime('-6months')))->get();
        $year_operations = $operations->whereYear('created_at', date('Y'))->get();
        //profits
        $allProfits = $this->profits($operations);
        $monthProfits = $this->profits($month_operations);
        $threeMonthProfits = $this->profits($three_month_operations);
        $sixMonthProfits = $this->profits($six_month_operations);
        $yearProfits = $this->profits($year_operations);
        $operations = OperationsResource::collection($operations->latest()->paginate(50));
        return inertia('Profits', compact('allProfits', 'monthProfits', 'threeMonthProfits', 'sixMonthProfits', 'yearProfits','operations'));
    }
    function profits($operations)
    {
        foreach ($operations as $operation) {
            return $operation->sale_price - ($operation->price + $operation->discount);
        }
    }
    function profitsFilter(Request $request)
    {
        $operations = Operation::query();
        if ($request->from) {
            $operations = $operations->whereDate('created_at', '>=', $request->from);
        }
        if ($request->to) {
            $operations = $operations->whereDate('created_at', '<=', $request->to);
        }
        if (!$request->from && !$request->to)
            return response()->json([], 404);
        return  [
            'operations' => OperationsResource::collection($operations->latest()->paginate(50)),
            'allProfits' => $this->profits($operations)
        ];
    }
}
