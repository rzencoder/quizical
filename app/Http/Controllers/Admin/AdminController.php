<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Quiz;
use App\User;
use App\Category;

use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user();
        $quizzes = $user->quizzes()->get();
        $subjects = Category::$subjects;
        return view('teacher.dashboard', compact('quizzes', 'subjects'));
    }

    public function showChangePasswordForm()
    {
        return view('auth.adminchangepassword');
    }

    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->route('admin.dashboard')->with("status", "Password changed successfully!");

    }

    public function showChangeUserDetailsForm()
    {
        return view('auth.adminchangeuserdetails');
    }

    public function changeUserDetails(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'name' => 'required|string',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->name = $request->get('name');
        $user->save();

        return redirect()->route('admin.dashboard')->with("status", "Details changed successfully!");
    }
}
