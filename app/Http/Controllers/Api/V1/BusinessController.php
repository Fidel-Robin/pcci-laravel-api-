<?php

// namespace App\Http\Controllers\Api\V1;
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Resources\BusinessResource;

class BusinessController extends Controller
{

   public function index()
    {
        $businesses = Member::where('status', 'active')
            ->with('applicant') // Essential for performance (prevents N+1 queries)
            // ->paginate();
            ->get();


        return BusinessResource::collection($businesses);
    }

}
