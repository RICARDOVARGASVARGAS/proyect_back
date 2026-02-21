# SaaS Products CRUD — Backend

API REST para gestión de productos y categorías construida con Laravel 12.

---

## Requisitos previos

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Laravel 12
- Laragon o similar (para dominio local `proyect.test`)

---

## Instalación y levantar el entorno
```bash
git clone <repositorio>
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

---

## Variables de entorno

Configura tu archivo `.env`:
```
APP_NAME=SaaSProducts
APP_URL=http://proyect.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=saas_products
DB_USERNAME=root
DB_PASSWORD=

L5_SWAGGER_GENERATE_ALWAYS=true
L5_SWAGGER_BASE_PATH=/api
```

---

## URLs base

| Servicio       | URL                                  |
|----------------|--------------------------------------|
| API base       | http://proyect.test/api              |
| Swagger UI     | http://proyect.test/api/documentation|
| Telescope      | http://proyect.test/telescope        |

---

## Endpoints API

| Método | Endpoint              | Descripción          |
|--------|-----------------------|----------------------|
| GET    | /api/categories       | Listar categorías    |
| POST   | /api/categories       | Crear categoría      |
| GET    | /api/categories/{id}  | Ver categoría        |
| PUT    | /api/categories/{id}  | Actualizar categoría |
| DELETE | /api/categories/{id}  | Eliminar categoría   |
| GET    | /api/products         | Listar productos     |
| POST   | /api/products         | Crear producto       |
| GET    | /api/products/{id}    | Ver producto         |
| PUT    | /api/products/{id}    | Actualizar producto  |
| DELETE | /api/products/{id}    | Eliminar producto    |

---

## Estructura del proyecto
```
app/
├── Exceptions/
│   └── ApiNotFoundException.php
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── CategoryController.php
│   │       ├── ProductController.php
│   │       └── SwaggerController.php
│   ├── Requests/
│   │   ├── CategoryRequest.php
│   │   └── ProductRequest.php
│   └── Resources/
│       ├── CategoryResource.php
│       └── ProductResource.php
├── Models/
│   ├── Category.php
│   └── Product.php
├── Observers/
│   ├── CategoryObserver.php
│   └── ProductObserver.php
├── Providers/
│   └── AppServiceProvider.php
└── Traits/
    ├── ApiResponseTrait.php
    └── FindOrFailTrait.php
database/
├── migrations/
│   ├── create_categories_table.php
│   └── create_products_table.php
└── seeders/
    ├── CategorySeeder.php
    ├── ProductSeeder.php
    └── DatabaseSeeder.php
routes/
└── api.php
```

---

## Formato de respuestas JSON

**Éxito:**
```json
{
    "success": true,
    "message": "Producto creado exitosamente",
    "data": {
        "id": 1,
        "name": "Laptop",
        "description": "Laptop gamer",
        "price": "999.99",
        "stock": 10,
        "is_active": true
    }
}
```

**Error de validación (422):**
```json
{
    "success": false,
    "message": "El campo nombre es requerido.",
    "errors": {
        "name": [
            "El campo nombre es requerido."
        ]
    }
}
```

**No encontrado (404):**
```json
{
    "success": false,
    "message": "Recurso no encontrado."
}
```

---

## Manejo de errores

| Código | Situación               | Comportamiento                          |
|--------|-------------------------|-----------------------------------------|
| 422    | Error de validación     | JSON con detalle de errores por campo   |
| 404    | Recurso no encontrado   | JSON con mensaje descriptivo            |
| 500    | Error del servidor      | JSON con mensaje genérico               |

---

## Stack técnico

| Tecnología          | Versión  |
|---------------------|----------|
| Laravel             | 12       |
| PHP                 | >= 8.2   |
| MySQL               | >= 8.0   |
| L5-Swagger          | latest   |
| Laravel Telescope   | latest   |
| Spatie Activity Log | latest   |

---

## Observabilidad — Telescope

Telescope registra en tiempo real todas las peticiones HTTP, queries SQL, excepciones y eventos del modelo.

Accede en: `http://proyect.test/telescope`

---

## Auditoría — Spatie Activity Log

Cada acción de create, update y delete sobre productos y categorías queda registrada automáticamente en la tabla `activity_log` mediante observers.

Consulta el historial directamente en MySQL:
```sql
SELECT * FROM activity_log ORDER BY created_at DESC;
```

---

## Documentación API — Swagger

La documentación interactiva se genera automáticamente desde los atributos PHP en los controllers.

Para regenerar manualmente:
```bash
php artisan l5-swagger:generate
```

Accede en: `http://proyect.test/api/documentation`