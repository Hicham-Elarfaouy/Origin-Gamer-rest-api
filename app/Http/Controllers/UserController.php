<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *     name="User",
 *     description="API Endpoints of User Management"
 * )
 */
class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * @OA\Put(
     * path="/api/user",
     * operationId="UserUpdateInfo",
     * tags={"User"},
     * summary="Update information's",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "name"},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="email", type="email"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Login Successfully",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
        ]);

        $user = Auth::user();
        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully update user information\'s',
            'data' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update_password(Request $request): JsonResponse
    {
        $this->authorize('update_password');

        $request->validate([
            'old_password' => ['required', 'min:8'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully update password',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'incorrect old password',
            ], 406);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */

    /**
     * @OA\Delete(
     * path="/api/user",
     * operationId="UserDelete",
     * tags={"User"},
     * summary="Delete User",
     *     security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Login Successfully",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function destroy(): JsonResponse
    {
        $user = Auth::user();
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully delete user',
            'data' => $user,
        ]);
    }

    public function update_role(Request $request, User $user)
    {
        $this->authorize('update_role', $user);

        $request->validate([
            'role_id' => ['required', 'integer', 'exists:App\Models\Role,id'],
        ]);

        $user->role_id = $request->role_id;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully update user role',
            'data' => $user,
        ]);
    }
}
