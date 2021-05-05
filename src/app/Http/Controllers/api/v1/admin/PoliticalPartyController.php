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
     *              required={"email","password"},
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

            return response()->json(
                [
                    'message' => 'User registered successfully',
                    'data'    => $political_party->toArray(),
                ],
                200
            );

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
