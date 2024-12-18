<?php

namespace App\Http\Controllers\Api;

//import model Post
use App\Models\businessProfile;
use App\Http\Controllers\Controller;
//import resource PostResource
use App\Http\Resources\businessProfileResource;
//import Http request
use Illuminate\Http\Request;
//import facade Validator
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class businessProfileController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $businessProfile = businessProfile::latest()->paginate(5);

        //return collection of posts as a resource
        return new businessProfileResource(true, 'List Data Posts', $businessProfile);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        // Check if the user already has a business profile
        $existingProfile = businessProfile::where('userID', Auth::id())->first();
        if ($existingProfile) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a business profile.'
            ], 409); // 409 Conflict
        }

        //define validation rules
        $validator = Validator::make($request->all(), [
            'business_name'     => 'required|string|max:255',
            'business_address'  => 'required|string|max:255',
            'SIUP'              => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bank_account'      => 'required|string|max:255',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload SIUP
        $SIUP = $request->file('SIUP');
        $SIUP->storeAs('SIUP', $SIUP->hashName(), 'public');

        //create post
        $businessProfile = businessProfile::create([
            'userID'            => Auth::id(),
            'business_name'     => $request->business_name,
            'business_address'  => $request->business_address,
            'SIUP'              => $SIUP->hashName(),
            'bank_account'      => $request->bank_account,
            'verified_status'   => 0, // Set verified status to 0
        ]);

        //return response
        return new businessProfileResource(true, 'Business profile created successfully', $businessProfile);
    }


    //Show by user token logged in
    public function show()
    {
        $businessProfile = BusinessProfile::where('userID', Auth::id())->first();

        if (!$businessProfile) {
            return response()->json([
                'success' => false,
                'message' => 'No business profile found for this user.'
            ], 404);
        }

        return new businessProfileResource(true, 'Business profile retrieved successfully', $businessProfile);
    }

    
}
