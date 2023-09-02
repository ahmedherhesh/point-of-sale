<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MasterController;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;

class SettingsController extends MasterController
{
    public $permission = 'إعدادات التطبيق';
    public $can = [
        'إعدادات التطبيق' => ['index', 'storeOrUpdate'],
    ];
    function index()
    {
        return inertia('Settings/Create');
    }
    function storeOrUpdate(SettingRequest $request)
    {
        $setting = Setting::first();
        if (!$setting)
            Setting::create($request->all());
        else
            $setting->update($request->all());
        return redirect()->back();
    }
}
