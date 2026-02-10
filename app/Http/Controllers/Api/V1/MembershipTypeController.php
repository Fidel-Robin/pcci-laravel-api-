<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipTypeRequest;
use App\Http\Resources\MembershipTypeResource;
use App\Models\MembershipType;
use Illuminate\Http\Request;

class MembershipTypeController extends Controller
{
    // List all membership types
    public function index()
    {
        $membershipTypes = MembershipType::all();
        return MembershipTypeResource::collection($membershipTypes);
    }

    // Store new membership type
    public function store(MembershipTypeRequest $request)
    {
        $membershipType = MembershipType::create($request->validated());
        return new MembershipTypeResource($membershipType);
    }

    // Show a specific membership type
    public function show(MembershipType $membershipType)
    {
        return new MembershipTypeResource($membershipType);
    }

    // Update a membership type
    public function update(MembershipTypeRequest $request, MembershipType $membershipType)
    {
        $membershipType->update($request->validated());
        return new MembershipTypeResource($membershipType);
    }

    // Delete a membership type
    public function destroy(MembershipType $membershipType)
    {
        $membershipType->delete();
        return response()->json(['message' => 'Membership type deleted successfully']);
    }
}
