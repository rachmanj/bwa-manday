<?php

namespace App\Services;

use App\Repositories\WarehouseProductRepository;
use App\Repositories\MerchantProductRepository;
use App\Repositories\MerchantRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MerchantProductService
{
    private MerchantProductRepository $merchantProductRepository;
    private WarehouseProductRepository $warehouseProductRepository;
    private MerchantRepository $merchantRepository;

    public function __construct(
        MerchantProductRepository $merchantProductRepository,
        WarehouseProductRepository $warehouseProductRepository,
        MerchantRepository $merchantRepository
    ) {
        $this->merchantProductRepository = $merchantProductRepository;
        $this->warehouseProductRepository = $warehouseProductRepository;
        $this->merchantRepository = $merchantRepository;
    }


    /**
     * Assign a product to a merchant.
     *
     * @param array $data
     * @return \App\Models\MerchantProduct
     * @throws \Illuminate\Validation\ValidationException
     */
    public function assignProductToMerchant(array $data)
    {
        return DB::transaction(function () use ($data) {
            $warehouseProduct = $this->warehouseProductRepository->getByWarehouseAndProduct(
                $data['warehouse_id'],
                $data['product_id']
            );

            if (!$warehouseProduct || $warehouseProduct->stock < $data['stock']) {
                throw ValidationException::withMessages([
                    'stock' => ['Insufficient stock in the warehouse.']
                ]);
            }

            $existingProduct = $this->merchantProductRepository->getByMerchantAndProduct(
                $data['merchant_id'],
                $data['product_id']
            );

            if ($existingProduct) {
                throw ValidationException::withMessages([
                    'product_id' => ['Product already assigned to this merchant.']
                ]);
            }

            // kurangi stock produk tsb pada warehouse terkait
            return $this->merchantProductRepository->create([
                'warehouse_id' => $data['warehouse_id'],
                'merchant_id' => $data['merchant_id'],
                'product_id' => $data['product_id'],
                'stock' => $data['stock']
            ]);
        });
    }

    public function updateStock(int $merchantId, int $productId, int $newStock, int $warehouseId)
    {
        return DB::transaction(function () use ($merchantId, $productId, $newStock, $warehouseId) {

            $existing = $this->merchantProductRepository->getByMerchantAndProduct($merchantId, $productId);

            if (!$existing) {
                throw ValidationException::withMessages([
                    'product_id' => ['Product not found for this merchant.']
                ]);
            }

            if (!$warehouseId) {
                throw ValidationException::withMessages([
                    'warehouse_id' => ['Warehouse not found.']
                ]);
            }

            $currentStock = $existing->stock;

            if ($newStock > $currentStock) {
                $diff = $newStock - $currentStock;
                $warehouseProduct = $this->warehouseProductRepository->getByWarehouseAndProduct(
                    $warehouseId,
                    $productId
                );

                if (!$warehouseProduct || $warehouseProduct->stock < $diff) {
                    throw ValidationException::withMessages([
                        'stock' => ['Insufficient stock in the warehouse.']
                    ]);
                }

                $this->warehouseProductRepository->updateStock(
                    $warehouseId,
                    $productId,
                    $warehouseProduct->stock - $diff
                );
            }

            if ($newStock < $currentStock) {
                $warehouseProduct = $this->warehouseProductRepository->getByWarehouseAndProduct(
                    $warehouseId,
                    $productId
                );

                if (!$warehouseProduct) {
                    throw ValidationException::withMessages([
                        'warehouse' => ['Product not found in warehouse.']
                    ]);
                }
            }

            return $this->merchantProductRepository->updateStock(
                $merchantId,
                $productId,
                $newStock
            );
        });
    }


    public function removeProductFromMerchant(int $merchantId, int $productId)
    {
        $merchant = $this->merchantRepository->getById($merchantId, $fields ?? ['*']);

        if (!$merchant) {
            throw ValidationException::withMessages([
                'merchant_id' => ['Merchant not found.']
            ]);
        }

        $exists = $this->merchantProductRepository->getByMerchantAndProduct($merchantId, $productId);

        if (!$exists) {
            throw ValidationException::withMessages([
                'product_id' => ['Product not found for this merchant.']
            ]);
        }

        $merchant->products()->detach($productId);
    }
}
