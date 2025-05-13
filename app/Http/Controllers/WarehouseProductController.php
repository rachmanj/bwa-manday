<?php

namespace App\Http\Controllers;

use App\Services\WarehouseService;
use Illuminate\Http\Request;
use App\Http\Requests\WarehouseProductRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\WarehouseProductUpdateRequest;

class WarehouseProductController extends Controller
{
    private $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function attach(WarehouseProductRequest $request, int $warehouseId): JsonResponse
    {
        $this->warehouseService->attachProduct(
            $warehouseId,
            $request->input('product_id'),
            $request->input(
                'stock'
            )
        );

        return response()->json([
            'message' => 'Product attached to warehouse successfully'
        ], 200);
    }

    public function detach(int $warehouseId, int $productId): JsonResponse
    {
        $this->warehouseService->detachProduct($warehouseId, $productId);

        return response()->json([
            'message' => 'Product detached from warehouse successfully'
        ], 200);
    }

    public function update(WarehouseProductUpdateRequest $request, int $warehouseId, int $productId): JsonResponse
    {
        $warehouseProduct = $this->warehouseService->updateProductStock(
            $warehouseId,
            $productId,
            $request->validated('stock ')
        );

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $warehouseProduct
        ], 200);
    }
}
