<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoardPosition;
use App\Http\Resources\BoardPositionResource;

class BoardPositionController extends Controller
{

   public function index()
    {
        return BoardPositionResource::collection(BoardPosition::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'position' => 'required|string|max:255'
        ]);

        $position = BoardPosition::create($data);

        return new BoardPositionResource($position);
    }

    public function update(Request $request, BoardPosition $boardPosition)
    {
        $data = $request->validate([
            'position' => 'required|string|max:255'
        ]);

        $boardPosition->update($data);

        return new BoardPositionResource($boardPosition);
    }

    public function destroy(BoardPosition $boardPosition)
    {
        $boardPosition->delete();

        return response()->json([
            'message'=>'Position deleted'
        ]);
    }
}
