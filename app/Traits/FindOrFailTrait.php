<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;

trait FindOrFailTrait
{
    protected function findOrFailJson(string $modelClass, int|string $id, string $message = 'Recurso no encontrado'): mixed
    {
        $record = $modelClass::find($id);
        if (!$record) {
            throw new ModelNotFoundException($message);
        }
        return $record;
    }
}
