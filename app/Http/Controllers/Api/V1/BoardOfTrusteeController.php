<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoardOfTrustee;
use App\Http\Resources\BoardOfTrusteeResource;
use App\Http\Requests\StoreBoardOfTrusteeRequest;
use App\Http\Requests\UpdateBoardOfTrusteeRequest;

class BoardOfTrusteeController extends Controller
{
    public function index(Request $request)
    {
        $query = BoardOfTrustee::with('position');

        // Check if 'position' is present in query string
        if ($request->has('position')) {
            $query->where('board_position_id', $request->position);
        }

        $trustees = $query->get();

        return BoardOfTrusteeResource::collection($trustees);
    }


    public function store(StoreBoardOfTrusteeRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('trustees', 'public');
        }

        $trustee = BoardOfTrustee::create($data);

        return new BoardOfTrusteeResource($trustee->load('position'));
    }


   public function update(UpdateBoardOfTrusteeRequest $request, BoardOfTrustee $boardOfTrustee)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('trustees', 'public');
        }

        $boardOfTrustee->update($data);

        return new BoardOfTrusteeResource($boardOfTrustee->load('position'));
    }


    public function destroy(BoardOfTrustee $boardOfTrustee)
    {
        $boardOfTrustee->delete();

        return response()->json([
            'message' => 'Board of trustee deleted successfully'
        ]);
    }

}
