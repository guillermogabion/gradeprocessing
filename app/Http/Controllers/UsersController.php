<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class UsersController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->input('search');
        $table_header = [
            '',
            'User ID',
            'Full Name',
            'Role',
            'Status',
            'Action'
        ];

        $items = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('userId', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $user = User::find(auth()->user()->id);

        return view('pages.users', [
            'test' => $user,
            'headers' => $table_header,
            'items' => $items,
            'search' => $search
        ]);
    }


    public function getEntities()
    {
        $entity = User::where('role', 'NOT LIKE', 'student')->get();

        return response()->json(['entity' => $entity]);
    }

    public function storeId(Request $request)
    {
        $request->validate([
            'userId' => 'required|string|max:255',
        ]);
        $user = new User();
        $user->userId = $request->input('userId');
        $user->save();

        return redirect()->route('organizations-users');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'userId' => 'required|string|max:255',
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = new User();
        $user->userId = $request->input('userId');
        $user->name = $request->input('name');
        $user->role = $request->input('role');
        $user->password = Hash::make($request->input('password')  ?? 'Password01!');

        if ($request->hasFile('profilePicture')) {
            $imageName = time() . '.' . $request->profilePicture->extension();
            $request->profilePicture->move(public_path('profile'), $imageName);
            $user->profile = $imageName;
        }

        $user->save();

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function update(Request $request)
    {
        // Validate the input data, including the image if provided
        $validated = $request->validate([
            'userId' => 'required|string|max:255',
            'role' => 'required|string',
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the image
        ]);

        // Find the user by ID
        $item = User::findOrFail($request->id);

        // If a profile picture is uploaded, store it and update the user's profile picture field
        if ($request->hasFile('profilePicture')) {
            $imageName = time() . '.' . $request->profilePicture->extension();
            $request->profilePicture->move(public_path('profile'), $imageName);
            $item->profile = $imageName;
        }

        // Update the user's other fields
        $item->fill($request->except('profilePicture')); // Exclude profilePicture from fill()

        // Save the updated user
        $item->save();

        // Redirect with a success message
        return redirect()->route('organizations-users')->with('success', 'User updated successfully');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|string|in:active,disabled',
        ]);

        $user = User::findOrFail($request->id);
        $user->status = $request->input('status');
        $user->save();

        return redirect()->route('organizations-users')->with('success', 'User status updated successfully');
    }


    public function self()
    {
        $user = User::with('details')->find(auth()->user()->id);
        $token = $user->createToken('authToken')->accessToken;
        return response(['user' => $user, 'access_token' => $token]);
    }

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'userId' => 'required',
            'password' => 'required',
        ]);

        // Attempt authentication
        if (!Auth::attempt(['userId' => $request->userId, 'password' => $request->password])) {
            return response(['message' => 'Login credentials are incorrect'], 401);
        }

        // Find the authenticated user and eager load the 'details' relationship
        $user = User::where('userId', $request->userId)->first();

        // Generate the access token
        $token = $user->createToken('authToken')->accessToken;

        // Return the response with user details and token
        return response(['user' => $user, 'access_token' => $token], 200);
    }


    public function logout(Request $request)
    {
        $request->user()->tokem()->delete();
    }
    public function indexMobile()
    {
        return User::get();
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Ensure $user is an instance of User
        if (!($user instanceof \App\Models\User)) {
            return response()->json(['error' => 'User instance is incorrect'], 500);
        }

        $user->password = Hash::make($request->input('password'));
        $user->status = 'old';
        $user->save(); // Save method should be available



        return response()->json(['message' => 'Password updated successfully.']);
    }

    public function validateToken(Request $request)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return Response::json(['error' => 'Token not provided'], 401);
        }

        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }

        $user = User::where('api_token', $token)->first();

        if ($user) {
            return Response::json(['valid' => true], 200);
        } else {
            return Response::json(['valid' => false], 401);
        }
    }


    public function storeApi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'userId' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|string',
        ]);

        $user = new User();
        $user->userId = $request->input('userId');
        $user->name = $request->input('name');
        $user->role = $request->input('role');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        return response()->json(['message' => 'Account created successfully.']);
    }

    public function createaccount(Request $request)
    {
        // Validate incoming request



        // dd($request);
        // Handle the profile file upload
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('profile'), $fileName);

            // Create the user
            $user = new User();
            $user->name = $request->input('name');
            $user->role = $request->input('role');
            $user->userId = $request->input('userId');
            $user->password = Hash::make($request->input('password'));
            $user->profile = $fileName;
            $user->save();

            // Generate an access token for the user
            $token = $user->createToken('authToken')->accessToken;

            // Return a JSON response with the user and token
            return response()->json([
                'user' => $user,
                'access_token' => $token
            ], 201);
        } else {
            return response()->json(['error' => 'Profile file is required.'], 400);
        }
    }
}
