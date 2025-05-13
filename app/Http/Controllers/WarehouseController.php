<?php

namespace App\Http\Controllers;

use App\Services\WarehouseService;
use App\Http\Resources\WarehouseResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\WarehouseRequest;

class WarehouseController extends Controller
{
    private $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function index()
    {
        $fields = ['id', 'name', 'photo'];
        $warehouses = $this->warehouseService->getAll($fields ?: ['*']);
        return response()->json(WarehouseResource::collection($warehouses));
    }

    public function show(int $id)
    {
        try {
            $fields = ['id', 'name', 'photo', 'phone'];
            $warehouse = $this->warehouseService->getById($id, $fields);
            return response()->json(new WarehouseResource($warehouse));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Warehouse not found'], 404);
        }
    }

    public function update(WarehouseRequest $request, int $id)
    {
        try {
            $warehouse = $this->warehouseService->update($id, $request->validated());
            return response()->json(new WarehouseResource($warehouse));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Warehouse not found'], 404);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->warehouseService->delete($id);
            return response()->json(['message' => 'Warehouse deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Warehouse not found'], 404);
        }
    }
}
