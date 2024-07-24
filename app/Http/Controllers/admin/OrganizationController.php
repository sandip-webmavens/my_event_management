<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizations = Organization::all();
        return view('admin.organization.organization-show' , compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.organization.organization-create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $organization = new Organization();
        $organization->user_id = $request->user_id;
        $organization->name = $request->name;
        $organization->description = $request->description;
        $organization->address = $request->address;
        $organization->phone = $request->phone;
        $organization->save();
        return redirect(route('organization.index'));
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
    public function edit(string $id)
    {
        $organization = Organization::find($id);
        $users = User::all();
        // dd($users);
        return view('admin.organization.organization-edit',compact('organization' , 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $organization =  Organization::find($id);
        $organization->user_id = $request->user_id;
        $organization->name = $request->name;
        $organization->description = $request->description;
        $organization->address = $request->address;
        $organization->phone = $request->phone;
        $organization->save();
        return redirect(route('organization.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $organization =  Organization::find($id);
        $organization->delete();
        return redirect(route('organization.index'));

    }
}
