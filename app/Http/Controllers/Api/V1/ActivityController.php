<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityRequest;
use App\Models\Activity;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use Illuminate\Http\Request;


class ActivityController extends Controller
{


    public function store(StoreActivityRequest $request)
    {
        $data = $request->validated();

        // 🚀 SWITCHING TO S3 (BACKBLAZE)
        if ($request->hasFile('image')) {
            $data['image_path'] =
                $request->file('image')->store('activities', 's3');
        }

        $activity = Activity::create($data);

        return new ActivityResource($activity);
    }

    public function index()
    {
        $activities = Activity::latest()->paginate(10);

        return ActivityResource::collection($activities);
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {

            // ✅ delete old image from S3
            if ($activity->image_path) {
                Storage::disk('s3')->delete($activity->image_path);
            }

            // ✅ store new image in S3
            $data['image_path'] =
                $request->file('image')->store('activities', 's3');
        }

        $activity->update($data);

        return new ActivityResource($activity);
    }

    public function destroy(Activity $activity)
    {
        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
        }

        $activity->delete();

        return response()->json([
            'message' => 'Activity deleted successfully.'
        ]);
    }
}