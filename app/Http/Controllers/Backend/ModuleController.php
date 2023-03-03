<?php

namespace App\Http\Controllers\Backend;

use Alert;
use App\Models\Module;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModuleRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Gate;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('index-module'); //authorize this user to access/give aceess to admin dashboard
        $modules=Module::select(['id', 'module_name', 'module_slug', 'updated_at'])->latest()->get();
        // return $modules;
        return view('admin.pages.module.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create-module'); //authorize this user to access/give aceess to admin dashboard
        return view('admin.pages.module.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleRequest $request)
    {
        Gate::authorize('create-module'); //authorize this user to access/give aceess to admin dashboard
        Module::updateOrCreate([
            'module_name'=>$request->module_name,
            'module_slug'=>Str::slug($request->module_name)
        ]);
        Toastr::success('Module Created Successfully!');
        return redirect()->route('module.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('edit-module'); //authorize this user to access/give aceess to admin dashboard
        $module=Module::find($id);
        return view('admin.pages.module.edite', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleRequest $request, $id)
    {
        Gate::authorize('edit-module'); //authorize this user to access/give aceess to admin dashboard
        $module=Module::find($id);
        $module->update([
            'module_name'=>$request->module_name,
            'module_slug'=>Str::slug($request->module_name)
        ]);
        Toastr::success('Module Updated successfully!');
        return redirect()->route('module.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('delete-module'); //authorize this user to access/give aceess to admin dashboard
        // dd($id);
        $module=Module::find($id);
        $module->delete();
        Toastr::success('Module Deleted successfully!');
        return redirect()->route('module.index');
    }
}
