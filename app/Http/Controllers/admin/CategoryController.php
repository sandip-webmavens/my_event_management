<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorys = EventCategory::all();
        return view('admin.category.category-show', compact('categorys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.category-create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = new EventCategory();
        $category->name= $request->name;
        $category->save();
        return redirect(route('category.index'));
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

        $category = EventCategory::find($id);
        return view('admin.category.category-create' , compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = EventCategory::find($id);
        $category->name = $request->name;
        $category->save();
        return redirect(route('category.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = EventCategory::find($id);
        $category->delete();
        return redirect(route('category.index'));
    }
}
