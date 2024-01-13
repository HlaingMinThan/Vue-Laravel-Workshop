<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    //a recipe belongsto a category

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    public function scopeFilter($query, $filters)
    {
        //if filters array has category, we should combine the query
        if (isset($filters['category'])) {
            $query->whereHas('category', function ($catQuery) use ($filters) {
                $catQuery->where('name', $filters['category']);
            });
        }
    }
}
