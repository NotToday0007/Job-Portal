<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse; // Add this import

class AccountController extends Controller
{


    function changeProfile() {
return view ('front.changeprofile');

    }

    public function showAccountSettings(Request $request)
    {
        // Extract email from the request header (assuming JWT token contains the email)
        $email = $request->header('email');

        // Fetch the user based on email
        $user = User::where('email', $email)->first();

        // If user not found, handle it accordingly (e.g., redirect to login)
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'User not found']);
        }

        // Pass the user to the view
        return view('front.layouts.sidebar', compact('user'));
    }

    function accountRoute(){

return view ('front.account');

    }

    function getProfile(Request $request){
            $email=$request->header('email');
            $user=User::where('email','=',$email)->first();
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
                'data' => $user
            ],200);
        }

        function updateProfile(Request $request){
            try{
                $email=$request->header('email');
                $name=$request->input('name');
                $designation=$request->input('designation');
                $mobile=$request->input('mobile');
                User::where('email','=',$email)->update([
                    'name'=>$name,
                    'designation'=>$designation,
                    'mobile'=>$mobile
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Request Successful',
                ],200);

            }catch (Exception $exception){
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Something Went Wrong',
                ],401);
            }
        }


        public function updatePassword(Request $request)
        {
            try {
                // Get the authenticated user's email from the request header
                $email = $request->header('email');

                // Get the old password, new password, and confirm password from the request
                $oldpass = $request->input('oldpass');
                $newpass = $request->input('newpass');

                // Find the user by email
                $user = User::where('email', $email)->first();

                // Check if user exists and the old password matches
                if ($user && Hash::check($oldpass, $user->password)) {

                    // Hash the new password before updating
                    $user->password = Hash::make($newpass);
                    $user->save();

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Password updated successfully'
                    ], 200);

                } else {
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'Old password is incorrect or user not found'
                    ], 401);
                }

            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Something went wrong: ' . $exception->getMessage()
                ], 500);
            }
        }




        public function updateProfilePicture(Request $request) {
            // Get the email from the request headers
            $email = $request->header('email');

            // Find the user by email
            $user = User::where('email', $email)->first();

            // Check if the user exists
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not found']);
            }

            if ($request->hasFile('image')) {
                // Validate the image
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
                ]);

                // Store the uploaded image in the 'public/uploads' directory
                $imagePath = $request->file('image')->store('uploads', 'public');

                // Update the user's profile image in the database
                $user->image = $imagePath;
                $user->save(); // Save the updated user information

                // Return the image URL to update the frontend
                return response()->json([
                    'status' => 'success',
                    'image' => asset('storage/' . $imagePath) // Correct URL to access the uploaded image
                ]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'No image uploaded']);
            }
        }


        public function getProfilePic(Request $request) {
            $email = $request->header('email');
            $user = User::where('email', $email)->first();

            // Return user's image or a default image if not found
            return response()->json([
                'image_url' => $user && $user->image ? asset($user->image) : asset('assets/images/avatar7.png')
            ]);
        }





        public function UpdateProduct(Request $request): JsonResponse
        {
            $email = $request->header('email');

            if ($request->hasFile('image')) {
                // Upload New File
                $img = $request->file('image');
                $t = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "{$email}-{$t}-{$file_name}";
                $img_url = "uploads/{$img_name}";
                $img->move(public_path('uploads'), $img_name);

                // Delete Old File
                $filePath = $request->input('file_path');
                if ($filePath) {
                    File::delete($filePath);
                }

                // Update Product
                User::where('email', $email)->update([
                    'image' => $img_url,
                ]);

                // Return success message in JSON
                return response()->json([
                    'message' => 'Profile updated successfully',
                    'image_url' => asset($img_url), // This should return the image URL correctly
                ], 201);
            }

            // Return error if no image file found
            return response()->json(['message' => 'No image file found'], 400);
        }

    }








