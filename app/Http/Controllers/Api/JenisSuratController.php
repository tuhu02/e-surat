<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JenisSuratResource;
use App\Models\JenisSurat;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class JenisSuratController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $jenisSurat = JenisSurat::all();

        return $this->successResponse(JenisSuratResource::collection($jenisSurat));
    }
}
