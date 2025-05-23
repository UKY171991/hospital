<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Show user management page
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();
            if ($request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('username', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhere('mobile', 'like', "%$search%")
                      ->orWhere('user_type', 'like', "%$search%")
                      ->orWhere('status', 'like', "%$search%")
                      ;
                });
            }
            $users = $query->orderBy('id', 'desc')->get();
            return response()->json(['users' => $users]);
        }
        return view('users.index');
    }

    // Store new user
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return response()->json(['success' => true, 'user' => $user]);
    }

    // Update user
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return response()->json(['success' => true, 'user' => $user]);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => true]);
    }

    // Get user for edit
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['user' => $user]);
    }
}
