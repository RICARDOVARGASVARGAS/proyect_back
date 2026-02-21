<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\FindOrFailTrait;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    use FindOrFailTrait;

    private array $messages = [
        'index'   => 'Productos encontrados exitosamente',
        'store'   => 'Producto creado exitosamente',
        'show'    => 'Producto encontrado exitosamente',
        'update'  => 'Producto actualizado exitosamente',
        'destroy' => 'Producto eliminado exitosamente',
    ];

    #[OA\Get(
        path: '/products',
        summary: 'Listar productos',
        tags: ['Productos'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Lista de productos',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Productos encontrados exitosamente'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'id', type: 'integer', example: 1),
                                    new OA\Property(property: 'name', type: 'string', example: 'Laptop'),
                                    new OA\Property(property: 'description', type: 'string', example: 'Laptop gamer'),
                                    new OA\Property(property: 'price', type: 'number', example: 999.99),
                                    new OA\Property(property: 'stock', type: 'integer', example: 10),
                                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                                ]
                            )
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products)->additional([
            'success' => true,
            'message' => $this->messages['index'],
        ]);
    }

    #[OA\Post(
        path: '/products',
        summary: 'Crear producto',
        tags: ['Productos'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'price', 'stock'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Laptop'),
                    new OA\Property(property: 'description', type: 'string', example: 'Laptop gamer'),
                    new OA\Property(property: 'price', type: 'number', example: 999.99),
                    new OA\Property(property: 'stock', type: 'integer', example: 10),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Producto creado'),
            new OA\Response(response: 422, description: 'Error de validación'),
        ]
    )]
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());
        return ProductResource::make($product)->additional([
            'success' => true,
            'message' => $this->messages['store'],
        ]);
    }

    #[OA\Get(
        path: '/products/{id}',
        summary: 'Ver producto',
        tags: ['Productos'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', example: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Producto encontrado'),
            new OA\Response(response: 404, description: 'Producto no encontrado'),
        ]
    )]
    public function show(string $id)
    {
        $product = $this->findOrFailJson(Product::class, $id);
        return ProductResource::make($product)->additional([
            'success' => true,
            'message' => $this->messages['show'],
        ]);
    }

    #[OA\Put(
        path: '/products/{id}',
        summary: 'Actualizar producto',
        tags: ['Productos'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', example: 1)),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Laptop'),
                    new OA\Property(property: 'description', type: 'string', example: 'Laptop gamer'),
                    new OA\Property(property: 'price', type: 'number', example: 999.99),
                    new OA\Property(property: 'stock', type: 'integer', example: 10),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Producto actualizado'),
            new OA\Response(response: 404, description: 'Producto no encontrado'),
            new OA\Response(response: 422, description: 'Error de validación'),
        ]
    )]
    public function update(ProductRequest $request, string $id)
    {
        $product = $this->findOrFailJson(Product::class, $id);
        $product->update($request->validated());
        return ProductResource::make($product)->additional([
            'success' => true,
            'message' => $this->messages['update'],
        ]);
    }

    #[OA\Delete(
        path: '/products/{id}',
        summary: 'Eliminar producto',
        tags: ['Productos'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', example: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Producto eliminado'),
            new OA\Response(response: 404, description: 'Producto no encontrado'),
        ]
    )]
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