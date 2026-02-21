<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'SaaS Products API',
    version: '1.0.0',
    description: 'API para gestión de productos y categorías'
)]
#[OA\Server(
    url: 'http://proyect.test/api',
    description: 'Servidor local'
)]
class SwaggerController extends Controller {}