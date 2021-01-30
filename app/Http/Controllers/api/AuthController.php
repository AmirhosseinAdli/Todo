<?php


namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register', 'login']]);
    }

    public function register(Request $request)
    {
        $user = User::create($request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]));

        return response()
            ->json([
               'code' => 200,
               'message' => 'User created successfully',
               'data' => new UserResource($user),
            ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'code' => 401,
                'message' => 'email or password is incorrect',
                'data' => null,
            ], 401);
        }
        return $this->respondWithToken('User logged in successfully',$token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth('api')->user();
        return response()->json([
            'code' => 200,
            'message' => 'It is me',
            'data' => new UserResource($user),
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'code' => 200,
            'message' => 'Successfully logged out',
            'data' => null,
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken('The token refreshed successfully',auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($message,$token)
    {
        return response()->json([
            'code' => 200,
            'message' => $message,
            'data' => [
                'access_token' => $token,
//                'token_type' => 'bearer',
//                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}
