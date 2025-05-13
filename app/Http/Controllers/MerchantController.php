<?php

namespace App\Http\Controllers;

use App\Services\MerchantService;
use Illuminate\Http\Request;
use App\Http\Resources\MerchantResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\MerchantRequest;

class MerchantController extends Controller
{
    protected $merchantService;

    public function __construct(MerchantService $merchantService)
    {
        $this->merchantService = $merchantService;
    }

    public function index()
    {
        $fields = ['*'];
        $merchants = $this->merchantService->getAll($fields);
        return response()->json(MerchantResource::collection($merchants));
    }

    public function show($id)
    {
        try {
            $fields = ['*'];
            $merchant = $this->merchantService->getById($id, $fields);
            return response()->json(new MerchantResource($merchant));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Merchant not found'], 404);
        }
    }

    public function store(MerchantRequest $request)
    {
        $merchant = $this->merchantService->create($request->validated());
        return response()->json(new MerchantResource($merchant), 201);
    }
}
