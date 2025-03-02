<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    public function staffLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('staff-dashboard-page');
        }
        return redirect()->route('login-page')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function staffLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login-page')->with('success', 'You have successfully logged out.');
    }

    public function staffAccountUpdate(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'staff_name' => 'required|string',
            'staff_idno' => 'nullable|string',
        ], [], [
            'staff_name' => 'staff name',
            'staff_idno' => 'staff id number',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        try {
            $validated = $validator->validated();
            User::find($id)->update($validated);
            return back()->with('success', 'Account details updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function staffPasswordUpdate(Request $req, $id)
    {
        session()->flash('active_tab', 'profile-2');

        $validated = $req->validate(
            [
                'oldPass' => 'required | min:8',
                'newPass' => 'required | min:8',
                'renewPass' => 'required | same:newPass',
            ],
            [],
            [
                'oldPass' => 'Old Password',
                'newPass' => 'New Password',
                'renewPass' => 'Comfirm Password',

            ]
        );
        
        try {
            $check = Hash::check($validated['oldPass'], Auth::user()->password, []);
            if ($check) {
                User::find($id)->update(['password' => bcrypt($validated['renewPass'])]);
                return back()->with('success', 'Password has been updated successfully.');
            } else {
                return back()->with('error', 'Opps! You entered an incorrect old password. Please try again.');
            }
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
