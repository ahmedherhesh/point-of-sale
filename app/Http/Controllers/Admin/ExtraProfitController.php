<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MasterController;
use App\Http\Requests\ExtraProfitRequest;
use App\Models\ExtraProfit;
use Illuminate\Http\Request;

class ExtraProfitController extends MasterController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $extraProfits = ExtraProfit::paginate(100);
        return inertia('ExtraProfits/ExtraProfits',compact('extraProfits'));
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
        return inertia('ExtraProfits/Edit',compact('extraProfit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExtraProfitRequest $request,ExtraProfit $extraProfit)
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
