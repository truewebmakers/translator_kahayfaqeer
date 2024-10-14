<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    VenueAddress
};
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Events\UserNotification;
use Illuminate\Support\Facades\Log;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // function __construct()
    // {
    //      $this->middleware('permission:user-management-access', ['only' => ['index','store','list','destroy','edit','update']]);
    // }

    // public function updateStatus(Request $request)
    // {
    //     $user = Auth::user();
    //     $status = $request->input('status');
    //     $site_admin_id = $request->input('site_admin_id');
    //     $user->status = $status;
    //     try {
    //         $event =  event(new UserNotification($status, $site_admin_id));
    //     } catch (\Exception $e) {
    //         Log::error("isue in ebve" . $e->getMessage());
    //     }

    //     $user->save();
    //     return response()->json(['message' => 'Status updated successfully']);
    // }




    public function uploadImage(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10000', // Adjust validation as needed
            ]);

            // Check if the request has an image file
            if ($request->hasFile('image')) {
                // Get the uploaded file
                $file = $request->file('image');

                // Upload the file to S3 and get the path
                $path = Storage::disk('s3')->putFile('avatars', $file);

                // Return the URL of the uploaded file
                return response()->json(['url' => Storage::disk('s3')->url($path)]);
            }

            return response()->json(['error' => 'No file uploaded'], 400);

        } catch (\Throwable $th) {
            // Return error message
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }




    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->get();
        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'user_level' => 'required',
            'language' => 'required'

        ]);


        $input = $request->all();

        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imageName = time() . 'profile_pic.' . $image->getClientOriginalExtension();
            Storage::disk('s3')->put('images/' . $imageName, file_get_contents($image));
            $input['profile_pic'] = $imageName;
        }


        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->first();
        return view('users.create', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'roles' => 'required',
            'user_level' => 'required',
            'language' => 'required'
        ]);


        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imageName = time() . 'profile_pic.' . $image->getClientOriginalExtension();
            Storage::disk('s3')->put('images/' . $imageName, file_get_contents($image));
            $input['profile_pic'] = $imageName;
            // $image->move(public_path('images'), $imageName);
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index') ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
