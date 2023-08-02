<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompaniesResource;
use App\Http\Resources\ItemsResource;
use App\Models\Company;
use App\Models\Item;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = CompaniesResource::collection(Company::latest()->paginate(30));
        return inertia('Companies/Companies', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Companies/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        Company::create($request->all());
        return redirect()->back()->with('success', 'تم اضافة الشركة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $items = ItemsResource::collection(Item::whereCompanyId($id)->paginate(18));
        return inertia('Items/Items', compact('items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return inertia('Companies/Edit', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3'
        ], [
            'required' => 'هذا الحقل مطلوب',
            'min' => 'عدد الأحرف يجب ان يكون 3 على الأقل'
        ]);

        $company = Company::find($id);
        if ($company) {
            $company->update($request->all());
            return redirect()->back()->with('success', 'تم تعديل اسم الشركة بنجاح');
        }

        return redirect()->back()->with('failed', 'هذا اسم الشركة غير موجود');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
    }
}
