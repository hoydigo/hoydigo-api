<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Events\InfluencerTwitterDataRequested;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreInfluencerRequest;
use App\Http\Requests\admin\UpdateInfluencerRequest;
use App\Http\Resources\admin\InfluencerCollection;
use App\Http\Resources\admin\InfluencerResource;
use App\Models\Influencer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

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
     */
    public function store(StoreInfluencerRequest $request): JsonResponse
    {
        try {
            $influencer = Influencer::create([
                'country_id'            => $request->country_id,
                'political_position_id' => $request->political_position_id,
                'political_party_id'    => $request->political_party_id ?? null,
                'name'                  => $request->name,
                'twitter_username'      => preg_replace('/^@/', '', $request->twitter_username),
                'status'                => Config::get('influencer.status.pending'),
            ]);
            $influencer->refresh();

            event(new InfluencerTwitterDataRequested($influencer));

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
     * Update a specific influencer
     *
     * @param UpdateInfluencerRequest $request
     * @param string $influencer_id
     *
     * @return JsonResponse
     */
    public function update(UpdateInfluencerRequest $request, string $influencer_id): JsonResponse
    {
        try {
            $influencer = Influencer::find($influencer_id);

            if (is_null($influencer)) {
                return response()->json(['message' => 'Influencer not found'], 404);
            }

            $influencer->country_id = $request->country_id ?? $influencer->country_id;
            $influencer->political_position_id = $request->political_position_id ?? $influencer->political_position_id;
            $influencer->political_party_id = $request->political_party_id ?? $influencer->political_party_id;
            $influencer->name = $request->name ?? $influencer->name;
            $influencer->twitter_username = $request->twitter_username ?? $influencer->twitter_username;
            $influencer->status = $request->twitter_username ? Config::get('influencer.status.pending') : $influencer->status;

            $influencer->save();

            return (new InfluencerResource($influencer))->response()->setStatusCode(200);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a influencer by Id
     *
     * @param Request $request
     * @param string $influencer_id
     *
     * @return JsonResponse
     */
    public function destroy(Request $request, string $influencer_id): JsonResponse
    {
        try {
            $influencer = Influencer::find($influencer_id);

            if (is_null($influencer)) {
                return response()->json(['message' => 'Influencer not found'], 404);
            }

            $influencer->delete();

            return response()->json(null, 204);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Set an influenter twitter data request
     *
     * @param string $influencer_id
     *
     * @return JsonResponse
     */
    public function pullTwitterData(string $influencer_id): JsonResponse
    {
        try {
            $influencer = Influencer::find($influencer_id);

            if (is_null($influencer)) {
                return response()->json(['message' => 'Influencer not found'], 404);
            }

            event(new InfluencerTwitterDataRequested($influencer));

            return response()->json(['message' => 'Puller process was set for the influencer.'], 200);

        } catch (\Throwable $e) {
            Log::error(
                'Pull Twitter Data action, ' .
                'event: Error pull twitter data, ' .
                "influencer_id: $influencer_id, " .
                'message: ' . $e->getMessage()
            );

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
