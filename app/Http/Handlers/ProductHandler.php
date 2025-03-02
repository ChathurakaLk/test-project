<?php

namespace App\Http\Handlers;

use App\Http\Controllers\MediaController;
use App\Http\Services\ProductService;

class ProductHandler
{
    public function __construct(private ProductService $productService)
    {
        //
    }

    public function HandleGetProducts()
    {
        return $this->productService->getAll();
    }

    public function HandleStoreProduct(array $validatedData)
    {
        $product = $this->productService->store($validatedData);

        if (!empty($validatedData['images'])) {
            $modelType = get_class($product);
            $modelId = $product->id;
            $modelCategory = 'product';

            $mediaController = new MediaController();

            $mediaController->saveImages($validatedData, $modelType, $modelId, $modelCategory);

            return $product;
        }
    }

}
