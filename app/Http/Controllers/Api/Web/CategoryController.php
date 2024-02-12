<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get categories
        $categories = Category::latest()->get();

        //return with Api Resource
        return new CategoryResource(true, 'List Data Categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $category = Category::with('places.category', 'places.images')->where('slug', $slug)->first();

        if ($category) {
            //return success with Api Resource
            return new CategoryResource(true, 'List Data Places By : ' . $category->name, $category);
        }

        //return failed with Api Resource
        return new CategoryResource(false, 'Data Category Tidak Ditemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
