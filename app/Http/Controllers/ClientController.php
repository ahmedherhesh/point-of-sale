<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends MasterController
{
    public $permission = 'العملاء';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::when(trim($request->q), function ($query, $terms) {
            $query->where('name', 'like', "%{$terms}%");
            $query->orWhere('phone', 'like', "%{$terms}%");
            $query->orWhere('national_id', '=', "%{$terms}%");
        })->latest()->paginate(50);

        $clients = ClientResource::collection($clients);

        return match ($request->output_type) {
            'json' => $clients,
            default => inertia('Clients/Index', ['clients' => $clients]),
        };
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Clients/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        Client::create($request->validated());
        return redirect()->back()->with('success', 'تم اضافة العميل بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return inertia('Clients/Edit', ['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        return redirect()->back()->with('success', 'تم تعديل العميل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->back()->with('success', 'تم حذف العميل بنجاح');
    }
}
