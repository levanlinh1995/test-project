<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->loadPaginate();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $data = $request->all();

        $product = $this->productRepository->create([
            'sku' => $data['sku'],
            'product_name' => $data['product_name'],
            'price' => $data['price'],
            'qty' => $data['qty'],
            'unit' => $data['unit'],
            'status' => $data['status'],
        ]);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request)
    {
        $data = $request->all();

        $product = $this->productRepository->findBySku($data['sku']);

        if (!$product) {
            return response()->json(
                ['message' => 'Product SKU not found!'
            ], Response::HTTP_NOT_FOUND);
        };

        $product = $this->productRepository->update($product->id, [
            'sku' => $data['sku'],
            'product_name' => $data['product_name'],
            'price' => $data['price'],
            'qty' => $data['qty'],
            'unit' => $data['unit'],
            'status' => $data['status'],
        ]);

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->only(['sku']);

        $product = $this->productRepository->findBySku($data['sku']);

        if (!$product) {
            return response()->json(
                ['message' => 'Product SKU not found!'
            ], Response::HTTP_NOT_FOUND);
        };

        $this->productRepository->delete($product->id);

        return response()->json(
            ['message' => 'Deleted successfully.'
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Search for a SKU
     *
     * @param  str  $sku
     * @return \Illuminate\Http\Response
     */
    public function searchBySku(Request $request)
    {
        $data = $request->only(['sku']);

        $products = $this->productRepository->loadPaginate([
            'sku' => $data['sku']
        ]);

        return ProductResource::collection($products);
    }
}
