<?php

namespace App\Repositories;

use App\Models\Warehouse;

class WarehouseRepository
{
    public function getAll(array $fields)
    {
        return Warehouse::select($fields)->with('product', 'category')->latest()->paginate(10);
    }

    public function getById(int $id, array $fields)
    {
        return Warehouse::select($fields)->with('product', 'category')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Warehouse::create($data);
    }

    public function update(int $id, array $data)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update($data);
        return $warehouse;
    }

    public function delete(int $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();
    }
}
