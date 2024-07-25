<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserloginController extends Controller
{
    public function index(){
        return view('user.registration');
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->role_id = 2;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            if ($request->hasFile('image')) {
                $user->addMediaFromRequest('image')
                    ->withResponsiveImages()
                    ->toMediaCollection('image');
            }
        }

        return redirect()->route('user.login')->with('success', 'Registration successful. Please log in.');
    }

    public function userLogin(){
        return view('user.login');
    }

    public function userLoginPost(Request $request){
        $user = User::where("email", $request->email)->first();
        if (!$user) {
            return redirect()->route('user.login')->with('error', 'User not found with the provided email');
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('user.login')->with('error', 'Your email and password do not match');
        }

        session()->put(['user' => $user, 'id' => $user->id]);
        if ($user->role_id == 1) {
            return redirect()->route('admin')->with('success', 'Login successful');
        } else {
            return redirect()->route('home.index')->with('success', 'You are a user');
        }
    }

    public function logout(Request $request){
        session()->forget(['user', 'id']);
        return redirect()->route('user.login')->with('success', 'Logged out successfully');
    }

    public function userHome(){
        return view('user.home');
    }

    public function userLoginGoogle(){

    }
}
