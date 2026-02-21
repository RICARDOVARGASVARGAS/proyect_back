<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\FindOrFailTrait;
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    use FindOrFailTrait;

    private array $messages = [
        'index'   => 'Categorías encontradas exitosamente',
        'store'   => 'Categoría creada exitosamente',
        'show'    => 'Categoría encontrada exitosamente',
        'update'  => 'Categoría actualizada exitosamente',
        'destroy' => 'Categoría eliminada exitosamente',
    ];

    #[OA\Get(
        path: '/categories',
        summary: 'Listar categorías',
        tags: ['Categorías'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Lista de categorías',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Categorías encontradas exitosamente'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'id', type: 'integer', example: 1),
                                    new OA\Property(property: 'name', type: 'string', example: 'Electrónica'),
                                    new OA\Property(property: 'description', type: 'string', example: 'Productos electrónicos'),
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
        $categories = Category::all();
        return CategoryResource::collection($categories)->additional([
            'success' => true,
            'message' => $this->messages['index'],
        ]);
    }

    #[OA\Post(
        path: '/categories',
        summary: 'Crear categoría',
        tags: ['Categorías'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Electrónica'),
                    new OA\Property(property: 'description', type: 'string', example: 'Productos electrónicos'),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Categoría creada'),
            new OA\Response(
                response: 422,
                description: 'Error de validación',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'The name field is required.'),
                        new OA\Property(
                            property: 'errors',
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'name',
                                    type: 'array',
                                    items: new OA\Items(type: 'string', example: 'The name field is required.')
                                ),
                            ]
                        ),
                    ]
                )
            ),
        ]
    )]
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return CategoryResource::make($category)->additional([
            'success' => true,
            'message' => $this->messages['store'],
        ]);
    }

    #[OA\Get(
        path: '/categories/{id}',
        summary: 'Ver categoría',
        tags: ['Categorías'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', example: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Categoría encontrada'),
            new OA\Response(response: 404, description: 'Categoría no encontrada'),
        ]
    )]
    public function show(string $id)
    {
        $category = $this->findOrFailJson(Category::class, $id);
        return CategoryResource::make($category)->additional([
            'success' => true,
            'message' => $this->messages['show'],
        ]);
    }

    #[OA\Put(
        path: '/categories/{id}',
        summary: 'Actualizar categoría',
        tags: ['Categorías'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', example: 1)),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Electrónica'),
                    new OA\Property(property: 'description', type: 'string', example: 'Productos electrónicos'),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Categoría actualizada'),
            new OA\Response(response: 404, description: 'Categoría no encontrada'),
            new OA\Response(response: 422, description: 'Error de validación'),
        ]
    )]
    public function update(CategoryRequest $request, string $id)
    {
        $category = $this->findOrFailJson(Category::class, $id);
        $category->update($request->validated());
        return CategoryResource::make($category)->additional([
            'success' => true,
            'message' => $this->messages['update'],
        ]);
    }

    #[OA\Delete(
        path: '/categories/{id}',
        summary: 'Eliminar categoría',
        tags: ['Categorías'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', example: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Categoría eliminada'),
            new OA\Response(response: 404, description: 'Categoría no encontrada'),
        ]
    )]
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