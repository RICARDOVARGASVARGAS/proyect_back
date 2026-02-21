<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    // Ocultar campos de fecha en la respuesta JSON
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Casteo de campos
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
