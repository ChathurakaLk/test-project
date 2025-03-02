<?php

namespace App\Http\Controllers;

use App\Http\Handlers\ProductHandler;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\ProductCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function __construct(private ProductHandler $productHandler)
    {
        //
    }

    public function index()
    {

        $categories = ProductCategory::cases();
        $products = $this->productHandler->HandleGetProducts();

        return view('products.index', compact('categories', 'products'));
    }
    public function test()
    {

        $categories = ProductCategory::cases();

        return view('home', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $this->productHandler->HandleStoreProduct($validatedData);
            Product::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'product created successfully!'
            ], 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'error!'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $Product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $Product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $Product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $Product)
    {
        //
    }
}
