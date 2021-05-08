<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StorePoliticalPartyRequest;
use App\Http\Requests\admin\UpdatePoliticalPartyRequest;
use App\Http\Resources\admin\PoliticalPartyCollection;
use App\Http\Resources\admin\PoliticalPartyResource;
use App\Models\PoliticalParty;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PoliticalPartyController extends Controller
{
    /**
     * Returns all political parties
     *
     * It is returning the political parties in pagination
     * the amount of parties per page is 20.
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/v1/admin/political-party?page=1",
     *     tags={"Admin - Political Party"},
     *     summary="List of the political parties",
     *     description="List of the political parties",
     *     operationId="listPoliticalParties",
     *     security={{ "bearer": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="List of political parties",
     *         @OA\JsonContent(
     *              @OA\Property(property="data", type="array", example={{"id": "MIPA2", "name": "Mi partido", "description": "Description del partido", "political_position": {"id": "CEN","name": "Centro", "description": "Se conoce por centro ..."}}, {"id": "MIPAR", "name": "Mi partido", "description": "Description del partido", "political_position": {"id": "CEN","name": "Centro", "description": "Se conoce por centro ..."}}},
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", format="text", example="CECOL"),
     *                      @OA\Property(property="name", type="string", format="email", example="Centro Colombia"),
     *                      @OA\Property(property="description", type="string", format="text", example="Descripcion de centro colombia"),
     *                      @OA\Property(
     *                          property="political_position",
     *                          type="array",
     *                          example={"id": "CEN","name": "Centro", "description": "Se conoce por centro ..."},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="string", example="CEN"),
     *                              @OA\Property(property="name", type="string", example="Centro"),
     *                              @OA\Property(property="description", type="string", example="Se conoce por centro ...")
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
            $parties = PoliticalParty::orderBy('name', 'asc')->paginate(20);

            return (new PoliticalPartyCollection($parties))->response()->setStatusCode(200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Create a new political party
     *
     * @param StorePoliticalPartyRequest $request
     *
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/v1/admin/political-party",
     *     tags={"Admin - Political Party"},
     *     summary="Create a new political party",
     *     description="Create a new political party",
     *     operationId="createPoliticalParty",
     *     security={{ "bearer": {} }},
     *     @OA\RequestBody(
     *      required=true,
     *      description="Fields for the new political party",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *              @OA\Property(property="id", type="string", format="text", example="CECOL"),
     *              @OA\Property(property="political_position_id", type="string", example="CEN"),
     *              @OA\Property(property="name", type="string", example="Partido Politico"),
     *              @OA\Property(property="description", type="string", example="Descripción partido politico"),
     *          ),
     *      ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Political party created",
     *         @OA\JsonContent(
     *              @OA\Property(property="data", type="array", example={"id": "MIPAR", "name": "Mi partido", "description": "Description del partido", "political_position": {"id": "CEN","name": "Centro", "description": "Se conoce por centro ..."}},
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", format="text", example="CECOL"),
     *                      @OA\Property(property="name", type="string", format="email", example="Centro Colombia"),
     *                      @OA\Property(property="description", type="string", format="text", example="Descripcion de centro colombia"),
     *                      @OA\Property(
     *                          property="political_position",
     *                          type="array",
     *                          example={"id": "CEN","name": "Centro", "description": "Se conoce por centro ..."},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="string", example="CEN"),
     *                              @OA\Property(property="name", type="string", example="Centro"),
     *                              @OA\Property(property="description", type="string", example="Se conoce por centro ...")
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
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", example="{'field':['Error message']}"),
     *         ),
     *     ),
     * )
     */
    public function store(StorePoliticalPartyRequest $request): JsonResponse
    {
        try {
            $political_party = PoliticalParty::create([
                'id'                    => $request->id,
                'political_position_id' => $request->political_position_id,
                'name'                  => $request->name,
                'description'           => $request->description,
            ]);

            return response()->json(['message' => 'Political party created successfully'], 200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Returns a specific political party
     *
     * @param Request $request
     * @param string $political_party_id
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/v1/admin/political-party/{political_party_id}",
     *     tags={"Admin - Political Party"},
     *     summary="Get a specific political party",
     *     description="Get a specific political party",
     *     operationId="getPoliticalParty",
     *     security={{ "bearer": {} }},
     *     @OA\Parameter(name="political_party_id", in="path", required=true, example="CECOL"),
     *     @OA\Response(
     *         response=200,
     *         description="Specific political party",
     *         @OA\JsonContent(
     *              @OA\Property(property="data", type="array", example={"id": "MIPAR", "name": "Mi partido", "description": "Description del partido", "political_position": {"id": "CEN","name": "Centro", "description": "Se conoce por centro ..."}},
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", format="text", example="CECOL"),
     *                      @OA\Property(property="name", type="string", format="email", example="Centro Colombia"),
     *                      @OA\Property(property="description", type="string", format="text", example="Descripcion de centro colombia"),
     *                      @OA\Property(
     *                          property="political_position",
     *                          type="array",
     *                          example={"id": "CEN","name": "Centro", "description": "Se conoce por centro ..."},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="string", example="CEN"),
     *                              @OA\Property(property="name", type="string", example="Centro"),
     *                              @OA\Property(property="description", type="string", example="Se conoce por centro ...")
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
     *              @OA\Property(property="message", type="string", format="text", example="Political party not found"),
     *         ),
     *     ),
     * )
     */
    public function show(Request $request, string $political_party_id): JsonResponse
    {
        try {
            $political_party = PoliticalParty::find($political_party_id);

            if (is_null($political_party)) {
                return response()->json(['message' => 'Political party not found'], 404);
            }

            return (new PoliticalPartyResource($political_party))->response()->setStatusCode(200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update a specific political party
     *
     * @param UpdatePoliticalPartyRequest $request
     * @param string $political_party_id
     *
     * @return JsonResponse
     *
     * @OA\Patch(
     *     path="/api/v1/admin/political-party/{political_party_id}",
     *     tags={"Admin - Political Party"},
     *     summary="Update a specific political party",
     *     description="Update a specific political party",
     *     operationId="updatePoliticalParty",
     *     security={{ "bearer": {} }},
     *     @OA\Parameter(name="political_party_id", in="path", required=true, example="CECOL"),
     *     @OA\RequestBody(
     *      required=true,
     *      description="Fields to update",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *              @OA\Property(property="political_position_id", type="string", example="CEN"),
     *              @OA\Property(property="name", type="string", example="Partido Politico"),
     *              @OA\Property(property="description", type="string", example="Descripción partido politico"),
     *          ),
     *      ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Political party updated",
     *         @OA\JsonContent(
     *              @OA\Property(property="data", type="array", example={"id": "MIPAR", "name": "Mi partido", "description": "Description del partido", "political_position": {"id": "CEN","name": "Centro", "description": "Se conoce por centro ..."}},
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", format="text", example="CECOL"),
     *                      @OA\Property(property="name", type="string", format="email", example="Centro Colombia"),
     *                      @OA\Property(property="description", type="string", format="text", example="Descripcion de centro colombia"),
     *                      @OA\Property(
     *                          property="political_position",
     *                          type="array",
     *                          example={"id": "CEN","name": "Centro", "description": "Se conoce por centro ..."},
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="string", example="CEN"),
     *                              @OA\Property(property="name", type="string", example="Centro"),
     *                              @OA\Property(property="description", type="string", example="Se conoce por centro ...")
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
     *              @OA\Property(property="message", type="string", format="text", example="Political party not found"),
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
    public function update(UpdatePoliticalPartyRequest $request, string $political_party_id): JsonResponse
    {
        try {
            $political_party = PoliticalParty::find($political_party_id);

            if (is_null($political_party)) {
                return response()->json(['message' => 'Political party not found'], 404);
            }

            $political_party->political_position_id = $request->political_position_id ?? $political_party->political_position_id;
            $political_party->name = $request->name ?? $political_party->name;
            $political_party->description = $request->description ?? $political_party->description;

            $political_party->save();

            return (new PoliticalPartyResource($political_party))->response()->setStatusCode(200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a political party
     *
     * @param Request $request
     * @param string $political_party_id
     *
     * @return JsonResponse
     *
     * @OA\Delete(
     *     path="/api/v1/admin/political-party/{political_party_id}",
     *     tags={"Admin - Political Party"},
     *     summary="Delete a specific political party",
     *     description="Delete a specific political party",
     *     operationId="deletePoliticalParty",
     *     security={{ "bearer": {} }},
     *     @OA\Parameter(name="political_party_id", in="path", required=true, example="CECOL"),
     *     @OA\Response(response=204, description="null"),
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
     *              @OA\Property(property="message", type="string", format="text", example="Political party not found"),
     *         ),
     *     ),
     * )
     */
    public function destroy(Request $request, string $political_party_id): JsonResponse
    {
        try {
            $political_party = PoliticalParty::find($political_party_id);

            if (is_null($political_party)) {
                return response()->json(['message' => 'Political party not found'], 404);
            }

            $political_party->delete();

            return response()->json(null, 204);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
