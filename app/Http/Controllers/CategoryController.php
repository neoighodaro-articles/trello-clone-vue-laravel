<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all()->toArray());
    }

    public function store(Request $request)
    {
        $category = Category::create($request->only('name'));

        return response()->json([
            'status' => (bool)$category,
            'message' => $category ? 'Category Created' : 'Error Creating Category'
        ]);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function tasks(Category $category)
    {
        return response()->json($category->tasks()->orderBy('order')->get());
    }

    public function update(Request $request, Category $category)
    {
        $status = $category->update($request->only('name'));

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Category Updated!' : 'Error Updating Category'
        ]);
    }

    public function destroy(Category $category)
    {
        $status = $category->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Category Deleted' : 'Error Deleting Category'
        ]);
    }
}
