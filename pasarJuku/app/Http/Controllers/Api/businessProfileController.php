<?php

namespace App\Http\Controllers\Api;

use App\Models\businessProfile;
use App\Http\Controllers\Controller;
use App\Http\Resources\businessProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function show($id)
    {
        $businessProfile = businessProfile::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Business profile found successfully',
            'data' => $businessProfile
        ], 200);
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
            ], 409);
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
        //upload SIUP
        $SIUP = $request->file('SIUP');
        $SIUPName = $SIUP->hashName();
        $SIUP->storeAs('SIUP', $SIUPName, 'public');
        //create post
        $businessProfile = businessProfile::create([
            'userID'            => Auth::id(),
            'business_name'     => $request->business_name,
            'business_address'  => $request->business_address,
            'SIUP'              => $SIUPName,
            'bank_account'      => $request->bank_account,
            'verified_status'   => 0, // Set verified status to 0
        ]);

        //return response
        return new businessProfileResource(true, 'Business profile created successfully', $businessProfile);
    }

    /**
     * update
     * 
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'business_name'     => 'nullable|string|max:255',
            'business_address'  => 'nullable|string|max:255',
            'SIUP'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bank_account'      => 'nullable|string|max:255',
        ]);

        // Find the business profile by ID
        $businessProfile = businessProfile::findOrFail($id);

        // Check if the authenticated user is the owner of the business profile
        if ($businessProfile->userID !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this business profile.'
            ], 403);
        }

        // Update SIUP if a new file is uploaded
        if ($request->hasFile('SIUP')) {
            // Hapus SIUP lama jika ada
            if ($businessProfile->SIUP) {
                Storage::disk('public')->delete('SIUP/' . $businessProfile->SIUP);
            }

            // Simpan SIUP baru ke storage
            $SIUP = $request->file('SIUP');
            $SIUPname = $SIUP->hashName();
            $SIUP->storeAs('SIUP', $SIUPname, 'public');
            $businessProfile->SIUP = $SIUPname;
        }

        // Update business profile
        $businessProfile->update($request->only(['business_name', 'business_address', 'bank_account']));

        // Return response
        return new businessProfileResource(true, 'Business profile updated successfully', $businessProfile);
    }
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        // Find the business profile by ID
        $businessProfile = businessProfile::findOrFail($id);

        // Check if the authenticated user is the owner of the business profile
        if ($businessProfile->userID !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this business profile.'
            ], 403);
        }

        // Delete the business profile
        $businessProfile->delete();

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Business profile deleted successfully.'
        ], 200);
    }


    public function getMyData()
    {
        $businessProfile = Auth::user()->businessProfile; // Get the business profile from the authenticated user

        if (!$businessProfile) {
            return response()->json([
                'success' => false,
                'message' => 'No business profile found for this user.'
            ], 404);
        }

        return new businessProfileResource(true, 'Business profile retrieved successfully', $businessProfile);
    }
}
