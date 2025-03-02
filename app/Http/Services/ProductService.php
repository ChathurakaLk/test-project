<?php

namespace App\Http\Services;

use App\Models\Product;

class ProductService
{
    public function store(array $validatedData)
    {
        return Product::create($validatedData);
    }

    public function getAll()
    {
        return Product::with('media')->get();
    }
}
