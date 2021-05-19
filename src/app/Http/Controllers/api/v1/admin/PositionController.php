<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StorePositionRequest;
use App\Http\Requests\admin\UpdatePositionRequest;
use App\Http\Resources\admin\PositionCollection;
use App\Http\Resources\admin\PositionResource;
use App\Models\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Returns all positions
     *
     * It is returning the positions in pagination
     * the amount of positions per page is 20.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $positions = Position::orderBy('name', 'asc')->paginate(20);

            return (new PositionCollection($positions))->response()->setStatusCode(200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @param StorePositionRequest $request
     *
     * @return JsonResponse
     */
    public function store(StorePositionRequest $request): JsonResponse
    {
        try {
            $position = Position::create([
                'id'          => $request->id,
                'country_id'  => $request->country_id,
                'state_id'    => $request->state_id ?? null,
                'city_id'     => $request->city_id ?? null,
                'sector'      => $request->sector,
                'name'        => $request->name,
                'description' => $request->description ?? '',
            ]);

            return response()->json(['message' => 'Position created successfully'], 200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Return a specific position
     *
     * @param Request $request
     * @param string $position_id
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $position_id): JsonResponse
    {
        try {
            $position = Position::find($position_id);

            if (is_null($position)) {
                return response()->json(['message' => 'Position not found'], 404);
            }

            return (new PositionResource($position))->response()->setStatusCode(200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @param UpdatePositionRequest $request
     * @param string $position_id
     *
     * @return JsonResponse
     */
    public function update(UpdatePositionRequest $request, string $position_id): JsonResponse
    {
        try {
            $position = Position::find($position_id);

            if (is_null($position)) {
                return response()->json(['message' => 'Position not found'], 404);
            }

            $position->country_id = $request->country_id ?? $position->country_id;
            $position->state_id = $request->state_id ?? $position->state_id;
            $position->city_id = $request->city_id ?? $position->city_id;
            $position->sector = $request->sector ?? $position->sector;
            $position->name = $request->name ?? $position->name;
            $position->description = $request->description ?? $position->description;

            $position->save();

            return (new PositionResource($position))->response()->setStatusCode(200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @param string $position_id
     *
     * @return JsonResponse
     */
    public function destroy(Request $request, string $position_id): JsonResponse
    {
        try {
            $position = Position::find($position_id);

            if (is_null($position)) {
                return response()->json(['message' => 'Position not found'], 404);
            }

            $position->delete();

            return response()->json(null, 204);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
