<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InfluencerController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json(['message' => 'Listing'], 200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            return response()->json(['message' => 'Storing'], 200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @param string $influencer_id
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $influencer_id): JsonResponse
    {
        try {
            return response()->json(['message' => 'Showing'], 200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @param string $influencer_id
     *
     * @return JsonResponse
     */
    public function update(Request $request, string $influencer_id): JsonResponse
    {
        try {
            return response()->json(['message' => 'Updating'], 200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @param string $influencer_id
     *
     * @return JsonResponse
     */
    public function destroy(Request $request, string $influencer_id): JsonResponse
    {
        try {
            return response()->json(['message' => 'Deleting'], 200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
