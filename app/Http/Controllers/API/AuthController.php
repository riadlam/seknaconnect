<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'in:professional,public' // optional, default to professional
        ]);

        if (!isset($validated['role']) || empty($validated['role'])) {
            $validated['role'] = 'professional';
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // Get Logged-in User
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    /**
     * Get all non-admin users with optional role filtering
     *
     * @OA\Get(
     *     path="/api/admin/users",
     *     summary="Get all non-admin users with optional role filtering",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="role",
     *         in="query",
     *         description="Filter users by role (public, professional)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"public", "professional"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of non-admin users",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getUsers(Request $request)
    {
        // Check if user is admin
        if ($request->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized. Admin access required.'], 403);
        }

        $query = User::where('role', '!=', 'admin');

        // Filter by role if provided
        if ($request->has('role') && in_array($request->role, ['public', 'professional'])) {
            $query->where('role', $request->role);
        }

        // Filter by verification status if provided
        if ($request->has('is_verified')) {
            $query->where('is_verified', $request->is_verified);
        }

        // Get all matching users
        $users = $query->select(['id', 'name', 'email', 'role', 'phone', 'is_verified', 'email_verified_at', 'created_at', 'updated_at'])
                     ->orderBy('created_at', 'desc')
                     ->get();

        return response()->json($users);
    }

    /**
     * Delete a user
     *
     * @OA\Delete(
     *     path="/api/admin/users/{id}",
     *     summary="Delete a user",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    /**
     * Verify a user
     *
     * @OA\Post(
     *     path="/api/admin/users/{id}/verify",
     *     summary="Verify a user account",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User verified successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User verified successfully"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function verifyUser(Request $request, $id)
    {
        // Check if user is admin
        if ($request->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized. Admin access required.'], 403);
        }

        // Find the user to verify
        $user = User::where('id', $id)
                   ->where('role', '!=', 'admin') // Don't modify admin users
                   ->firstOrFail();

        // Update the user's verification status
        $user->is_verified = true;
        $user->save();

        return response()->json([
            'message' => 'User verified successfully',
            'user' => $user->only(['id', 'name', 'email', 'role', 'is_verified'])
        ]);
    }

    public function deleteUser(Request $request, $id)
    {
        // Check if user is admin
        if ($request->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized. Admin access required.'], 403);
        }

        // Find the user to delete
        $user = User::where('id', $id)
                   ->where('role', '!=', 'admin') // Prevent deleting admin users
                   ->firstOrFail();

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
