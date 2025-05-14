<?php

namespace App\Http\Controllers;

use App\Http\Requests\MerchantProductRequest;
use App\Models\Merchant;
use App\Services\MerchantProductService;

use Illuminate\Http\Request;

class MerchantProductController extends Controller
{
    private MerchantProductService $merchantProductService;

    public function __construct(MerchantProductService $merchantProductService)
    {
        $this->merchantProductService = $merchantProductService;
    }

    //store
    public function store(MerchantProductRequest $request, int $merchant)
    {
        $validated = $request->validated();

        $validated['merchant_id'] = $merchant;

        $merchantProduct = $this->merchantProductService->assignProductToMerchant($validated);

        return response()->json([
            'message' => 'Product assigned to merchant successfully.',
            'data' => $merchantProduct
        ], 201);
    }
}
