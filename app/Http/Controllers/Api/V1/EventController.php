<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        return EventResource::collection(
            $query->latest()->get()
        );
    }

   

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        
         // 🚀 SWITCHING TO S3 (BACKBLAZE)

        // if ($request->hasFile('image')) {
        //     $data['image'] = $request
        //         ->file('image')
        //         ->store('events', 'public');
        // }
        
        // 1. Photo (Was 'public')
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 's3');
        }

        $event = Event::create($data);

        return new EventResource(
            $event->load('category')
        );
    }

   public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('events', 's3');
        }

        $event->update($data);

        return new EventResource(
            $event->load('category')
        );
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
