<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function created(Product $product): void
    {
        activity()
            ->performedOn($product)
            ->withProperties($product->toArray())
            ->log('create');
    }

    public function updated(Product $product): void
    {
        activity()
            ->performedOn($product)
            ->withProperties($product->getChanges())
            ->log('update');
    }

    public function deleted(Product $product): void
    {
        activity()
            ->performedOn($product)
            ->withProperties(['id' => $product->id, 'name' => $product->name])
            ->log('delete');
    }
}