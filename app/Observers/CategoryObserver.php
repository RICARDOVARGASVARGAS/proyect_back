<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function created(Category $category): void
    {
        activity()
            ->performedOn($category)
            ->withProperties($category->toArray())
            ->log('create');
    }

    public function updated(Category $category): void
    {
        activity()
            ->performedOn($category)
            ->withProperties($category->getChanges())
            ->log('update');
    }

    public function deleted(Category $category): void
    {
        activity()
            ->performedOn($category)
            ->withProperties(['id' => $category->id, 'name' => $category->name])
            ->log('delete');
    }
}