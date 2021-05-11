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
     *
     * @OA\Get(
     *     path="/api/v1/admin/position?page=1",
     *     tags={"Admin - Position"},
     *     summary="List of the positions",
     *     description="List of the positions",
     *     operationId="listPositions",
     *     security={{ "bearer": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="List of positions",
     *         @OA\JsonContent(
     *              @OA\Property(property="data", type="array", example={{"id": "MYPOS1", "name": "Senador", "description": "Description del cargo de senador", "country": {"id": "COL","name": "Colombia", "continent": "América del Sur"}, "state": {"id": "5","name": "ANTIOQUIA"}, "city": {"id": "1017","name": "Turbo"}}, {"id": "MYPOS1", "name": "Senador", "description": "Description del cargo de senador", "country": {"id": "COL","name": "Colombia", "continent": "América del Sur"}, "state": {"id": "5","name": "ANTIOQUIA"}, "city": {"id": "1017","name": "Turbo"}}},
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", example="MYPOS1"),
     *                      @OA\Property(property="name", type="string", example="Senador"),
     *                      @OA\Property(property="description", type="string", format="text", example="Descripción cargo de senador"),
     *                      @OA\Property(
     *                          property="country",
     *                          type="array",
     *                          example={"id": "COL","name": "Colombia", "continent": "América del Sur"},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="string", example="COL"),
     *                              @OA\Property(property="name", type="string", example="Colombia"),
     *                              @OA\Property(property="continent", type="string", example="América del Sur")
     *                          ),
     *                      ),
     *                      @OA\Property(
     *                          property="state",
     *                          type="array",
     *                          example={"id": "5","name": "ANTIOQUIA"},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="integer", example="5"),
     *                              @OA\Property(property="name", type="string", example="ANTIOQUIA"),
     *                          ),
     *                      ),
     *                      @OA\Property(
     *                          property="city",
     *                          type="array",
     *                          example={"id": "1017","name": "Turbo"},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="integer", example="1017"),
     *                              @OA\Property(property="name", type="string", example="Turbo"),
     *                          ),
     *                      ),
     *                  ),
     *              ),
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
     *         description="User without permission to thi endpoint",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", format="text", example="Permission denied."),
     *         ),
     *     ),
     * )
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
     * Return a specific position
     *
     * @param Request $request
     * @param string $position_id
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/v1/admin/position/{position_id}",
     *     tags={"Admin - Position"},
     *     summary="Get a specific position",
     *     description="Get a specific position",
     *     operationId="getPosition",
     *     security={{ "bearer": {} }},
     *     @OA\Parameter(name="position_id", in="path", required=true, example="MYPOS1"),
     *     @OA\Response(
     *         response=200,
     *         description="Specific position",
     *         @OA\JsonContent(
     *              @OA\Property(property="data", type="array", example={"id": "MYPOS1", "name": "Senador", "description": "Description del cargo de senador", "country": {"id": "COL","name": "Colombia", "continent": "América del Sur"}, "state": {"id": "5","name": "ANTIOQUIA"}, "city": {"id": "1017","name": "Turbo"}},
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", example="MYPOS1"),
     *                      @OA\Property(property="name", type="string", example="Senador"),
     *                      @OA\Property(property="description", type="string", format="text", example="Descripción cargo de senador"),
     *                      @OA\Property(
     *                          property="country",
     *                          type="array",
     *                          example={"id": "COL","name": "Colombia", "continent": "América del Sur"},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="string", example="COL"),
     *                              @OA\Property(property="name", type="string", example="Colombia"),
     *                              @OA\Property(property="continent", type="string", example="América del Sur")
     *                          ),
     *                      ),
     *                      @OA\Property(
     *                          property="state",
     *                          type="array",
     *                          example={"id": "5","name": "ANTIOQUIA"},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="integer", example="5"),
     *                              @OA\Property(property="name", type="string", example="ANTIOQUIA"),
     *                          ),
     *                      ),
     *                      @OA\Property(
     *                          property="city",
     *                          type="array",
     *                          example={"id": "1017","name": "Turbo"},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="integer", example="1017"),
     *                              @OA\Property(property="name", type="string", example="Turbo"),
     *                          ),
     *                      ),
     *                  ),
     *              ),
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
     *         response=404,
     *         description="Political party not found",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", format="text", example="Position not found"),
     *         ),
     *     ),
     * )
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
     *
     * @OA\Patch(
     *     path="/api/v1/admin/position/{position_id}",
     *     tags={"Admin - Position"},
     *     summary="Update a specific position",
     *     description="Update a specific position",
     *     operationId="updatePosition",
     *     security={{ "bearer": {} }},
     *     @OA\Parameter(name="position_id", in="path", required=true, example="MYPOS1"),
     *     @OA\RequestBody(
     *      required=true,
     *      description="Fields to update",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
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
     *         description="Specific position",
     *         @OA\JsonContent(
     *              @OA\Property(property="data", type="array", example={"id": "MYPOS1", "name": "Senador", "description": "Description del cargo de senador", "country": {"id": "COL","name": "Colombia", "continent": "América del Sur"}, "state": {"id": "5","name": "ANTIOQUIA"}, "city": {"id": "1017","name": "Turbo"}},
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", example="MYPOS1"),
     *                      @OA\Property(property="name", type="string", example="Senador"),
     *                      @OA\Property(property="description", type="string", format="text", example="Descripción cargo de senador"),
     *                      @OA\Property(
     *                          property="country",
     *                          type="array",
     *                          example={"id": "COL","name": "Colombia", "continent": "América del Sur"},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="string", example="COL"),
     *                              @OA\Property(property="name", type="string", example="Colombia"),
     *                              @OA\Property(property="continent", type="string", example="América del Sur")
     *                          ),
     *                      ),
     *                      @OA\Property(
     *                          property="state",
     *                          type="array",
     *                          example={"id": "5","name": "ANTIOQUIA"},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="integer", example="5"),
     *                              @OA\Property(property="name", type="string", example="ANTIOQUIA"),
     *                          ),
     *                      ),
     *                      @OA\Property(
     *                          property="city",
     *                          type="array",
     *                          example={"id": "1017","name": "Turbo"},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="integer", example="1017"),
     *                              @OA\Property(property="name", type="string", example="Turbo"),
     *                          ),
     *                      ),
     *                  ),
     *              ),
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
     *         response=404,
     *         description="Political party not found",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", format="text", example="Position not found"),
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
            return response()->json(['message' => 'Deleting'], 200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
