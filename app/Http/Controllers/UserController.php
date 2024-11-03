<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Helper\JwtToken;


class UserController extends Controller
{
    function login()  {
        return view('front.login');
    }

    function Registration(){
        return view('front.register');
    }

    function regOTP(){
        return view ('front.otp_page');
    }



    public function userRegistration(Request $request) {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Check email uniqueness
            'password' => 'required|min:5|confirmed', // Ensure password_confirmation matches
            'mobile' => 'nullable|string|max:255', // Optional mobile field
            'designation' => 'nullable|string|max:255', // Optional designation field
            'image' => 'nullable|string|max:255', // Optional image field (could be a file upload as well)
        ]);

//exist user checking
$count=User::where('email',$request->input('email'))->count();

if ($count==1){

    return response()->json(['status'=>'failed','message'=>'user already exist'], 409);
}

else{

        try {
            // Create user
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')), // Hashing the password
                'mobile' => $request->input('mobile'), // Optional mobile field
                'designation' => $request->input('designation'), // Optional designation
                'image' => $request->input('image'), // Optional image (if provided)
            ]);

            $email=$request->input('email');
            $otp=rand(1000,9999);
            Mail::to($email)->send(mailable: new OtpMail($otp));
            User::where('email','=',$email)->update(['otp'=>$otp]);

            return response()->json(['message' => 'User registration successful', 'status' => 'success'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User registration failed', 'status' => 'failed'], 500);
        }
    }
    }
    public function UserLogin(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        try {
            // Retrieve the user by email
            $user = User::where('email', $request->input('email'))->first();

            // Check if user exists, if the password matches, and if email is verified
            if ($user && Hash::check($request->input('password'), $user->password)) {
                if ($user->email_verified == 1) {
                    $token = JWTToken::CreateToken($request->input('email'), $user->id);
                    return response()->json(['status' => 'success', 'message' => 'Login Success'], 201)->cookie('token',$token,time()+60*24*30);
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'Email not verified'], 403);
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Unauthorized'], 401);
            }
        }
        catch (\Exception $e) {
            // Log the error using the Log facade
            Log::error('Login Error: ' . $e->getMessage());

            // Return a generic error response to the user
            return response()->json(['status' => 'failed', 'message' => 'An unexpected error occurred.'], 500);
        }
    }


    function verifyRoute(){

        return view ('front.verify_otp');
    }

    function verifyOtp(Request $request){
$email=$request->input('email');
$otp=$request->input('otp');

$count=User::where('email','=',$email)->where('otp','=',$otp)->count();

if($count==1){

User::where('email','=',$email)->update(['otp'=>'0']);
User::where('email','=',$email)->update(['email_verified'=>'1']);
return response()->json(['status'=>'success','message'=>'otp sent'],201);
}
else{
return response()->json(['status'=>'failed','message'=>'unauthorized'],401);

}

    }



    function UserLogout(){
        return redirect('/login')->cookie('token','',-1);
    }


}











