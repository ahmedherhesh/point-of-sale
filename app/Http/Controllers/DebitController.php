<?php

namespace App\Http\Controllers;

use App\Http\Requests\DebitRequest;
use App\Http\Resources\DebitResource;
use App\Models\Debit;
use Illuminate\Http\Request;

class DebitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $debits = Debit::whereDate('created_at', now()->today()->toDateString())->paginate(50);
        return inertia('Debits/Index', [
            'debits' => DebitResource::collection($debits)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Debits/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DebitRequest $request)
    {
        Debit::create($request->validated());
        return redirect()->back()->with('success', 'تم اضافة الدين بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Debit $debit)
    {
        //
    }
    public function payOfTheDebit(Debit $debit)
    {
        
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Debit $debit)
    {
        return inertia('Debits/Edit', [
            'debit' => new DebitResource($debit)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DebitRequest $request, Debit $debit)
    {
        $debit->update($request->validated());
        return redirect()->back()->with('success', 'تم تعديل الدين بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debit $debit)
    {
        $debit->delete();
        return redirect()->back()->with('success', 'تم حذف الدين بنجاح');
    }
}
