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
