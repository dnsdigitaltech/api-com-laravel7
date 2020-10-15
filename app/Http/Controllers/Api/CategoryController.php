<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreUpdateCategoryFormRequest;

class CategoryController extends Controller
{
    private $category, $totalPage = 10;
    public function __construct(Category $category){
        $this->category = $category;
    }

    public function index(Request $request){
        $categories = $this->category->getResults($request->name);
        return response()->json($categories);
    }

    public function show($id){
        $category = $this->category->find($id);
        if(!$category)
            return response()->json(['error' => 'Not found'], 404);
        return response()->json($category);
    }

    public function store(StoreUpdateCategoryFormRequest $request){
        $category = $this->category->create($request->all());
        return response()->json($category, 201);
    }

    public function update(StoreUpdateCategoryFormRequest $request, $id){
        $category = $this->category->find($id);
        if(!$category)
            return response()->json(['error' => 'Not found'], 404);
        $category->update($request->all());
        return response()->json($category);
    }

    public function destroy($id){
        $category = $this->category->find($id);
        if(!$category)
            return response()->json(['error' => 'Not found'], 404);
        $category->delete();
        return response()->json(['success' => 'ok'], 204);
    }

    public function products($id){
        $category = $this->category->find($id);
        if(!$category)
            return response()->json(['error' => 'Not found'], 404);
        
        $products = $category->products()->paginate($this->totalPage);

        return response()->json([
            'category' => $category,
            'products' => $products
        ]);
    }
}
