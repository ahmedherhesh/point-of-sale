<?php

namespace App\Http\Controllers;

use App\Http\Requests\DebitRequest;
use App\Http\Requests\PayOfTheDebitRequest;
use App\Http\Resources\DebitResource;
use App\Models\Client;
use App\Models\Debit;
use App\Models\PayOfTheDebit;
use Illuminate\Http\Request;

class DebitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $debits = DebitResource::collection(
            Debit::when(trim($request->q), function ($query, $terms) {
                $query->whereHas('client', function ($query) use ($terms) {
                    $query->where('name', 'like', "%{$terms}%");
                    $query->orWhere('phone', 'like', "%{$terms}%");
                    $query->orWhere('national_id', '=', "%{$terms}%");
                });
            })->latest()->paginate(50)
        );
        // get total debit
        $totalDebit = Debit::where('type', 'debit')->when($request->q, function ($query, $terms) {
            $query->whereHas('client', function ($query) use ($terms) {
                $query->where('name', 'like', "%{$terms}%");
                $query->orWhere('phone', 'like', "%{$terms}%");
                $query->orWhere('national_id', '=', "%{$terms}%");
            });
        })->get()->sum(function (Debit $debit) {
            return $debit->left_amount;
        });
        // get total credit
        $totalCredit = Debit::where('type', 'credit')->when($request->q, function ($query, $terms) {
            $query->whereHas('client', function ($query) use ($terms) {
                $query->where('name', 'like', "%{$terms}%");
                $query->orWhere('phone', 'like', "%{$terms}%");
                $query->orWhere('national_id', '=', "%{$terms}%");
            });
        })->get()->sum(function (Debit $debit) {
            return $debit->left_amount;
        });
        // return data
        return match ($request->output_type) {
            'json' => $debits->additional([
                'totalDebit' => $totalDebit,
                'totalCredit' => $totalCredit
            ]),
            default => inertia('Debits/Index', compact('debits', 'totalDebit', 'totalCredit')),
        };
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::take(15)->latest()->get();
        return inertia('Debits/Create', compact('clients'));
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
        $debit = DebitResource::make($debit);
        return inertia('Debits/Pay', compact('debit'));
    }
    public function payOfTheDebitStore(PayOfTheDebitRequest $request)
    {
        $amount = $request->type == 'full' ? $request->debit->left_amount : $request->amount;
        PayOfTheDebit::create(
            array_merge($request->validated(), ['amount' => $amount])
        );
        return redirect()->to(route('debits.index'))->with('success', 'تم دفع الدين بنجاح');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Debit $debit)
    {
        $debit = DebitResource::make($debit);
        $clients = Client::take(15)->latest()->get();
        return inertia('Debits/Edit', compact('debit', 'clients'));
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
