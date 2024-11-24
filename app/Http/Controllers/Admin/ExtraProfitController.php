<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MasterController;
use App\Http\Requests\ExtraProfitRequest;
use App\Http\Resources\ExtraProfitsResource;
use App\Models\ExtraProfit;
use Illuminate\Http\Request;

class ExtraProfitController extends MasterController
{
    public $permission = 'الأرباح الإضافية';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $extraProfits = ExtraProfit::query();
        if ($request->from)
            $extraProfits->whereDate('created_at', '>=', $request->from);
        if ($request->to)
            $extraProfits->whereDate('created_at', '<=', $request->to);
        if (!$request->from && !$request->to)
            $extraProfits->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
        $sumExtraProfits = $extraProfits->sum('amount');
        $extraProfits = ExtraProfitsResource::collection($extraProfits->latest()->paginate(100));
        return inertia('ExtraProfits/ExtraProfits', compact('extraProfits', 'sumExtraProfits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('ExtraProfits/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExtraProfitRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->user()->id;
        ExtraProfit::create($data);
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
    public function edit(ExtraProfit $extraProfit)
    {
        return inertia('ExtraProfits/Edit', compact('extraProfit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExtraProfitRequest $request, ExtraProfit $extraProfit)
    {
        $extraProfit->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExtraProfit $extraProfit)
    {
        $extraProfit->delete();
    }
}
