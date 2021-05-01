<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StorePoliticalPartyRequest;
use App\Models\PoliticalParty;
use Illuminate\Http\JsonResponse;

class PoliticalPartyController extends Controller
{
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
}
