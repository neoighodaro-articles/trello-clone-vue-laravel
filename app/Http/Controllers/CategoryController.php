<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $categories = Category::all();

        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category([
            'name' => $request->name
        ]);

        $status = $category->save();

        $data = [
            'status' => $status,
            'message'=> $status ? 'Category Created' : 'Error Creating Category'
        ];
        
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category, 200);
    }

    /**
     * Display the specified categories' tasks.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function tasks(Category $category)
    {
        return response()->json($category->tasks()->orderBy('order')->get(), 200);
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
        //
        $status = $category->update([
            'name' => $request->name
        ]);

        $data = [
            'status' => $status,
            'message' => ( $status ) ? 'Category Updated!' : 'Error Updating Category'      
        ];

        return response()->json($data, 200);
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

        $data = [
            'status' => $status,
            'message' => ($status ) ? 'Category Deleted' : 'Error Deleting Category'
        ];

        return response()->json($data, 200);
    }
}
