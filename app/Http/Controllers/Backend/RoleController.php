<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use App\Models\Module;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\RoleStoreRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('index-role'); //authorize this user to access/give aceess to admin dashboard
        $roles=Role::with(['permissions:id,permission_name,permission_slug'])->select('id', 'role_name', 'is_deletable', 'updated_at')->get();
        // return $roles;
        return view('admin.pages.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('create-role'); //authorize this user to access/give aceess to admin dashboard
        $modules=Module::with(['permissions:id,module_id,permission_name,permission_slug'])->select('id', 'module_name')->get();
        // return $modules;
        return view('admin.pages.role.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        Gate::authorize('create-role'); //authorize this user to access/give aceess to admin dashboard
        Role::updateOrCreate([
            'role_name'=>$request->role_name,
            'role_slug'=>Str::slug($request->role_name),
            'role_note'=>$request->role_note,
        ])->permissions()->sync($request->input('permissions', []));

        Toastr::success('Role Created Successfully');
        return redirect()->route('role.index');
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
        Gate::authorize('edit-role'); //authorize this user to access/give aceess to admin dashboard
        $role=Role::find($id);
        $modules=Module::with(['permissions:id,module_id,permission_name,permission_slug'])->select(['id', 'module_name'])->get();
        return view('admin.pages.role.edite', compact('role', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('edit-role'); //authorize this user to access/give aceess to admin dashboard
        $role=Role::find($id);
        $role->update([
            'role_name'=>$request->role_name,
            'role_slug'=>Str::slug($request->role_name),
            'role_note'=>$request->role_note,
        ]);

        $role->permissions()->sync($request->input('permissions', []));

        Toastr::success('Role Updated Successfully');
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('delete-role'); //authorize this user to access/give aceess to admin dashboard
        $role=Role::find($id);
        if($role->is_deletable){
            $role->delete();
            Toastr::success('Role deleted Successfully');
        return redirect()->route('role.index');
        }
        Toastr::error("Role can't be Deleted");
        return redirect()->route('role.index');
    }
}
