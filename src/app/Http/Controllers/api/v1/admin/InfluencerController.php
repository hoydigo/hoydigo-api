<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreInfluencerRequest;
use App\Http\Resources\admin\InfluencerCollection;
use App\Http\Resources\admin\InfluencerResource;
use App\Models\Influencer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class InfluencerController extends Controller
{
    /**
     * List influencers, 20 per page
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $influencers = Influencer::orderBy('name', 'asc')->paginate(20);

            return (new InfluencerCollection($influencers))->response()->setStatusCode(200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Create a new influencer
     *
     * @param StoreInfluencerRequest $request
     *
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/v1/admin/influencer",
     *     tags={"Admin - Influencer"},
     *     summary="Create a new influencer",
     *     description="Create a new influencer",
     *     operationId="createInfluencer",
     *     security={{ "bearer": {} }},
     *     @OA\RequestBody(
     *      required=true,
     *      description="Fields for the new influencer",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *              required={"political_position_id", "name", "twitter_username"},
     *              @OA\Property(property="political_position_id", type="string", format="text", example="CEN", description="Political position ID"),
     *              @OA\Property(property="political_party_id", type="string", example="MIPAR", description="Political party ID"),
     *              @OA\Property(property="name", type="string", example="Pepito Perez", description="Influencer Name"),
     *              @OA\Property(property="image", type="string", description="Path where the image is located"),
     *              @OA\Property(property="twitter_id", type="string", description="TWITTER ID"),
     *              @OA\Property(property="twitter_username", type="string", example="@pepito", description="TWITTER USERNAME"),
     *              @OA\Property(property="twitter_description", type="string", description="Description on twitter"),
     *              @OA\Property(property="twitter_url", type="string", description="Influencer twitter url"),
     *              @OA\Property(property="twitter_verified", type="boolean", description="Boolean value"),
     *          ),
     *      ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Influencer created",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Influencer NAME created successfully"),
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
    public function store(StoreInfluencerRequest $request): JsonResponse
    {
        try {
            $influencer = Influencer::create([
                'country_id'            => $request->country_id,
                'political_position_id' => $request->political_position_id,
                'political_party_id'    => $request->political_party_id ?? null,
                'name'                  => $request->name,
                'image'                 => $request->image ?? null,
                'twitter_id'            => $request->twitter_id ?? null,
                'twitter_username'      => preg_replace('/^@/', '', $request->twitter_username),
                'twitter_description'   => $request->twitter_description ?? null,
                'twitter_url'           => $request->twitter_url ?? null,
                'twitter_verified'      => $request->twitter_verified ?? null,
                'status'                => Config::get('influencer.status.pending'),
            ]);

            return response()->json(['message' => 'Influencer ' . $influencer->name . ' created successfully'], 200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Return a specific influencer by id
     *
     * @param Request $request
     * @param string $influencer_id
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $influencer_id): JsonResponse
    {
        try {

            $influencer = Influencer::find($influencer_id);

            if (is_null($influencer)) {
                return response()->json(['message' => 'Influencer not found'], 404);
            }

            return (new InfluencerResource($influencer))->response()->setStatusCode(200);

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
