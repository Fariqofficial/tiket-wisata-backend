<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     //Index of User List
    public function index(Request $request)
    {
        //Search Function
        $users = DB::table('users')->when($request->keyword, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->keyword}%")
            ->orWhere('email', 'like', "%{$request->keyword}%")
            ->orWhere('phone', 'like', "%{$request->keyword}%");
        })->orderBy('id', 'desc')->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    //Route for Create New User Screen
    public function create()
    {
        return view('pages.users.create');
    }

    //Route for Edit User Screen
    public function edit(User $user) {
        return view('pages.users.edit', compact('user'));
    }

    //Update User Data
    public function update(Request $request, User $user)
    {
        //Find user first before update
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        //Check if phone number not empty
        if($request->phone) {
            $user->update(['phone' => $request->phone]);
        }
        //Check if password not empty
        if($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }
        return redirect()->route('users.index')->with('success', 'Update User Successfully');
    }

    //Store User Data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:7',
            'phone' => 'required',
            'role' => 'required'
        ]);

        //If all request filled
        User::create($request->all());
        return redirect()->route('users.index')->with('success', 'Create User Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    //Remove User Data
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Delete User Successfully');
    }
}
