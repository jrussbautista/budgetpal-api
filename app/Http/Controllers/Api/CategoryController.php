<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::where('type', 'main')
        ->orWhere('user_id', auth()->id())
        ->get();
        
        return CategoryResource::collection($categories);
    }

    public function show(Category $category) {
        return new CategoryResource($category);
    }

    public function store(Request $request) {

        $fields = $request->validate(['title' => 'required']);

        $category = Category::create([
            'type' => 'custom',
            'title' => $fields['title'],
            'slug' => Str::slug($fields['title']),
            'user_id' => auth()->id()
        ]);
    
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category) {

        $this->authorize('update', $category);

        $fields = $request->validate(['title' => 'required']);

        $category->update($fields);

        return new CategoryResource($category);
    }

    public function destroy(Category $category) {
       
        $this->authorize('delete', $category); 

        $category->delete();

        return response()->noContent();
    }
}
