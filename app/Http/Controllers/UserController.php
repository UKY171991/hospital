<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();
            if ($request->user_type) {
                $query->where('user_type', $request->user_type);
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $btn = $row->status == 'Active'
                        ? '<button class="btn btn-info btn-xs statusBtn" data-id="'.$row->id.'"><i class="fas fa-check"></i> Active</button>'
                        : '<button class="btn btn-warning btn-xs statusBtn" data-id="'.$row->id.'"><i class="fas fa-ban"></i> Deactivate</button>';
                    return $btn;
                })
                ->addColumn('action', function($row){
                    return '<button class="btn btn-primary btn-xs editBtn" data-id="'.$row->id.'"><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-xs deleteBtn" data-id="'.$row->id.'"><i class="fas fa-trash"></i> Delete</button>';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        $userTypes = User::select('user_type')->distinct()->pluck('user_type');
        return view('user.index', compact('userTypes'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return response()->json(['success' => true, 'message' => 'User created successfully.']);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return response()->json(['success' => true, 'message' => 'User updated successfully.']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status == 'Active' ? 'Deactivate' : 'Active';
        $user->save();
        return response()->json(['success' => true]);
    }
} 