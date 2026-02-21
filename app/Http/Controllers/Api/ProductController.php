<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\FindOrFailTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use FindOrFailTrait;

    private array $messages = [
        'index' => 'Productos encontrados exitosamente',
        'store' => 'Producto creado exitosamente',
        'show' => 'Producto encontrado exitosamente',
        'update' => 'Producto actualizado exitosamente',
        'destroy' => 'Producto eliminado exitosamente',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products)->additional([
            'success' => true,
            'message' => $this->messages['index'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());
        return ProductResource::make($product)->additional([
            'success' => true,
            'message' => $this->messages['store'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        $product = $this->findOrFailJson(Product::class, $id);
        return ProductResource::make($product)->additional([
            'success' => true,
            'message' => $this->messages['show'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = $this->findOrFailJson(Product::class, $id);
        $product->update($request->validated());
        return ProductResource::make($product)->additional([
            'success' => true,
            'message' => $this->messages['update'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->findOrFailJson(Product::class, $id);
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => $this->messages['destroy'],
        ]);
    }
}
