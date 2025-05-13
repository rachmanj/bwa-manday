<?php

namespace App\Services;

use App\Models\WarehouseProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WarehouseProductService
{
    public function getAll(array $fields = ['*'])
    {
        return WarehouseProduct::select($fields)->get();
    }

    public function getById(int $id, array $fields = ['*'])
    {
        return WarehouseProduct::select($fields)->findOrFail($id);
    }

    public function create(array $data)
    {
        return WarehouseProduct::create($data);
    }

    public function update(int $id, array $data)
    {
        $product = WarehouseProduct::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        return WarehouseProduct::findOrFail($id)->delete();
    }
}
