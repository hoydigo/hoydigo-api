<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StorePoliticalPartyRequest;
use App\Http\Resources\admin\PoliticalPartyCollection;
use App\Models\PoliticalParty;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PoliticalPartyController extends Controller
{
    /**
     * Returns all political parties
     *
     * @return PoliticalPartyCollection
     */
    public function index(): PoliticalPartyCollection
    {
        try {
            $parties = PoliticalParty::all();

            return new PoliticalPartyCollection($parties);

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

    public function show(Request $request, string $political_party_id): JsonResponse
    {
        try {
            $political_party = PoliticalParty::find($political_party_id);

            if (is_null($political_party)) {
                return response()->json(['message' => 'Political party not found'], 404);
            }

            return response()->json(
                [
                    'data'    => $political_party->toArray(),
                ],
                200
            );

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
