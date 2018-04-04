<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Category::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $category = Category::create($request->only('name'));

        return response()->json([
            'status' => (bool) $category,
            'message'=> $category ? 'Category Created' : 'Error Creating Category'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Display the specified categories' tasks.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function tasks(Category $category)
    {
        return response()->json($category->tasks()->orderBy('order')->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        
        $status = $category->update($request->only('name'));
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Category Updated!' : 'Error Updating Category'      
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $status  = $category->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Category Deleted' : 'Error Deleting Category'
        ]);
    }
}
