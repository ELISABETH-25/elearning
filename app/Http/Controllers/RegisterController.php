<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;


class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
            // 'role' => 'required|in:admin,teacher,student'
        ]);

        // auto set role to admin
        $validatedData['role'] = 'admin';

        User::create($validatedData);

        Alert::success('Success', 'Registration successfull! Please login');
        return redirect('/login')->with('success', 'Registration successfull! Please login');
    }
}
