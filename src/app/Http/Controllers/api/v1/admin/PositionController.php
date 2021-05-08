<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StorePositionRequest;
use App\Models\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
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
     * @param StorePositionRequest $request
     *
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/v1/admin/position",
     *     tags={"Admin - Position"},
     *     summary="Create a new position",
     *     description="Create a new position",
     *     operationId="createPosition",
     *     security={{ "bearer": {} }},
     *     @OA\RequestBody(
     *      required=true,
     *      description="Fields for the new position",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *              @OA\Property(property="id", type="string", format="text", example="MYPOS", description="Id for the new position"),
     *              @OA\Property(property="country_id", type="string", example="COL", description="Country id where the position is"),
     *              @OA\Property(property="state_id", type="integer", example="5", description="The state id should be in the country indicated"),
     *              @OA\Property(property="city_id", type="integer", example="1017", description="The city id should be in the state and country indicated"),
     *              @OA\Property(property="sector", type="string", example="Politico", description="Sector where the position works"),
     *              @OA\Property(property="name", type="string", example="Senador de la Republica"),
     *              @OA\Property(property="description", type="string", example="Descripción del cargo de senador"),
     *          ),
     *      ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Position created",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Position created successfully"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", format="text", example="Unauthenticated"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="User without permission to the endpoint",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", format="text", example="Permission denied."),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", example="{'field':['Error message']}"),
     *         ),
     *     ),
     * )
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
     * @param Request $request
     * @param string $position_id
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $position_id): JsonResponse
    {
        try {
            return response()->json(['message' => 'Showing'], 200);

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
    public function update(Request $request, string $position_id): JsonResponse
    {
        try {
            return response()->json(['message' => 'Updating'], 200);

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
            return response()->json(['message' => 'Deleting'], 200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
