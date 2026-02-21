<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\FindOrFailTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use FindOrFailTrait;

    private array $messages = [
        'index' => 'Categorías encontradas exitosamente',
        'store' => 'Categoría creada exitosamente',
        'show' => 'Categoría encontrada exitosamente',
        'update' => 'Categoría actualizada exitosamente',
        'destroy' => 'Categoría eliminada exitosamente',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories)->additional([
            'success' => true,
            'message' => $this->messages['index'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return CategoryResource::make($category)->additional([
            'success' => true,
            'message' => $this->messages['store'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $category = $this->findOrFailJson(Category::class, $id);
        return CategoryResource::make($category)->additional([
            'success' => true,
            'message' => $this->messages['show'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = $this->findOrFailJson(Category::class, $id);
        $category->update($request->validated());
        return CategoryResource::make($category)->additional([
            'success' => true,
            'message' => $this->messages['update'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->findOrFailJson(Category::class, $id);
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => $this->messages['destroy'],
        ]);
    }
}
